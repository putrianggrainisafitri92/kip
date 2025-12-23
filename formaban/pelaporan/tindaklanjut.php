<?php
require_once __DIR__ . '/../config/auth.php';

requireLogin();

include __DIR__ . '/../sidebar.php';
require_once __DIR__ . '/../../koneksi.php';


$id = $_GET['id'] ?? 0;

// Ambil data laporan
$stmt = $koneksi->prepare("SELECT * FROM laporan WHERE id_laporan=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) die("Laporan tidak ditemukan!");

$msg = "";

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    $stmt = $koneksi->prepare("
        UPDATE laporan 
        SET status=?, id_admin=? 
        WHERE id_laporan=?
    ");
    $stmt->bind_param("sii", $status, $_SESSION['id_admin'], $id);
    $stmt->execute();
    $stmt->close();

    $msg = "Status laporan berhasil diperbarui!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tindak Lanjut Laporan</title>

<style>
body {
    margin:0; padding-left:240px;
    background:#f4f6f9;
    font-family: Arial;
}

.content {
    padding:25px;
    background:white;
    margin:25px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

select {
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid #ccc;
}

.btn {
    background:#0d6efd;
    padding:10px 14px;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.btn:hover {
    background:#0b5ed7;
}
</style>

</head>
<body>

<div class="content">
    <h2>Tindak Lanjut Laporan</h2>

    <?php if ($msg): ?>
        <p style="color:green; font-weight:bold;"><?= $msg ?></p>
    <?php endif; ?>

    <p><strong>Pelapor:</strong> <?= $data['nama_pelapor'] ?></p>
    <p><strong>Terlapor:</strong> <?= $data['nama_terlapor'] ?></p>
    <p><strong>Jurusan:</strong> <?= $data['jurusan'] ?></p>

    <form method="POST">

        <label>Status Laporan:</label>
        <select name="status" required>
            <option value="Belum Ditinjau" <?= $data['status']=='Belum Ditinjau'?'selected':'' ?>>Belum Ditinjau</option>
            <option value="Sudah Ditinjau" <?= $data['status']=='Sudah Ditinjau'?'selected':'' ?>>Sudah Ditinjau</option>
            <option value="Ditindaklanjuti" <?= $data['status']=='Ditindaklanjuti'?'selected':'' ?>>Ditindaklanjuti</option>
        </select>

        <button class="btn" type="submit">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
