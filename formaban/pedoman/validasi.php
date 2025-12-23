<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
cekRole(['pengelola_kip','kabag','superadmin']);

include __DIR__ . '/../sidebar.php';
require_once __DIR__ . '/../../koneksi.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM pedoman WHERE id_pedoman=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) die("Pedoman tidak ditemukan!");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE pedoman SET status=?, approved_by=? WHERE id_pedoman=?");
    $stmt->bind_param("sii", $status, $_SESSION['id_admin'], $id);
    $stmt->execute();
    $stmt->close();

    $msg = "Validasi berhasil disimpan!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Validasi Pedoman</title>
<style>
body { margin:0; padding-left:240px; background:#f4f6f9; font-family:Arial; }
.content { padding:25px; }
select { width:100%; padding:10px; margin-bottom:10px; }
</style>
</head>
<body>

<div class="content">
    <h2>Validasi Pedoman</h2>

    <?php if ($msg): ?><p style="color:green;"><?= $msg ?></p><?php endif; ?>

    <p><strong>File:</strong> <?= $data['nama_file'] ?></p>
    <p><a href="/WEBKIP/<?= $data['file_path'] ?>" target="_blank">Lihat File</a></p>

    <form method="POST">
        <label>Status</label>
        <select name="status">
            <option value="approved">Setujui</option>
            <option value="rejected">Tolak</option>
        </select>

        <button class="btn" type="submit">Simpan</button>
    </form>
</div>

</body>
</html>
