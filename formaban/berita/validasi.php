<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
cekRole(['pengelola_kip','kabag','superadmin']);

include __DIR__ . '/../sidebar.php';

// koneksi.php kamu pakai variabel $koneksi, jadi pakai itu
require_once __DIR__ . '/../../koneksi.php';

// Validasi ID
if (!isset($_GET['id'])) {
    die("ID berita tidak ditemukan!");
}

$id = intval($_GET['id']);  // amanin ID agar integer

// --- Ambil data berita ---
$stmt = $koneksi->prepare("SELECT * FROM berita WHERE id_berita = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) die("Berita tidak ditemukan!");

// Pesan
$msg = "";

// --- Update status jika form disubmit ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $status = $_POST['status'];
    $approved_by = $_SESSION['id_admin'];

    $stmt = $koneksi->prepare(
        "UPDATE berita 
         SET status = ?, approved_by = ?, updated_at = NOW() 
         WHERE id_berita = ?"
    );

    $stmt->bind_param("sii", $status, $approved_by, $id);
    $stmt->execute();
    $stmt->close();

    $msg = "Validasi berita berhasil!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Validasi Berita</title>
<style>
body {margin:0; padding-left:240px; background:#f4f6f9; font-family:Arial;}
.content { padding:25px; }
select { width:100%; padding:10px; margin-bottom:10px; }
</style>
</head>
<body>

<div class="content">
    <h2>Validasi Berita</h2>

    <?php if ($msg): ?>
        <p style="color:green;"><?= $msg ?></p>
    <?php endif; ?>

    <p><strong>Judul:</strong> <?= htmlspecialchars($data['judul']) ?></p>
    <p><strong>Isi:</strong><br><?= nl2br(htmlspecialchars($data['isi'])) ?></p>

    <p>
        <img src="/KIPWEB/uploads/<?= $data['gambar'] ?>" width="250">
    </p>

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
