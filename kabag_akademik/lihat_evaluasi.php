<?php
session_start();
include __DIR__ . '/../koneksi.php';
include '../protect.php';
check_level(13); // Kabag Akademik

// ==== PROSES VERIFIKASI ====
if (isset($_GET['verifikasi'])) {
    $id = intval($_GET['verifikasi']);
    mysqli_query($koneksi, "UPDATE evaluasi SET status_verifikasi='Diterima' WHERE id_eval=$id");
    header("Location: lihat_evaluasi.php?msg=verified");
    exit;
}

if (isset($_GET['unverified'])) {
    $id = intval($_GET['unverified']);
    mysqli_query($koneksi, "UPDATE evaluasi SET status_verifikasi='Belum Diverifikasi' WHERE id_eval=$id");
    header("Location: lihat_evaluasi.php?msg=unverified");
    exit;
}

if (isset($_GET['batalkan'])) {
    $id = intval($_GET['batalkan']);
    mysqli_query($koneksi, "UPDATE evaluasi SET status_verifikasi=NULL WHERE id_eval=$id");
    header("Location: lihat_evaluasi.php?msg=cancelled");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_begin_transaction($koneksi);
    try {
        $q = mysqli_query($koneksi, "SELECT id_mahasiswa_kip FROM evaluasi WHERE id_eval=$id");
        $row = mysqli_fetch_assoc($q);
        if ($row) {
            $idm = (int)$row['id_mahasiswa_kip'];
            $qf = mysqli_query($koneksi, "SELECT file_eval FROM file_eval WHERE id_mahasiswa_kip=$idm");
            while ($f = mysqli_fetch_assoc($qf)) {
                $path = __DIR__ . '/../uploads/evaluasi/' . $f['file_eval'];
                if (file_exists($path)) unlink($path);
            }
            mysqli_query($koneksi, "DELETE FROM file_eval WHERE id_mahasiswa_kip=$idm");
            mysqli_query($koneksi, "DELETE FROM keluarga WHERE id_mahasiswa_kip=$idm");
            mysqli_query($koneksi, "DELETE FROM transportasi WHERE id_mahasiswa_kip=$idm");
            mysqli_query($koneksi, "DELETE FROM evaluasi WHERE id_eval=$id");
        }
        mysqli_commit($koneksi);
        header("Location: lihat_evaluasi.php?msg=deleted");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "Gagal hapus: " . $e->getMessage();
    }
}

