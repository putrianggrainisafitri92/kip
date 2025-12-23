<?php
session_start();
if ($_SESSION['admin_role'] !== 'superadmin') { 
    die("Akses ditolak!"); 
}

include '../koneksi.php';

/* ============================
   TAMBAH ADMIN
=============================== */
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);

    mysqli_query($koneksi, "INSERT INTO admin (username, password, nama_lengkap, role)
                            VALUES ('$username', '$password', '$nama', 'admin')");
    $msg = "Admin baru berhasil ditambahkan!";
}

/* ============================
   DELETE ADMIN
=============================== */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Cegah superadmin menghapus dirinya
    $cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT username FROM admin WHERE id = '$id'"));
    if ($cek['username'] != $_SESSION['admin_login']) {
        mysqli_query($koneksi, "DELETE FROM admin WHERE id = '$id'");
        $msg = "Admin berhasil dihapus!";
    } else {
        $msg = "Superadmin tidak boleh menghapus akun sendiri!";
    }
}

/* ============================
   UPDATE ADMIN
=============================== */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];

    mysqli_query($koneksi, "UPDATE admin SET username='$username', nama_lengkap='$nama' WHERE id='$id'");
    $msg = "Data admin berhasil diperbarui!";
}

/* ============================
   AMBIL DATA ADMIN
=============================== */
$admins = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f4f6fb;
    }
    .container-box {
        max-width: 700px;
        margin: 40px auto;
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .table-box {
        max-width: 900px;
        margin: 30px auto;
        background: white;
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h3 {
        font-weight: 600;
        color: #182848;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4B6CB7, #182848);
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
    }
    .btn-warning, .btn-danger {
        border-radius: 8px;
    }
    input {
        border-radius: 12px !important;
    }
</style>
</head>

<body>

  <?php include 'sidebar.php'; ?>
<div class="container-box">
    <h3><i class="bi bi-person-plus"></i> Tambah Admin Baru</h3>
    <p class="text-muted">Form ini hanya untuk <b>Superadmin</b>.</p>

    <?php if (isset($msg)): ?>
    <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama lengkap">

        <label class="mt-2">Username</label>
        <input type="text" name="username" class="form-control" required placeholder="Masukkan username">

        <label class="mt-2">Password</label>
        <input type="password" name="password" class="form-control" required placeholder="Masukkan password">

        <button type="submit" name="tambah" class="btn btn-primary w-100 mt-4">
            <i class="bi bi-check-circle"></i> Tambah Admin
        </button>
    </form>
</div>

<!-- CRUD TABLE -->
<div class="table-box">
    <h4><i class="bi bi-people"></i> Daftar Admin</h4>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th width="160px">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $no = 1;
        while ($row = mysqli_fetch_assoc($admins)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_lengkap'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><span class="badge bg-primary"><?= $row['role'] ?></span></td>
                <td>
                    <!-- Tombol Edit -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id'] ?>">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <!-- Tombol Hapus -->
                    <a href="?hapus=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin hapus admin ini?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>

            <!-- MODAL EDIT -->
            <div class="modal fade" id="edit<?= $row['id'] ?>">
                <div class="modal-dialog">
                    <form method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Admin</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= $row['nama_lengkap'] ?>" required>

                            <label class="mt-2">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>" required>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" name="update">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
