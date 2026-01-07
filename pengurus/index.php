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

// Helper function to determine color based on status
function getStatusColor($status) {
    $s = strtolower(trim($status));
    if (strpos($s, 'agreed') !== false || strpos($s, 'approve') !== false || strpos($s, 'diterima') !== false || strpos($s, 'verified') !== false || strpos($s, 'publik') !== false || strpos($s, 'selesai') !== false) {
        return '#4caf50'; // Green
    } elseif (strpos($s, 'reject') !== false || strpos($s, 'tolak') !== false || strpos($s, 'gagal') !== false) {
        return '#f44336'; // Red
    } else {
        return '#ff9800'; // Orange (Pending/Draft/Etc)
    }
}

// Status berita
$status_berita = [];
$jumlah_berita = [];
$warna_berita  = [];
$q_berita = mysqli_query($koneksi, "SELECT status, COUNT(*) AS jml FROM berita GROUP BY status");

while ($row = mysqli_fetch_assoc($q_berita)) {
    $status_berita[] = ucfirst($row['status']);
    $jumlah_berita[] = (int)$row['jml'];
    $warna_berita[]  = getStatusColor($row['status']);
}

// Status pedoman
$status_pedoman = [];
$jumlah_pedoman = [];
$warna_pedoman  = [];
$q_pedoman = mysqli_query($koneksi, "SELECT status, COUNT(*) AS jml FROM pedoman GROUP BY status");

while ($row = mysqli_fetch_assoc($q_pedoman)) {
    $status_pedoman[] = ucfirst($row['status']);
    $jumlah_pedoman[] = (int)$row['jml'];
    $warna_pedoman[]  = getStatusColor($row['status']);
}

// Status Tahapan (Baru)
$status_tahapan = [];
$jumlah_tahapan = [];
$warna_tahapan  = [];
$q_tahapan = mysqli_query($koneksi, "SELECT status, COUNT(*) AS jml FROM pedoman_tahapan GROUP BY status");

while ($row = mysqli_fetch_assoc($q_tahapan)) {
    $st = $row['status'] ? $row['status'] : 'pending';
    $status_tahapan[] = ucfirst($st);
    $jumlah_tahapan[] = (int)$row['jml'];
    $warna_tahapan[]  = getStatusColor($st);
}

// Status Mahasiswa Berprestasi (Baru)
$status_prestasi = [];
$jumlah_prestasi = [];
$warna_prestasi  = [];
$q_prestasi = mysqli_query($koneksi, "SELECT status, COUNT(*) AS jml FROM mahasiswa_prestasi GROUP BY status");

while ($row = mysqli_fetch_assoc($q_prestasi)) {
    $st = $row['status'] ? $row['status'] : 'pending';
    $status_prestasi[] = ucfirst($st);
    $jumlah_prestasi[] = (int)$row['jml'];
    $warna_prestasi[]  = getStatusColor($st);
}

