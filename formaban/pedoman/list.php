<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
include __DIR__ . '/../sidebar.php';

// KONEKSI
require_once __DIR__ . '/../../koneksi.php';

$admin = getAdmin();

$q = $koneksi->query("
    SELECT p.*, a.nama_lengkap 
    FROM pedoman p
    LEFT JOIN admin a ON p.id_admin = a.id_admin
    ORDER BY p.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Pedoman</title>

<style>
body {
    margin:0;
    padding-left:240px;
    background:#eef1f5;
    font-family: 'Segoe UI', Arial, sans-serif;
}

.container {
    padding:30px;
}

.card {
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

.card h2 {
    margin-top:0;
    margin-bottom:15px;
    font-size:24px;
    font-weight:600;
    color:#333;
}

.btn {
    padding:8px 14px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:14px;
    transition:0.2s;
}

.btn:hover {
    opacity:0.85;
}

.btn-primary { background:#0d6efd; }
.btn-danger { background:#dc3545; }
.btn-success { background:#198754; }

table {
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
}

th {
    background:#0d6efd;
    color:white;
    padding:12px;
    font-size:15px;
    text-align:left;
}

td {
    padding:12px;
    border-bottom:1px solid #eee;
    background:white;
}

tr:hover td {
    background:#f6f9ff;
}

.badge {
    padding:5px 10px;
    color:white;
    border-radius:6px;
    font-size:13px;
    text-transform:capitalize;
}

.pending { background:#f1c40f; }
.approved { background:#27ae60; }
.rejected { background:#e74c3c; }
</style>

</head>
<body>

<div class="container">
    <div class="card">
        <h2>📄 Daftar Pedoman</h2>

        <a class="btn btn-primary" href="tambah.php">+ Upload Pedoman</a>
        <br><br>

        <table>
            <tr>
                <th>File</th>
                <th>Pembuat</th>
                <th>Status</th>
                <th>Tanggal Upload</th>
                <th>Aksi</th>
            </tr>

            <?php while($row = $q->fetch_assoc()): ?>
            <tr>
                <td>
                    <a href="/KIPWEB/<?= $row['file_path'] ?>" target="_blank" style="color:#0d6efd; font-weight:600;">
                        <?= htmlspecialchars($row['nama_file']) ?>
                    </a>
                </td>

                <td><?= $row['nama_lengkap'] ?></td>

                <td>
                    <span class="badge <?= $row['status'] ?>">
                        <?= $row['status'] ?>
                    </span>
                </td>

                <td><?= $row['tanggal_upload'] ?></td>

                <td>
                    <a class="btn btn-danger"
                       onclick="return confirm('Hapus file pedoman ini?')"
                       href="hapus.php?id=<?= $row['id_pedoman'] ?>">Hapus</a>

                    <?php if (in_array($admin['role'], ['pengelola_kip','kabag','superadmin'])): ?>
                    <a class="btn btn-success"
                       href="validasi.php?id=<?= $row['id_pedoman'] ?>">Validasi</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>
</div>

</body>
</html>
