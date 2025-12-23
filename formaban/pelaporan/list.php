<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
include __DIR__ . '/../sidebar.php';
require_once __DIR__ . '/../../koneksi.php';

$q = $koneksi->query("SELECT * FROM laporan ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Pelaporan Mahasiswa</title>

<style>
body {
    margin:0;
    padding-left:240px;
    background:#eef1f7;
    font-family: "Segoe UI", Arial, sans-serif;
}

.content {
    padding:35px;
}

h2 {
    margin-bottom:25px;
    font-size:28px;
    font-weight:600;
    color:#333;
}

.card {
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.06);
}

table {
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

th {
    background:#0d6efd;
    color:white;
    padding:12px;
    font-size:14px;
    text-align:left;
}

td {
    padding:12px;
    border-bottom:1px solid #e5e5e5;
    font-size:14px;
}

tr:hover td {
    background:#f9fbff;
}

.btn {
    padding:7px 12px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:13px;
    display:inline-block;
}

.btn-detail {
    background:#0d6efd;
}

.btn-detail:hover {
    background:#0b5ed7;
}

.btn-tindak {
    background:#198754;
}

.btn-tindak:hover {
    background:#157347;
}

.badge {
    padding:6px 10px;
    border-radius:6px;
    font-size:12px;
    color:white;
    font-weight:600;
}

.belum { background:#f1c40f; }
.ditinjau { background:#3498db; }
.ditindak { background:#2ecc71; }

.table-container {
    overflow-x:auto;
}
</style>

</head>
<body>

<div class="content">
    <h2>📄 Daftar Pelaporan Mahasiswa</h2>

    <div class="card">
        <div class="table-container">
            <table>
                <tr>
                    <th>Pelapor</th>
                    <th>Terlapor</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>

                <?php while($row = $q->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
                    <td><?= htmlspecialchars($row['nama_terlapor']) ?></td>
                    <td><?= htmlspecialchars($row['jurusan']) ?></td>
                    <td>
                        <span class="badge
                            <?= $row['status']=='Belum Ditinjau' ? 'belum' :
                                ($row['status']=='Sudah Ditinjau' ? 'ditinjau' : 'ditindak') ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a class="btn btn-detail" href="detail.php?id=<?= $row['id_laporan'] ?>">
                            Detail
                        </a>

                        <a class="btn btn-tindak" href="tindaklanjut.php?id=<?= $row['id_laporan'] ?>">
                            Tindak Lanjut
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

            </table>
        </div>
    </div>

</div>

</body>
</html>