// Hitung Total untuk Stats Card
$total_berita   = array_sum($jumlah_berita);
$total_pedoman  = array_sum($jumlah_pedoman);
$total_tahapan  = array_sum($jumlah_tahapan);
$total_prestasi = array_sum($jumlah_prestasi);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Pengurus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { box-sizing: border-box; }
        
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            overflow-x: hidden;
            color: #333;
        }

        /* ANIMATIONS */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        /* HEADER */
        .header-bar {
            margin-left: 240px;
            background: linear-gradient(90deg, #4e0a8a, #7b35d4);
            padding: 15px 30px;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            position: sticky; top: 0; z-index: 50;
        }

        .header-left {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .header-right {
            font-size: 14px;
            font-weight: 500;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* MAIN CONTENT WRAPPER */
        .main-container {
            margin-left: 240px;
            padding: 30px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1400px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(255,255,255,0.4);
            transition: transform 0.3s;
        }
        
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(78, 10, 138, 0.15); }

        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: white;
            flex-shrink: 0;
            background: linear-gradient(135deg, #6a11cb, #2575fc); /* Default gradient */
        }

        .stat-info h3 { margin: 0; font-size: 24px; color: #4e0a8a; }
        .stat-info p { margin: 0; font-size: 13px; color: #666; font-weight: 500; }

        /* CHART GRID */
        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            width: 100%;
            max-width: 1400px;
        }

        /* CARD GRAFIK */
        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(78, 10, 138, 0.05);
            border: 1px solid rgba(123, 53, 212, 0.1);
            transition: .3s ease;
            display: flex;
            flex-direction: column;
        }

        .chart-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(78, 10, 138, 0.15); }

        .chart-card h3 {
            margin: 0 0 20px 0;
            font-size: 18px;
            color: #4e0a8a;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f3e8ff;
            padding-bottom: 10px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            flex-grow: 1;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .header-bar { margin-left: 0; padding-left: 70px; }
            .header-right { margin-left: auto; }
            .main-container { margin-left: 0; padding: 20px; }
        }

        @media (max-width: 768px) {
            .chart-grid { grid-template-columns: 1fr; }
            .header-bar { padding: 15px 15px 15px 60px; }
            .header-left { font-size: 16px; }
            .header-right { font-size: 12px; padding: 5px 10px; }
            .stats-grid { grid-template-columns: 1fr; }
            .chart-card { padding: 15px; }
        }
    </style>
</head>

<body>

<?php include "sidebar.php"; ?>

<div class="header-bar animate-up">
    <div class="header-left">
        <i class="fas fa-desktop mr-2"></i> 
        <span>Dashboard Pengurus — <?= htmlspecialchars($_SESSION['username']) ?></span>
    </div>
    <div class="header-right">
        <i class="far fa-clock"></i>
        <span id="liveClock">Loading...</span>
    </div>
</div>

<div class="main-container">

    <!-- TOP STATS -->
    <div class="stats-grid">
        <!-- 1. Berita -->
        <div class="stat-card animate-up delay-1">
            <div class="stat-icon" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_berita ?></h3>
                <p>Total Berita</p>
            </div>
        </div>
        <!-- 2. Pedoman -->
        <div class="stat-card animate-up delay-2">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ff9966, #ff5e62);">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_pedoman ?></h3>
                <p>Dokumen Pedoman</p>
            </div>
        </div>
        <!-- 3. Tahapan -->
        <div class="stat-card animate-up delay-3">
            <div class="stat-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                <i class="fas fa-list-check"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_tahapan ?></h3>
                <p>Item Tahapan</p>
            </div>
        </div>
        <!-- 4. Prestasi -->
        <div class="stat-card animate-up delay-4">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_prestasi ?></h3>
                <p>Mhs Berprestasi</p>
            </div>
        </div>
    </div>

    <!-- CHART GRID -->
    <div class="chart-grid">
        <!-- GRAFIK BERITA -->
        <div class="chart-card animate-up delay-1">
            <h3><i class="fas fa-newspaper"></i> Status Berita</h3>
            <div class="chart-container">
                <canvas id="grafikBerita"></canvas>
            </div>
        </div>

        <!-- GRAFIK PEDOMAN -->
        <div class="chart-card animate-up delay-2">
            <h3><i class="fas fa-book"></i> Status Pedoman</h3>
            <div class="chart-container">
                <canvas id="grafikPedoman"></canvas>
            </div>
        </div>

        <!-- GRAFIK TAHAPAN -->
        <div class="chart-card animate-up delay-3">
            <h3><i class="fas fa-list-check"></i> Status Tahapan</h3>
            <div class="chart-container">
                <canvas id="grafikTahapan"></canvas>
            </div>
        </div>

        <!-- GRAFIK PRESTASI -->
        <div class="chart-card animate-up delay-4">
            <h3><i class="fas fa-trophy"></i> Mahasiswa Berprestasi</h3>
            <div class="chart-container">
                <canvas id="grafikPrestasi"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
// --- CLOCK FUNCTION ---
function updateClock() {
    const now = new Date();
    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const dateStr = now.toLocaleDateString('id-ID', options);
    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }); 
    document.getElementById('liveClock').textContent = `${dateStr} — ${timeStr} WIB`;
}
setInterval(updateClock, 1000);
updateClock();

/* ====== CONFIG CHART ====== */
const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'bottom',
            labels: { font: { size: 11, family: 'Poppins' }, padding: 15, usePointStyle: true }
        },
        tooltip: {
            backgroundColor: 'rgba(78, 10, 138, 0.9)',
            padding: 12,
            titleFont: { size: 13, family: 'Poppins' },
            bodyFont: { size: 13, family: 'Poppins' },
            cornerRadius: 8,
            displayColors: false
        }
    },
    scales: {
        y: { 
            beginAtZero: true, 
            grid: { color: '#f0f0f0' },
            ticks: { font: { family: 'Poppins' }, color: '#666', stepSize: 1 }
        },
        x: { 
            grid: { display: false },
            ticks: { font: { family: 'Poppins' }, color: '#666' }
        }
    }
};

/* ========= Grafik Berita ========= */
new Chart(document.getElementById('grafikBerita'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_berita); ?>,
        datasets: [{
            label: "Jumlah Berita",
            data: <?= json_encode($jumlah_berita); ?>,
            backgroundColor: <?= json_encode($warna_berita); ?>,
            borderRadius: 6,
            barThickness: 40
        }]
    },
    options: commonOptions
});

/* ========= Grafik Pedoman ========= */
new Chart(document.getElementById('grafikPedoman'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_pedoman); ?>,
        datasets: [{
            label: "Jumlah Pedoman",
            data: <?= json_encode($jumlah_pedoman); ?>,
            backgroundColor: <?= json_encode($warna_pedoman); ?>,
            borderRadius: 6,
            barThickness: 40
        }]
    },
    options: commonOptions
});

/* ========= Grafik Tahapan ========= */
new Chart(document.getElementById('grafikTahapan'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_tahapan); ?>,
        datasets: [{
            label: "Item Tahapan",
            data: <?= json_encode($jumlah_tahapan); ?>,
            backgroundColor: <?= json_encode($warna_tahapan); ?>,
            borderRadius: 6,
            barThickness: 40
        }]
    },
    options: commonOptions
});

/* ========= Grafik Prestasi ========= */
new Chart(document.getElementById('grafikPrestasi'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($status_prestasi); ?>,
        datasets: [{
            label: "Mahasiswa Berprestasi",
            data: <?= json_encode($jumlah_prestasi); ?>,
            backgroundColor: <?= json_encode($warna_prestasi); ?>,
            borderRadius: 6,
            barThickness: 40
        }]
    },
    options: commonOptions
});
</script>

</body>
</html>
