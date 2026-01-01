<?php
session_start();

// Cek login pengurus level 11
if (!isset($_SESSION['level']) || (int)$_SESSION['level'] !== 11) {
    header("Location: ../index.php?error=akses");
    exit;
}

include "../koneksi.php";

/* ============================================
   QUERY DATA
============================================ */

// Status berita
$status_berita = [];
$jumlah_berita = [];
$q_berita = mysqli_query($koneksi, "SELECT status, COUNT(*) AS jml FROM berita GROUP BY status");

while ($row = mysqli_fetch_assoc($q_berita)) {
    $status_berita[] = ucfirst($row['status']);
    $jumlah_berita[] = (int)$row['jml'];
}

// Status pedoman
$status_pedoman = [];
$jumlah_pedoman = [];
$q_pedoman = mysqli_query($koneksi, "SELECT status, COUNT(*) AS jml FROM pedoman GROUP BY status");

while ($row = mysqli_fetch_assoc($q_pedoman)) {
    $status_pedoman[] = ucfirst($row['status']);
    $jumlah_pedoman[] = (int)$row['jml'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pengurus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* HEADER */
        .header-bar {
            margin-left: 240px;
            background: linear-gradient(90deg, #5e00b8, #8b2be2);
            padding: 18px 32px;
            color: white;
            font-size: 19px;
            font-weight: 600;
            letter-spacing: .5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        /* CARD GRAFIK */
        .chart-card {
            margin-left: 260px;
            width: 60%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 25px;
            border-radius: 16px;
            margin-top: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
            transition: .2s;
        }
        .chart-card:hover {
            transform: scale(1.01);
            box-shadow: 0 10px 30px rgba(0,0,0,0.35);
        }

        .chart-card h3 {
            margin: 0 0 16px 0;
            font-size: 18px;
            color: #3a0066;
            font-weight: 600;
        }

        canvas {
            width: 100% !important;
            height: 260px !important; /* LEBIH KECIL */
            background: white;
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

<?php include "sidebar.php"; ?>

<div class="header-bar">
    Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?> — Dashboard Pengurus
</div>

<!-- GRAFIK BERITA -->
<div class="chart-card">
    <h3>📊 Grafik Status Berita</h3>
    <canvas id="grafikBerita"></canvas>
</div>

<!-- GRAFIK PEDOMAN -->
<div class="chart-card">
    <h3>📊 Grafik Status Pedoman</h3>
    <canvas id="grafikPedoman"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ====== STYLE CHART ====== */
const purpleStyle = {
    backgroundColor: "rgba(140, 0, 255, 0.75)",
    borderColor: "#5e00b8",
    borderWidth: 2,
    borderRadius: 10,
    hoverBackgroundColor: "rgba(140, 0, 255, 0.95)",
};

/* ========= Grafik Berita ========= */
new Chart(document.getElementById('grafikBerita'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_berita); ?>,
        datasets: [{
            label: "Jumlah Berita",
            data: <?= json_encode($jumlah_berita); ?>,
            ...purpleStyle
        }]
    },
    options: {
        plugins: {
            legend: { labels: { color: "#444" } }
        },
        scales: {
            y: { beginAtZero: true, ticks: { color: "#444" } },
            x: { ticks: { color: "#444" } }
        }
    }
});

/* ========= Grafik Pedoman ========= */
new Chart(document.getElementById('grafikPedoman'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_pedoman); ?>,
        datasets: [{
            label: "Jumlah Pedoman",
            data: <?= json_encode($jumlah_pedoman); ?>,
            ...purpleStyle
        }]
    },
    options: {
        plugins: {
            legend: { labels: { color: "#444" } }
        },
        scales: {
            y: { beginAtZero: true, ticks: { color: "#444" } },
            x: { ticks: { color: "#444" } }
        }
    }
});
</script>

</body>
</html>
