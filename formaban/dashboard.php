<?php
require_once __DIR__ . '/config/auth.php';
requireLogin(); // Harus dipanggil dulu sebelum sidebar
require_once __DIR__ . '/../koneksi.php';

$admin = getAdmin();

// HITUNG STATISTIK
// --------------------------
$jumlah_berita = 0;
$jumlah_pedoman = 0;
$jumlah_laporan = 0;

// hitung berita
$res = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM berita");
$jumlah_berita = $res->fetch_assoc()['total'] ?? 0;

// hitung pedoman
$res = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pedoman");
$jumlah_pedoman = $res->fetch_assoc()['total'] ?? 0;

// hitung laporan
$res = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM laporan");
$jumlah_laporan = $res->fetch_assoc()['total'] ?? 0;
?>

<?php include __DIR__ . '/sidebar.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - WEBKIP</title>

    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        /* Konten bergeser ke kanan karena sidebar fix */
        .content {
            margin-left: 260px;
            padding: 30px;
        }

        .topbar {
            background: #0d6efd;
            color: white;
            padding: 14px 20px;
            font-size: 18px;
            font-weight: bold;
            margin-left: 260px;
        }

        .hello-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 0 6px rgba(0,0,0,0.08);
        }

        .stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 230px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 6px rgba(0,0,0,0.08);
            text-align: center;
        }

        .card h2 {
            margin: 0;
            color: #0d6efd;
            font-size: 40px;
        }

        .card p {
            margin-top: 6px;
            font-size: 15px;
            color: #666;
        }

        .footer {
            text-align: center;
            padding: 15px;
            color: #777;
            font-size: 13px;
            margin-top: 35px;
        }
    </style>
</head>
<body>

<div class="topbar">
    Dashboard WEBKIP
</div>

<div class="content">

    <div class="hello-box">
        <h3>Selamat Datang, <?= htmlspecialchars($admin['nama_lengkap']) ?> 👋</h3>
        <p>Role Anda: <strong><?= htmlspecialchars($admin['role']) ?></strong></p>
        <p>Gunakan menu di sidebar untuk mengelola konten WEBKIP.</p>
    </div>

    <div class="stats">
        <div class="card">
            <h2><?= $jumlah_berita ?></h2>
            <p>Total Berita</p>
        </div>

        <div class="card">
            <h2><?= $jumlah_pedoman ?></h2>
            <p>Total Pedoman</p>
        </div>

        <div class="card">
            <h2><?= $jumlah_laporan ?></h2>
            <p>Total Laporan Masuk</p>
        </div>
    </div>

    <div class="footer">
        © <?= date('Y') ?> WEBKIP – Panel Formaban
    </div>

</div>

</body>
</html>
