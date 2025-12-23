<?php
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

$q = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id_admin ASC");
?>

<style>
body {
    background: #efeaff;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
}

.content-wrapper {
    margin-left: 260px;
    padding: 35px;
}

/* HEADER CARD */
.header-card {
    background: #ffffff;
    padding: 28px;
    border-radius: 18px;
    border-left: 10px solid #6a0dad;
    box-shadow: 0 6px 22px rgba(106, 13, 173, 0.18);
    margin-bottom: 25px;
}

.header-card h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
    color: #4e0a8a;
}

/* ADD BUTTON */
.btn-add {
    background: #6a0dad;
    color: white;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
}

.btn-add:hover {
    background: #4e0a8a;
}

/* TABLE CARD */
.table-card {
    background: white;
    padding: 25px;
    border-radius: 18px;
    margin-top: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* TABLE */
.styled-table {
    width: 100%;
    border-collapse: collapse;
}

.styled-table thead tr {
    background: #6a0dad;
    color: white;
}

.styled-table th,
.styled-table td {
    padding: 14px 16px;
    text-align: center;
    font-size: 14px;
}

.styled-table tbody tr {
    background: #fbf7ff;
    border-bottom: 8px solid #ffffff;
    transition: 0.2s;
}

.styled-table tbody tr:hover {
    background: #f0e4ff;
    transform: scale(1.002);
}

/* BUTTONS */
.btn-action {
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
    font-size: 13px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
}

.btn-edit {
    background: #2ecc71;
}
.btn-edit:hover {
    background: #27ae60;
}

.btn-delete {
    background: #e74c3c;
}
.btn-delete:hover {
    background: #c0392b;
}

/* BADGE LEVEL */
.level-badge {
    padding: 6px 14px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 12px;
}

.lvl-11 { background: #8e44ad; }
.lvl-12 { background: #2980b9; }
.lvl-13 { background: #d35400; }

</style>

<div class="content-wrapper">

    <div class="header-card">
        <h2>👤 Manajemen User</h2>
    </div>

    <a href="user_add.php" class="btn-add">+ Tambah User</a>

    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php while($d = mysqli_fetch_array($q)){ 
                    $level = intval($d['level']);
                    $badgeClass = "lvl-$level";
                ?>
                <tr>
                    <td><?= htmlspecialchars($d['nama_lengkap']); ?></td>
                    <td><?= htmlspecialchars($d['username']); ?></td>
                    <td>
                        <span class="level-badge <?= $badgeClass ?>">
                            Level <?= $d['level'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="user_edit.php?id=<?= $d['id_admin']; ?>" class="btn-action btn-edit">Edit</a>
                        <a href="user_delete.php?id=<?= $d['id_admin']; ?>" 
                           class="btn-action btn-delete"
                           onclick="return confirm('Apakah yakin ingin menghapus user ini?');">
                           Hapus
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
