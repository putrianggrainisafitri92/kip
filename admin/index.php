<?php 
session_start();
include "protect.php";
include "sidebar.php";
include "../koneksi.php"; 

// ==================== QUERY STATISTIK RINGKASAN ====================
$total_laporan = $koneksi->query("SELECT COUNT(*) FROM laporan")->fetch_row()[0];
$total_berita = $koneksi->query("SELECT COUNT(*) FROM berita")->fetch_row()[0];
$total_pedoman = $koneksi->query("SELECT COUNT(*) FROM pedoman")->fetch_row()[0];
$total_mahasiswa = $koneksi->query("SELECT COUNT(*) FROM mahasiswa_kip")->fetch_row()[0];

// ==================== QUERY JUMLAH LAPORAN PER BULAN ====================
$data = $koneksi->query("
    SELECT 
        DATE_FORMAT(created_at, '%b') AS bulan,
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | KIP Kuliah Polinela</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-width: 240px;
            --primary-purple: #4e0a8a;
            --accent-purple: #7b35d4;
            --glass-white: rgba(255, 255, 255, 0.95);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        /* CONTENT AREA */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: 0.3s ease;
        }

        /* HEADER BOX */
        .welcome-box {
            background: var(--glass-white);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.2);
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-text h2 {
            margin: 0;
            color: var(--primary-purple);
            font-weight: 800;
            font-size: 1.8rem;
        }

        .welcome-text p {
            margin: 5px 0 0;
            color: #666;
            font-size: 1.1rem;
        }

        .clock-box {
            text-align: right;
            background: var(--primary-purple);
            color: white;
            padding: 12px 25px;
            border-radius: 16px;
            box-shadow: 0 8px 15px rgba(78, 10, 138, 0.2);
        }

        #realTimeClock {
            font-weight: 600;
            font-size: 1.1rem;
            display: block;
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--glass-white);
            border-radius: 20px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.1);
            animation: fadeInPage 1s ease-out;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(78, 10, 138, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-purple);
        }

        .stat-info p {
            margin: 0;
            color: #777;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* CHART AREA */
        .chart-container {
            background: var(--glass-white);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .chart-header h3 {
            margin: 0;
            color: var(--primary-purple);
            font-weight: 700;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .canvas-wrapper {
            position: relative;
            height: 400px;
            width: 100%;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 85px 15px 40px 15px;
            }
            .welcome-box {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            .clock-box { text-align: center; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .welcome-text h2 { font-size: 1.5rem; }
            .stat-card { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="main-content">
    
    <!-- WELCOME BOX -->
    <div class="welcome-box">
        <div class="welcome-text">
            <h2>Dashboard Overview</h2>
            <p>Selamat datang kembali, <b><?= htmlspecialchars($_SESSION['username']); ?></b> 👋</p>
        </div>
        <div class="clock-box shadow-lg">
            <span id="realTimeClock">Loading...</span>
        </div>
    </div>

    <!-- QUICK STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_laporan ?></h3>
                <p>Total Laporan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ff9966, #ff5e62);">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_berita ?></h3>
                <p>Total Berita</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_mahasiswa ?></h3>
                <p>Mahasiswa</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_pedoman ?></h3>
                <p>Pedoman</p>
            </div>
        </div>
    </div>

    <!-- MAIN CHART -->
    <div class="chart-container">
        <div class="chart-header">
            <h3><i class="fas fa-chart-line"></i> Grafik Aktivitas Laporan Mahasiswa</h3>
            <span style="font-size: 0.85rem; color: #888;">Data diperbarui secara real-time</span>
        </div>
        <div class="canvas-wrapper">
            <canvas id="grafikLaporan"></canvas>
        </div>
    </div>

</div>

<!-- SCRIPT CLOCK -->
<script>
function updateClock() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const date = now.toLocaleDateString('id-ID', options);
    const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    document.getElementById("realTimeClock").innerHTML = `${date} | ${time}`;
}
setInterval(updateClock, 1000);
updateClock();
</script>

<!-- SCRIPT CHART -->
<script>
const ctx = document.getElementById('grafikLaporan').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(78, 10, 138, 0.4)');
gradient.addColorStop(1, 'rgba(78, 10, 138, 0.02)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [{
            label: "Total Laporan",
            data: <?= json_encode($total) ?>,
            borderColor: "#4e0a8a",
            backgroundColor: gradient,
            borderWidth: 4,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: "#fff",
            pointBorderColor: "#4e0a8a",
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 9,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#4e0a8a',
                padding: 12,
                cornerRadius: 12,
                titleFont: { family: 'Poppins', size: 14 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                ticks: { family: 'Poppins', color: '#888' }
            },
            x: {
                grid: { display: false },
                ticks: { family: 'Poppins', color: '#888' }
            }
        }
    }
});
</script>

</body>
</html>
