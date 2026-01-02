<?php 
include "../koneksi.php";
include "protect.php";
include "sidebar.php";

if (!empty($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $koneksi->prepare("DELETE FROM mahasiswa_kip WHERE id_mahasiswa_kip=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil dihapus'); window.location='mahasiswa_kip.php';</script>";
    exit;
}

// Hitung total mahasiswa
$totalResult = $koneksi->query("SELECT COUNT(*) as total FROM mahasiswa_kip");
$total = $totalResult ? $totalResult->fetch_assoc()['total'] : 0;

// ================= SEARCH + FILTER =================
$keyword = isset($_GET['keyword']) ? $koneksi->real_escape_string($_GET['keyword']) : '';
$status_filter  = isset($_GET['status']) ? $koneksi->real_escape_string($_GET['status']) : '';

$query = "SELECT * FROM mahasiswa_kip WHERE 1";

if ($keyword != '') {
    $query .= "
        AND (
            npm LIKE '%$keyword%' OR
            nama_mahasiswa LIKE '%$keyword%' OR
            program_studi LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'
        )
    ";
}

if ($status_filter != '') {
    $query .= " AND status = '$status_filter' ";
}

$query .= " ORDER BY id_mahasiswa_kip DESC";
$q = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa KIP-K</title>
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

        .stats-summary {
            background: rgba(123, 53, 212, 0.1);
            padding: 10px 20px;
            border-radius: 12px;
            display: inline-block;
            margin-top: 15px;
            color: #4e0a8a;
            font-weight: 600;
        }

        /* ===== Buttons & Actions ===== */
        .action-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-group-top {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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

        .btn-add { background: #4CAF50; }
        .btn-add:hover { background: #3d8b3f; transform: translateY(-2px); }

        .btn-update-data { background: #6a11cb; }
        .btn-update-data:hover { background: #5a0eb3; transform: translateY(-2px); }

        .btn-delete-all { background: #d32f2f; }
        .btn-delete-all:hover { background: #b71c1c; transform: translateY(-2px); }

        /* ===== Search & Filter ===== */
        .filter-form {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .form-input {
            flex: 1;
            min-width: 200px;
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-family: inherit;
        }

        .form-select {
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: white;
            font-family: inherit;
        }

        .btn-search {
            background: #4e0a8a;
            padding: 10px 25px;
        }

        /* ===== Table ===== */
        .table-responsive {
            background: white;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow-x: auto;
            margin-top: 25px;
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

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
        }

        tr:hover td { background: #fbf9ff; }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .pending { background: #fff8e1; color: #ffa000; }
        .approved { background: #e8f5e9; color: #2e7d32; }
        .rejected { background: #ffebee; color: #c62828; }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: 0.3s;
        }
        .btn-edit { background: #ffa000; }
        .btn-edit:hover { background: #e68a00; transform: scale(1.1); }
        .btn-hapus { background: #f44336; }
        .btn-hapus:hover { background: #d32f2f; transform: scale(1.1); }

        /* Responsive Mobile */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
            .header-section h2 { font-size: 22px; }
            .action-header { flex-direction: column; align-items: stretch; }
            .filter-form { flex-direction: column; }
            .btn-group-top { justify-content: space-between; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Data Mahasiswa Penerima KIP-K</h2>
        <div class="stats-summary">
            <i class="fas fa-users"></i> Total Mahasiswa: <?= $total; ?>
        </div>
    </div>

    <div class="action-header">
        <div class="btn-group-top">
            <a href="mahasiswa_kip_add.php" class="btn btn-add">
                <i class="fas fa-plus-circle"></i> Tambah Mahasiswa
            </a>
            <a href="mahasiswa_kip_update.php" class="btn btn-update-data">
                <i class="fas fa-sync-alt"></i> Update Masal (Excel)
            </a>
            <a href="hapus_semua_mahasiswa.php" class="btn btn-delete-all" onclick="return confirm('PERINGATAN! Anda ingin menghapus SEMUA data mahasiswa sesuai Tahun,Jurusan,Prodi dan NPM. Lanjutkan?')">
                <i class="fas fa-trash-alt"></i> Hapus Semua Sesuai Tahun,Jurusan,Prodi dan NPM
            </a>
        </div>
    </div>

    <!-- Search & Filter Area -->
    <form method="GET" class="filter-form">
        <input type="text" name="keyword" class="form-input" placeholder="Cari NPM, Nama, atau Prodi..." value="<?= htmlspecialchars($keyword); ?>">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="pending" <?= $status_filter == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="approved" <?= $status_filter == 'approved' ? 'selected' : '' ?>>Approved</option>
            <option value="rejected" <?= $status_filter == 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
        <button type="submit" class="btn btn-search">
            <i class="fas fa-search"></i> Cari Data
        </button>
        <?php if($keyword != '' || $status_filter != ''): ?>
            <a href="mahasiswa_kip.php" class="btn" style="background:#888;">Reset</a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NPM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Prodi</th>
                    <th>Jurusan</th>
                    <th>Thn</th>
                    <th>Skema</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($q && $q->num_rows > 0) {
                    $no = 1;
                    while ($d = $q->fetch_assoc()):
                        $statusClass = strtolower($d['status']);
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td style="font-weight: 600;"><?= htmlspecialchars($d['npm']); ?></td>
                    <td style="color: #4e0a8a; font-weight: 600;"><?= htmlspecialchars($d['nama_mahasiswa']); ?></td>
                    <td><?= htmlspecialchars($d['program_studi']); ?></td>
                    <td><?= htmlspecialchars($d['jurusan']); ?></td>
                    <td><?= htmlspecialchars($d['tahun']); ?></td>
                    <td><small><?= htmlspecialchars($d['skema']); ?></small></td>
                    <td>
                        <span class="status-badge <?= $statusClass ?>"><?= $d['status'] ?></span>
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="mahasiswa_kip_edit.php?id=<?= $d['id_mahasiswa_kip']; ?>" class="btn-action btn-edit" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="mahasiswa_kip.php?hapus=<?= $d['id_mahasiswa_kip']; ?>" class="btn-action btn-hapus" title="Hapus Data" onclick="return confirm('Yakin ingin hapus data ini?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php 
                    endwhile;
                } else {
                    echo "<tr><td colspan='9' style='text-align:center; padding: 40px;'>Data tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