// ==== QUERY DATA ====
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
    <title>Data Evaluasi - Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f2ff;
            margin: 0;
            color: #333;
        }

        .content {
            margin-left: 240px;
            padding: 40px;
            min-height: 100vh;
            transition: 0.3s ease;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
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
            left: 0; bottom: -5px;
            width: 50px; height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-green { background: #e8f5e9; color: #2e7d32; }
        .btn-green:hover { background: #2e7d32; color: white; transform: translateY(-2px); }
        
        .btn-red { background: #ffebee; color: #c62828; }
        .btn-red:hover { background: #c62828; color: white; transform: translateY(-2px); }

        .search-card {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            flex-grow: 1;
            padding: 12px 20px;
            border-radius: 12px;
            border: 2px solid #f0e6ff;
            outline: none;
            font-family: inherit;
            transition: 0.3s;
        }
        .search-input:focus { border-color: #7b35d4; }

        .table-container {
            background: white;
            padding: 15px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow-x: auto;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th {
            background: #4e0a8a;
            color: white;
            padding: 18px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }

        th:first-child { border-radius: 12px 0 0 12px; }
        th:last-child { border-radius: 0 12px 12px 0; }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fbf9ff; }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
        }
        .verified { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .unverified { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
        .pending { background: #fff8e1; color: #ffa000; border: 1px solid #ffe082; }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-view { background: #e3f2fd; color: #1976d2; }
        .btn-pdf { background: #fff3e0; color: #e65100; }
        .btn-cancel { background: #f5f5f5; color: #757575; }

        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 85px 15px 40px 15px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Data Evaluasi Mahasiswa</h2>
        <div class="action-btns">
            <a href="verifikasi_all.php" class="btn btn-green" onclick="return confirm('Diterima semua?')"><i class="fas fa-check-double"></i> Verifikasi Semua</a>
            <a href="hapus_all.php" class="btn btn-red" onclick="return confirm('Hapus semua data?')"><i class="fas fa-trash-alt"></i> Hapus Semua</a>
        </div>
    </div>

    <form method="GET" class="search-card">
        <i class="fas fa-search" style="color: #7b35d4; margin-right: 5px;"></i>
        <input type="text" name="keyword" class="search-input" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" placeholder="Cari Nama Mahasiswa atau NPM...">
        <button type="submit" class="btn" style="background: #4e0a8a; color: white;">Cari</button>
        <?php if(isset($_GET['keyword']) && $_GET['keyword'] != ''): ?>
            <a href="lihat_evaluasi.php" class="btn" style="background: #eee; color: #666;">Reset</a>
        <?php endif; ?>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">No</th>
                    <th>Mahasiswa</th>
                    <th>Prodi / Jurusan</th>
                    <th style="text-align:center;">File Evaluasi</th>
                    <th style="text-align:center;">PDF Form</th>
                    <th style="text-align:center;">Verifikasi</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result && mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pathEval = '../uploads/evaluasi/' . ($row['file_eval'] ?? '');
                ?>
                <tr>
                    <td style="text-align:center; font-weight: 700; color: #999;"><?= $no++ ?></td>
                    <td>
                        <div style="font-weight: 700; color: #4e0a8a;"><?= htmlspecialchars($row['nama_mahasiswa']) ?></div>
                        <div style="font-size: 0.8rem; color: #888;">NPM: <?= htmlspecialchars($row['npm']) ?></div>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem; color: #555;"><?= htmlspecialchars($row['program_studi']) ?></div>
                        <div style="font-size: 0.75rem; color: #999;"><?= htmlspecialchars($row['jurusan']) ?></div>
                    </td>
                    <td style="text-align:center;">
                        <?php if(!empty($row['file_eval'])): ?>
                            <a href="<?= $pathEval ?>" target="_blank" class="btn-action btn-view">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        <?php else: ?>
                            <span style="color:#ccc;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <a href="generate_pdf.php?id=<?= $row['id_eval'] ?>" class="btn-action btn-pdf">
                            <i class="fas fa-file-pdf"></i> Generate
                        </a>
                    </td>
                    <td style="text-align:center;">
                        <?php if($row['status_verifikasi'] === 'Diterima'): ?>
                            <span class="badge verified">Verified</span><br>
                            <a href="?batalkan=<?= $row['id_eval'] ?>" class="btn-action btn-cancel" style="margin-top: 5px; display: inline-block;">Batalkan</a>
                        <?php elseif($row['status_verifikasi'] === 'Belum Diverifikasi'): ?>
                            <span class="badge unverified">Unverified</span><br>
                            <a href="?batalkan=<?= $row['id_eval'] ?>" class="btn-action btn-cancel" style="margin-top: 5px; display: inline-block;">Batalkan</a>
                        <?php else: ?>
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <a href="?unverified=<?= $row['id_eval'] ?>" class="btn-action btn-red" style="padding: 4px 8px;">X</a>
                                <a href="?verifikasi=<?= $row['id_eval'] ?>" class="btn-action btn-green" style="padding: 4px 8px;">OK</a>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <a href="?hapus=<?= $row['id_eval'] ?>" onclick="return confirm('Yakin hapus data ini?')" style="color: #c62828;">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php } } else { ?>
                    <tr><td colspan="7" style="text-align:center; padding: 40px; color: #999; font-style: italic;">Belum ada data evaluasi.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
