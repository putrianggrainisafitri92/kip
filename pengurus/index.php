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
            overflow-x: hidden;
        }

        /* HEADER */
        .header-bar {
            margin-left: 240px;
            background: linear-gradient(90deg, #4e0a8a, #7b35d4);
            padding: 20px 32px;
            color: white;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: 0.3s ease;
        }

        /* MAIN CONTENT WRAPPER */
        .main-container {
            margin-left: 240px;
            padding: 30px;
            transition: 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 25px;
            align-items: center;
        }

        /* CARD GRAFIK */
        .chart-card {
            width: 100%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: .3s ease;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .chart-card h3 {
            margin: 0 0 20px 0;
            font-size: 22px;
            color: #4e0a8a;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }

        /* Responsive Media Queries */
        /* Responsive Media Queries */
        @media (max-width: 1024px) {
            .header-bar {
                margin-left: 0;
                padding: 18px 20px 18px 75px; /* Space for mobile menu btn */
                font-size: 16px;
                text-align: center;
            }
            .main-container {
                margin-left: 0;
                padding: 20px 15px;
            }
            .chart-card {
                padding: 15px;
            }
            .chart-container {
                height: 300px;
            }
        }
        @media (max-width: 600px) {
             .header-bar { font-size: 13px; padding-left: 65px; }
        }
    </style>
</head>

<body>

<?php include "sidebar.php"; ?>

<div class="header-bar">
    <i class="fas fa-desktop mr-2"></i> Dashboard Pengurus — Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?>
</div>

<div class="main-container">

    <!-- GRAFIK BERITA -->
    <div class="chart-card">
        <h3>Grafik Status Berita</h3>
        <div class="chart-container">
            <canvas id="grafikBerita"></canvas>
        </div>
    </div>

    <!-- GRAFIK PEDOMAN -->
    <div class="chart-card">
        <h3>Grafik Status Pedoman</h3>
        <div class="chart-container">
            <canvas id="grafikPedoman"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ====== CONFIG CHART ====== */
function createGradient(ctx, area) {
    const gradient = ctx.createLinearGradient(0, area.bottom, 0, area.top);
    gradient.addColorStop(0, 'rgba(123, 31, 162, 0.8)');   // Purple Dark
    gradient.addColorStop(1, 'rgba(186, 104, 200, 0.8)'); // Purple Light
    return gradient;
}

const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'top',
            labels: {
                font: { size: 14, weight: '600' },
                color: '#4e0a8a',
                padding: 20
            }
        },
        tooltip: {
            backgroundColor: 'rgba(78, 10, 138, 0.9)',
            padding: 12,
            titleFont: { size: 14 },
            bodyFont: { size: 14 },
            cornerRadius: 10
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)' },
            ticks: { color: '#4e0a8a', stepSize: 1 }
        },
        x: {
            grid: { display: false },
            ticks: { color: '#4e0a8a', font: { weight: '600' } }
        }
    }
};

/* ========= Grafik Berita ========= */
const ctxBerita = document.getElementById('grafikBerita').getContext('2d');
new Chart(ctxBerita, {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_berita); ?>,
        datasets: [{
            label: "Jumlah Berita",
            data: <?= json_encode($jumlah_berita); ?>,
            backgroundColor: (context) => {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
                if (!chartArea) return null;
                return createGradient(ctx, chartArea);
            },
            borderRadius: 8,
            hoverBackgroundColor: '#4e0a8a'
        }]
    },
    options: commonOptions
});

/* ========= Grafik Pedoman ========= */
const ctxPedoman = document.getElementById('grafikPedoman').getContext('2d');
new Chart(ctxPedoman, {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_pedoman); ?>,
        datasets: [{
            label: "Jumlah Pedoman",
            data: <?= json_encode($jumlah_pedoman); ?>,
            backgroundColor: (context) => {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
                if (!chartArea) return null;
                return createGradient(ctx, chartArea);
            },
            borderRadius: 8,
            hoverBackgroundColor: '#4e0a8a'
        }]
    },
    options: commonOptions
});
</script>

</body>
</html>
