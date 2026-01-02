<?php
session_start();
include '../protect.php';
check_level(13);       
include '../koneksi.php';
include 'sidebar.php';

// Ambil nama lengkap dari session
$nama = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : "User";

// Hitung data untuk statistik
function getCount($koneksi, $table, $status) {
    $q = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM $table WHERE status='$status'");
    return mysqli_fetch_assoc($q)['jml'];
}

$pending_berita = getCount($koneksi, 'berita', 'pending');
$pending_sk = getCount($koneksi, 'sk_kipk', 'pending');
$pending_kip = getCount($koneksi, 'mahasiswa_kip', 'pending');
$pending_pedoman = getCount($koneksi, 'pedoman', 'pending');

$approved_berita = getCount($koneksi, 'berita', 'approved');
$approved_sk = getCount($koneksi, 'sk_kipk', 'approved');
$approved_kip = getCount($koneksi, 'mahasiswa_kip', 'approved');
$approved_pedoman = getCount($koneksi, 'pedoman', 'approved');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: 0.3s ease;
        }

        /* WELCOME SECTION */
        .welcome-section {
            background: var(--glass-white);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.2);
            animation: fadeInDown 0.8s ease-out;
            backdrop-filter: blur(10px);
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-text h2 {
            margin: 0;
            color: var(--primary-purple);
            font-weight: 800;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .welcome-text p {
            margin: 8px 0 0;
            color: #555;
            font-size: 1.1rem;
        }

        .datetime-box {
            text-align: right;
            background: linear-gradient(135deg, var(--primary-purple), var(--accent-purple));
            color: white;
            padding: 15px 25px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(78, 10, 138, 0.3);
        }

        #jamRealtime { font-weight: 600; font-size: 1.2rem; display: block; }

        /* QUICK INFO BOXES */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--glass-white);
            border-radius: 24px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(78, 10, 138, 0.15);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .stat-info h3 { margin: 0; font-size: 2.2rem; font-weight: 800; color: var(--primary-purple); }
        .stat-info p { margin: 2px 0 0; color: #666; font-size: 0.95rem; font-weight: 600; text-transform: uppercase; }

        /* CHART SECTION */
        .dashboard-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .chart-container {
            background: var(--glass-white);
            border-radius: 28px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .pending-list-card {
            background: var(--glass-white);
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .chart-header h3, .pending-list-card h3 {
            margin: 0 0 25px 0;
            color: var(--primary-purple);
            font-weight: 700;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pending-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px dashed rgba(0,0,0,0.1);
        }
        .pending-item:last-child { border-bottom: none; }
        .pending-label { font-weight: 500; font-size: 1rem; color: #444; }
        .pending-count {
            background: #ffecb3;
            color: #ff8f00;
            padding: 5px 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .dashboard-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 85px 15px 40px 15px;
            }
            .welcome-section {
                flex-direction: column;
                text-align: center;
                gap: 25px;
                padding: 30px 20px;
            }
            .datetime-box { text-align: center; width: 100%; box-sizing: border-box; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .welcome-text h2 { font-size: 1.5rem; }
            .stat-card { padding: 25px; }
        }
    </style>
</head>
<body>

<div class="main-content">
    
    <!-- WELCOME SECTION -->
    <div class="welcome-section">
        <div class="welcome-text">
            <h2>Panel Kabag Akademik</h2>
            <p>Selamat datang kembali, <b><?= htmlspecialchars($nama); ?></b> 👋</p>
        </div>
        <div class="datetime-box">
            <span id="jamRealtime">Memuat...</span>
        </div>
    </div>

    <!-- QUICK STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #FF512F, #DD2476);">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <h3><?= $approved_berita ?></h3>
                <p>Berita Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #1D976C, #93F9B9);">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="stat-info">
                <h3><?= $approved_sk ?></h3>
                <p>SK Tervalidasi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #2193b0, #6dd5ed);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3><?= $approved_kip ?></h3>
                <p>Mahasiswa KIP</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8E2DE2, #4A00E0);">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3><?= $approved_pedoman ?></h3>
                <p>Pedoman Aktif</p>
            </div>
        </div>
    </div>

    <!-- DASHBOARD CONTENT ROW -->
    <div class="dashboard-row">
        <!-- CHART -->
        <div class="chart-container">
            <div class="chart-header">
                <h3><i class="fas fa-chart-bar"></i> Statistik Data Tervalidasi</h3>
            </div>
            <div style="height: 350px;">
                <canvas id="mainChart"></canvas>
            </div>
        </div>

        <!-- PENDING TASKS LIST -->
        <div class="pending-list-card">
            <h3><i class="fas fa-tasks"></i> Tugas Validasi</h3>
            <div class="pending-item">
                <span class="pending-label">Berita Baru</span>
                <span class="pending-count"><?= $pending_berita ?></span>
            </div>
            <div class="pending-item">
                <span class="pending-label">Penerimaan SK</span>
                <span class="pending-count"><?= $pending_sk ?></span>
            </div>
            <div class="pending-item">
                <span class="pending-label">Data Mahasiswa</span>
                <span class="pending-count"><?= $pending_kip ?></span>
            </div>
            <div class="pending-item">
                <span class="pending-label">Dokumen Pedoman</span>
                <span class="pending-count"><?= $pending_pedoman ?></span>
            </div>
            <div style="margin-top: 30px; text-align: center;">
                <p style="font-size: 0.85rem; color: #888; font-style: italic;">
                    Klik menu di sidebar untuk memproses validasi data di atas.
                </p>
            </div>
        </div>
    </div>

</div>

<!-- SCRIPT DATETIME -->
<script>
function updateTime() {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const now = new Date();
    const dateStr = now.toLocaleDateString('id-ID', options);
    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    document.getElementById("jamRealtime").innerHTML = `${dateStr} | ${timeStr}`;
}
setInterval(updateTime, 1000);
updateTime();
</script>

<!-- SCRIPT CHART -->
<script>
const ctx = document.getElementById('mainChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Berita', 'SK KIP', 'Data KIP', 'Pedoman'],
        datasets: [{
            label: 'Data Tervalidasi',
            data: [
                <?= $approved_berita ?>,
                <?= $approved_sk ?>,
                <?= $approved_kip ?>,
                <?= $approved_pedoman ?>
            ],
            backgroundColor: [
                'rgba(221, 36, 118, 0.7)',
                'rgba(29, 151, 108, 0.7)',
                'rgba(33, 147, 176, 0.7)',
                'rgba(142, 45, 226, 0.7)'
            ],
            borderColor: [
                '#DD2476', '#1D976C', '#2193b0', '#8E2DE2'
            ],
            borderWidth: 2,
            borderRadius: 12
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { 
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
</script>

</body>
</html>
