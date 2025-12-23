<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();

require_once __DIR__ . '/../../koneksi.php';

$admin = getAdmin();

// Ambil semua berita
$sql = "SELECT b.*, a.nama_lengkap 
        FROM berita b 
        LEFT JOIN admin a ON a.id_admin = b.approved_by
        ORDER BY b.id_berita DESC";
$result = mysqli_query($koneksi, $sql);
?>

<?php include __DIR__ . '/../sidebar.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Berita</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f4f6f9;
    }
    .content {
        margin-left: 260px;
        padding: 25px;
    }
    h2 {
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 0 6px rgba(0,0,0,0.08);
    }
    th {
        background: #0d6efd;
        color: white;
        padding: 12px;
        text-align: left;
    }
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    tr:hover {
        background: #eef3ff;
    }
    .btn {
        padding: 6px 10px;
        font-size: 13px;
        text-decoration: none;
        border-radius: 5px;
        color: white;
    }
    .edit {
        background: #198754;
    }
    .delete {
        background: #dc3545;
    }
</style>

</head>
<body>

<div class="content">

    <h2>Daftar Berita</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Disetujui Oleh</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['id_berita'] ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['nama_lengkap'] ? $row['nama_lengkap'] : '-' ?></td>

            <td>
                <a class="btn edit" href="edit.php?id=<?= $row['id_berita'] ?>">Edit</a>
                <a class="btn delete" 
                   href="hapus.php?id=<?= $row['id_berita'] ?>" 
                   onclick="return confirm('Hapus berita ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>
