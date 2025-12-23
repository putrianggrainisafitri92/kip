<?php
// user_edit.php (FINAL FIX)
// lokasi: kabag_akademik/user_edit.php

include '../protect.php';
check_level(13); // hanya admin3
include '../koneksi.php';
include 'sidebar.php';

// inisialisasi agar tidak ada notice
$msg = '';
$user = null;

// Pastikan ada id
if (!isset($_GET['id'])) {
    echo "<script>alert('ID user tidak ditemukan'); location='crud_user.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data user
$stmt = $koneksi->prepare("SELECT * FROM admin WHERE id_admin = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "<script>alert('User tidak ditemukan'); location='crud_user.php';</script>";
    exit;
}

// Proses update
if (isset($_POST['submit'])) {

    $nama = trim($_POST['nama_lengkap'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $level = intval($_POST['level'] ?? 0);

    if ($nama === '' || $username === '') {
        $msg = 'Nama dan username wajib diisi!';
    } else {
        // cek username unik kecuali user ini
        $stmt = $koneksi->prepare("SELECT id_admin FROM admin WHERE username=? AND id_admin<>? LIMIT 1");
        $stmt->bind_param("si", $username, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $msg = 'Username sudah digunakan!';
        } else {

            // Jika password diubah
            if ($password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt2 = $koneksi->prepare("UPDATE admin SET nama_lengkap=?, username=?, password=?, level=? WHERE id_admin=?");
                $stmt2->bind_param("sssii", $nama, $username, $hash, $level, $id);
            } else {
                // tanpa password
                $stmt2 = $koneksi->prepare("UPDATE admin SET nama_lengkap=?, username=?, level=? WHERE id_admin=?");
                $stmt2->bind_param("ssii", $nama, $username, $level, $id);
            }

            if ($stmt2->execute()) {
                echo "<script>alert('User berhasil diperbarui'); location='crud_user.php';</script>";
                exit;
            } else {
                $msg = 'Gagal memperbarui user.';
            }

            $stmt2->close();
        }

        $stmt->close();
    }

    // refresh data
    $stmtR = $koneksi->prepare("SELECT * FROM admin WHERE id_admin = ?");
    $stmtR->bind_param("i", $id);
    $stmtR->execute();
    $user = $stmtR->get_result()->fetch_assoc();
    $stmtR->close();
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Edit User — Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* layout */
.content-wrapper { margin-left: 260px; padding: 35px; font-family: 'Segoe UI', sans-serif; background:#efeaff; min-height:100vh; }
.card { background:#fff; padding:28px; border-radius:16px; border-left:10px solid #6a0dad; box-shadow:0 8px 28px rgba(0,0,0,0.08); max-width:760px; margin:0 auto; }
.card h2 { color:#4e0a8a; margin-bottom:18px; font-weight:800; }
.label { font-weight:700; color:#4e0a8a; display:block; margin-bottom:6px; }
.form-control { width:100%; padding:10px 12px; border-radius:10px; border:1px solid #dcd1f6; background:#fbf7ff; margin-bottom:14px; }
.form-control:focus { outline:none; box-shadow:0 6px 18px rgba(106,13,173,0.12); border-color:#6a0dad; background:#fff; }
.btn-primary { background:#6a0dad; border:none; padding:10px 18px; border-radius:10px; font-weight:700; color:#fff; }
.btn-primary:hover { background:#4e0a8a; }
.btn-secondary { background:#777; border:none; padding:10px 18px; border-radius:10px; color:#fff; margin-left:8px; text-decoration:none; display:inline-block; }
.msg-error { background:#fff1f2; color:#9b2c2c; padding:10px 14px; border-left:5px solid #e74c3c; border-radius:8px; margin-bottom:16px; }
</style>
</head>

<body>

<div class="content-wrapper">
    <div class="card">
        <h2>Edit User</h2>

        <?php if ($msg): ?>
            <div class="msg-error"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="post">

            <label class="label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control"
                   value="<?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>" required>

            <label class="label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>

            <label class="label">Password (kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control">

            <label class="label">Level</label>
            <select name="level" class="form-control" required>
                <option value="11" <?= intval($user['level']) === 11 ? 'selected' : '' ?>>Admin1 (Pengurus)</option>
                <option value="12" <?= intval($user['level']) === 12 ? 'selected' : '' ?>>Admin2</option>
                <option value="13" <?= intval($user['level']) === 13 ? 'selected' : '' ?>>Admin3</option>
            </select>

            <div style="margin-top:16px;">
                <button type="submit" name="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="crud_user.php" class="btn-secondary">Kembali</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
