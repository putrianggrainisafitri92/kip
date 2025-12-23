<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
include __DIR__ . '/../sidebar.php';
require_once __DIR__ . '/../../koneksi.php';

$id = $_GET['id'];

$stmt = $koneksi->prepare("SELECT * FROM laporan WHERE id_laporan=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) die("Laporan tidak ditemukan!");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Laporan</title>

<style>
    body {
        margin:0;
        padding-left:240px;
        background:#f3f6fb;
        font-family:Arial, sans-serif;
    }

    .content {
        padding:30px;
        background:white;
        margin:25px;
        border-radius:14px;
        box-shadow:0 4px 12px rgba(0,0,0,0.08);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity:0; transform:translateY(10px); }
        to { opacity:1; transform:translateY(0); }
    }

    h2 {
        font-size:26px;
        margin-bottom:25px;
        border-left:6px solid #0d6efd;
        padding-left:12px;
    }

    .info-box {
        margin-bottom:18px;
        padding:15px 20px;
        background:#f8f9fc;
        border-radius:10px;
        border:1px solid #e3e6f0;
    }

    .info-box p {
        margin:6px 0;
        font-size:15px;
    }

    .label {
        font-weight:bold;
        color:#333;
    }

    /* Bukti Gambar */
    h3 {
        margin-top:30px;
        font-size:20px;
        border-left:4px solid #198754;
        padding-left:10px;
    }

    .bukti-box {
        display:flex;
        flex-wrap:wrap;
        gap:18px;
        margin-top:15px;
    }

    .bukti {
        width:280px;
        height:190px;
        object-fit:cover;
        border-radius:12px;
        border:1px solid #d9d9d9;
        box-shadow:0 2px 8px rgba(0,0,0,0.12);
        transition:0.25s;
        cursor:zoom-in;
    }

    .bukti:hover {
        transform:scale(1.04);
        box-shadow:0 4px 12px rgba(0,0,0,0.2);
    }
</style>

</head>
<body>

<div class="content">
    <h2>Detail Laporan</h2>

    <div class="info-box">
        <p><span class="label">Pelapor:</span> <?= $data['nama_pelapor'] ?></p>
        <p><span class="label">Email:</span> <?= $data['email_pelapor'] ?></p>
        <p><span class="label">Terlapor:</span> <?= $data['nama_terlapor'] ?></p>
        <p><span class="label">NPM Terlapor:</span> <?= $data['npm_terlapor'] ?></p>
        <p><span class="label">Jurusan:</span> <?= $data['jurusan'] ?></p>
        <p><span class="label">Prodi:</span> <?= $data['prodi'] ?></p>
    </div>

    <div class="info-box">
        <p><span class="label">Alasan Pelaporan:</span><br><?= nl2br($data['alasan']) ?></p>
        <p><span class="label">Detail Laporan:</span><br><?= nl2br($data['detail_laporan']) ?></p>
        <p><span class="label">Pernyataan Kebenaran:</span> <?= $data['pernyataan'] == 1 ? 'Ya' : 'Tidak' ?></p>
    </div>

    <h3>Bukti Laporan</h3>

    <div class="bukti-box">
    <?php
    $bukti_files = explode(",", $data['bukti']);
    foreach ($bukti_files as $file):
        $file = trim($file);
        if ($file):
    ?>
        <img class="bukti" src="/KIPWEB/uploads/<?= $file ?>" alt="Bukti Laporan">
    <?php endif; endforeach; ?>
    </div>

</div>

</body>
</html>
