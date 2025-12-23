<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
include __DIR__ . '/../sidebar.php';
require_once __DIR__ . '/../../koneksi.php';

$admin = getAdmin();

// ambil ID
$id = $_GET['id'] ?? 0;

// ambil data pedoman berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM pedoman WHERE id_pedoman=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) die("Data pedoman tidak ditemukan!");

// hanya pembuat + superadmin boleh edit
if ($data['id_admin'] != $admin['id_admin'] && $admin['role'] !== 'superadmin') {
    die("Anda tidak memiliki akses untuk mengedit file ini.");
}

$msg = "";

// proses update file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // jika ada file baru
    if (!empty($_FILES['file']['name'])) {

        $dir = __DIR__ . '/../../uploads/pedoman/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $nama_asli = $_FILES['file']['name'];
        $nama_baru = time() . "_" . $nama_asli;
        $path_baru = $dir . $nama_baru;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $path_baru)) {

            // hapus file lama
            if (file_exists(__DIR__ . '/../../' . $data['file_path'])) {
                unlink(__DIR__ . '/../../' . $data['file_path']);
            }

            $file_path = "uploads/pedoman/" . $nama_baru;

            // update database
            $stmt = $conn->prepare("UPDATE pedoman 
                                    SET nama_file=?, file_path=?, updated_at=NOW()
                                    WHERE id_pedoman=?");
            $stmt->bind_param("ssi", $nama_asli, $file_path, $id);
            $stmt->execute();
            $stmt->close();

            $msg = "File pedoman berhasil diperbarui!";
        }

    } else {
        $msg = "Tidak ada file baru yang diupload!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit File Pedoman</title>
<style>
body { margin:0; padding-left:240px; background:#f4f6f9; font-family:Arial; }
.content { padding:25px; }
input { width:100%; padding:10px; margin-bottom:10px; }
.btn { padding:10px 14px; background:#0d6efd; color:white; border-radius:6px; text-decoration:none; }
</style>
</head>
<body>

<div class="content">
    <h2>Edit File Pedoman</h2>

    <?php if ($msg): ?>
        <p style="color:green;"><?= $msg ?></p>
    <?php endif; ?>

    <p><strong>File Lama:</strong></p>
    <p>
        <a href="/WEBKIP/<?= $data['file_path'] ?>" target="_blank">
            <?= $data['nama_file'] ?>
        </a>
    </p>
    <br>

    <form method="POST" enctype="multipart/form-data">
        <label>Upload File Baru (PDF/DOC)</label>
        <input type="file" name="file" required>

        <button class="btn" type="submit">Update File</button>
    </form>
</div>

</body>
</html>
