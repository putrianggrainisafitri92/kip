<?php
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['12', '13'])) {
    die("Akses ditolak!");
}

// ==== PROSES VERIFIKASI ====
if (isset($_GET['verifikasi'])) {
    $id = intval($_GET['verifikasi']);
    mysqli_query($koneksi, "
        UPDATE evaluasi 
        SET status_verifikasi='Diterima' 
        WHERE id_eval=$id
    ");
    header("Location: evaluasi_list.php");
    exit;
}

if (isset($_GET['unverified'])) {
    $id = intval($_GET['unverified']);
    mysqli_query($koneksi, "
        UPDATE evaluasi 
        SET status_verifikasi='Belum Diverifikasi' 
        WHERE id_eval=$id
    ");
    header("Location: evaluasi_list.php");
    exit;
}

if (isset($_GET['batalkan'])) {
    $id = intval($_GET['batalkan']);
    mysqli_query($koneksi, "
        UPDATE evaluasi 
        SET status_verifikasi=NULL 
        WHERE id_eval=$id
    ");
    header("Location: evaluasi_list.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    mysqli_begin_transaction($koneksi);

    try {
        $q = mysqli_query($koneksi, "SELECT id_mahasiswa_kip FROM evaluasi WHERE id_eval=$id");
        $row = mysqli_fetch_assoc($q);

        if (!$row) {
            throw new Exception("Data tidak ditemukan");
        }

        $idm = (int)$row['id_mahasiswa_kip'];

        $qf = mysqli_query($koneksi, "SELECT file_eval FROM file_eval WHERE id_mahasiswa_kip=$idm");
        while ($f = mysqli_fetch_assoc($qf)) {
            $path = __DIR__ . '/../uploads/evaluasi/' . $f['file_eval'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        mysqli_query($koneksi, "DELETE FROM file_eval WHERE id_mahasiswa_kip=$idm");
        mysqli_query($koneksi, "DELETE FROM keluarga WHERE id_mahasiswa_kip=$idm");
        mysqli_query($koneksi, "DELETE FROM transportasi WHERE id_mahasiswa_kip=$idm");
        mysqli_query($koneksi, "DELETE FROM evaluasi WHERE id_eval=$id");

        mysqli_commit($koneksi);

        header("Location: evaluasi_list.php?deleted=1");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "Gagal hapus: " . $e->getMessage();
    }
}

$where = "";
if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    $where = "WHERE m.nama_mahasiswa LIKE '%$keyword%' OR m.npm LIKE '%$keyword%'";
}

$sql = "SELECT e.*, m.nama_mahasiswa, m.npm, m.program_studi, m.jurusan, fe.file_eval
        FROM evaluasi e
        JOIN mahasiswa_kip m ON e.id_mahasiswa_kip = m.id_mahasiswa_kip
        LEFT JOIN file_eval fe ON e.id_mahasiswa_kip = fe.id_mahasiswa_kip
        $where
        ORDER BY e.submitted_at DESC";

$result = mysqli_query($koneksi, $sql);

include 'sidebar.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Evaluasi Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f2ff;
            margin: 0;
            color: #333;
        }

        .content {
            margin-left: 230px;
            padding: 40px;
            min-height: 100vh;
            transition: 0.3s ease;
        }

        .header-section {
            margin-bottom: 30px;
        }

        .header-section h2 {
            color: #4e0a8a;
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            position: relative;
        }
        .header-section h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 50px;
            height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            color: white;
        }
        .btn-verify-all { background: #4caf50; }
        .btn-delete-all { background: #f44336; }
        .btn:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* Search Area */
        .search-area {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
        }
        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-family: inherit;
        }
        .btn-search { background: #4e0a8a; color: white; padding: 10px 25px; }

        /* Table */
        .table-responsive {
            background: white;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th {
            background: #4e0a8a;
            color: white;
            padding: 18px 15px;
            font-size: 13px;
            text-transform: uppercase;
            text-align: left;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
            vertical-align: middle;
        }

        tr:hover td { background: #fbf9ff; }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }
        .v-verified { background: #e8f5e9; color: #2e7d32; }
        .v-unverified { background: #ffebee; color: #c62828; }
        .v-none { background: #f5f5f5; color: #777; }

        .btn-action-sm {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
        }
        .bg-verify { background: #e8f5e9; color: #2e7d32; border: 1px solid #2e7d32; }
        .bg-unverify { background: #ffebee; color: #c62828; border: 1px solid #c62828; }
        .bg-cancel { background: #f5f5f5; color: #666; border: 1px solid #ccc; }
        .bg-pdf { background: #e3f2fd; color: #1976d2; border: 1px solid #1976d2; }
        .bg-view { background: #fff8e1; color: #ffa000; border: 1px solid #ffa000; }
        .bg-hapus { background: #f44336; color: white; }

        .btn-action-sm:hover { filter: brightness(0.9); transform: scale(1.05); }

        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
            .top-actions { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Data Evaluasi Mahasiswa</h2>
    </div>

    <div class="top-actions">
        <div class="btn-group">
            <a href="verifikasi_all.php" class="btn btn-verify-all" onclick="return confirm('Verifikasi semua data yang ada?')">
                <i class="fas fa-check-double"></i> Verifikasi Semua
            </a>
            <a href="hapus_all.php" class="btn btn-delete-all" onclick="return confirm('Lanjutkan menghapus SEMUA data evaluasi?')">
                <i class="fas fa-trash-alt"></i> Hapus Semua
            </a>
        </div>
        <form method="GET" style="display:flex; gap:10px; flex:1; max-width: 400px;">
            <input type="text" name="keyword" class="search-input" placeholder="Cari Nama atau NPM..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
            <button type="submit" class="btn btn-search">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Mahasiswa</th>
                    <th>Prodi / Jurusan</th>
                    <th>File Dokumen</th>
                    <th>Form Evaluasi</th>
                    <th>Status Verifikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                        $pathEvaluasi  = '../uploads/evaluasi/' . ($row['file_eval'] ?? '');
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <div style="font-weight: 600; color: #4e0a8a;"><?= htmlspecialchars($row['nama_mahasiswa']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($row['npm']) ?></small>
                    </td>
                    <td>
                        <small><?= htmlspecialchars($row['program_studi']) ?></small><br>
                        <small class="text-muted"><?= htmlspecialchars($row['jurusan']) ?></small>
                    </td>
                    <td>
                        <?php if(!empty($row['file_eval'])): ?>
                            <a href="<?= $pathEvaluasi ?>" target="_blank" class="btn-action-sm bg-view">
                                <i class="fas fa-file-pdf"></i> Lihat PDF
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="generate_pdf.php?id=<?= $row['id_eval'] ?>" class="btn-action-sm bg-pdf">
                            <i class="fas fa-print"></i> Generate Form
                        </a>
                    </td>
                    <td>
                        <?php if ($row['status_verifikasi'] === 'Diterima'): ?>
                            <div style="display:flex; flex-direction:column; gap:5px; align-items:flex-start;">
                                <span class="status-badge v-verified">VERIFIED</span>
                                <a href="?batalkan=<?= $row['id_eval'] ?>" class="btn-action-sm bg-cancel">Batalkan</a>
                            </div>
                        <?php elseif ($row['status_verifikasi'] === 'Belum Diverifikasi'): ?>
                            <div style="display:flex; flex-direction:column; gap:5px; align-items:flex-start;">
                                <span class="status-badge v-unverified">UNVERIFIED</span>
                                <a href="?batalkan=<?= $row['id_eval'] ?>" class="btn-action-sm bg-cancel">Batalkan</a>
                            </div>
                        <?php else: ?>
                            <div style="display:flex; gap:5px;">
                                <a href="?verifikasi=<?= $row['id_eval'] ?>" class="btn-action-sm bg-verify">Verify</a>
                                <a href="?unverified=<?= $row['id_eval'] ?>" class="btn-action-sm bg-unverify">Unverify</a>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?hapus=<?= $row['id_eval'] ?>" class="btn-action-sm bg-hapus" onclick="return confirm('Hapus data evaluasi mahasiswa ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php 
                    endwhile;
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding:40px; color:#999;'>Belum ada data evaluasi.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
