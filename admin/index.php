<?php 
session_start();
include "protect.php";
include "sidebar.php";
include "../koneksi.php"; 

// ==================== QUERY JUMLAH LAPORAN PER BULAN ====================
$data = $koneksi->query("
    SELECT 
        DATE_FORMAT(created_at, '%M') AS bulan,
        COUNT(*) AS total
    FROM laporan
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY MIN(created_at)
");

$bulan = [];
$total = [];

while ($row = $data->fetch_assoc()) {
    $bulan[] = $row['bulan'];
    $total[] = (int)$row['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin Level 2</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* --------------------------------------------------- */
:root {
    --sidebar-width: 240px;
    --header-height: 65px; 
}

html, body {
    margin: 0;
    padding: 0;
    font-family: "Poppins", sans-serif;
    background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
    background-size: cover;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-width);
    height: 100vh;
    z-index: 900;
}

/* HEADER */
.header-bar {
    position: fixed;
    top: 0;
    left: var(--sidebar-width);
    right: 0;
    height: var(--header-height);
    display: flex;
    align-items: center;
    padding: 0 28px;
    background: linear-gradient(90deg, #5e00b8, #8b2be2);
    color: white;
    font-size: 20px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    z-index: 1000;
    border-bottom-left-radius: 10px;
}

/* WRAPPER */
.dashboard-wrapper {
    margin-left: calc(var(--sidebar-width) + 20px);
    padding-top: calc(var(--header-height) + 35px);
    margin-top: 40px;
    width: 73%;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(5px);
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.28);
}

/* Real-time Clock */
.clock-box {
    margin-top: -8px;
    font-size: 17px;
    font-weight: 600;
    color: #4b0082;
    background: rgba(255,255,255,0.65);
    display: inline-block;
    padding: 8px 15px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.12);
}

/* CHART BOX */
.chart-box {
    background: white;
    padding: 20px 25px;
    border-radius: 18px;
    margin-top: 25px;
    box-shadow: 0 6px 22px rgba(0,0,0,.15);
}

.chart-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #4b0082;
}

canvas {
    width: 100% !important;
    height: 350px !important;
}
</style>
</head>

<body>

<!-- ========================= HEADER ========================= -->
<div class="header-bar">
    Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?> — Dashboard Admin Level 2
</div>

<!-- ========================= KONTEN ========================= -->
<div class="dashboard-wrapper">

    <h2 style="color:#4b0082; margin-top:0;">Dashboard</h2>
    <p style="color:#555; margin-top:-10px;">Selamat datang, <b><?= $_SESSION['username']; ?></b> 👋</p>

    <!-- JAM REALTIME -->
    <div class="clock-box">
        <span id="realTimeClock">Loading...</span>
    </div>

    <!-- ===================== GRAFIK ===================== -->
    <div class="chart-box">
        <div class="chart-title">📈 Grafik Jumlah Laporan Mahasiswa</div>
        <canvas id="grafikLaporan"></canvas>
    </div>

</div>

<!-- ===================== SCRIPT JAM ===================== -->
<script>
function updateClock() {
    const now = new Date();

    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };

    const date = now.toLocaleDateString('id-ID', options);
    const time = now.toLocaleTimeString('id-ID');

    document.getElementById("realTimeClock").innerHTML = 
        `${date} | ${time}`;
}

setInterval(updateClock, 1000);
updateClock();
</script>

<!-- ===================== SCRIPT GRAFIK ===================== -->
<script>
const ctx = document.getElementById('grafikLaporan').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 350);
gradient.addColorStop(0, "rgba(123, 44, 191, 0.45)");
gradient.addColorStop(1, "rgba(123, 44, 191, 0.05)");

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [{
            label: "Jumlah Laporan",
            data: <?= json_encode($total) ?>,
            borderColor: "#6a0dad",
            borderWidth: 3,
            backgroundColor: gradient,
            fill: true,
            pointBackgroundColor: "#6a0dad",
            pointBorderColor: "#fff",
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8,
            tension: 0.35,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: "#4b0082",
                    font: { size: 14, weight: '600' }
                }
            },
            tooltip: {
                backgroundColor: "#5e00b8",
                titleColor: "#fff",
                bodyColor: "#fff",
                padding: 12,
                cornerRadius: 12
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: "#4b0082" },
                grid: { color: "rgba(0,0,0,0.08)" }
            },
            x: {
                ticks: { color: "#4b0082" },
                grid: { display: false }
            }
        }
    }
});
</script>

</body>
</html>
