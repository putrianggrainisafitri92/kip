<?php
session_start();
include "protect.php";
include "sidebar.php";
include "../koneksi.php";

// ==================== QUERY STATISTIK ====================

// 1. Data SK KIP (Total SK)
$q_sk = $koneksi->query("SELECT COUNT(*) FROM sk_kipk");
$total_sk = $q_sk ? $q_sk->fetch_row()[0] : 0;

// 2. Data Mahasiswa (Total Mahasiswa KIP)
$q_mhs = $koneksi->query("SELECT COUNT(*) FROM mahasiswa_kip");
$total_mahasiswa = $q_mhs ? $q_mhs->fetch_row()[0] : 0;

// 3. Data Laporan (Total Laporan)
$q_lapor = $koneksi->query("SELECT COUNT(*) FROM laporan");
$total_laporan = $q_lapor ? $q_lapor->fetch_row()[0] : 0;

// 4. Evaluasi Mhs (Total Data Evaluasi/Nilai/Berkas)
// Asumsi tabel evaluasi bernama 'mahasiswa_evaluasi' atau kita hitung mahasiswa aktif. 
// Tapi user ingin grafik sesuai sidebar. Sidebar "Evaluasi Mhs" biasanya link ke evaluasi_list.php
// Mari cek tabel yg relevan, mungkin 'mahasiswa_prestasi' atau 'mahasiswa_kip' status aktif?
// Atau kalau tidak ada tabel khusus evaluasi, kita pakai dummy atau count mahasiswa aktif.
// Di file list_dir tadi ada 'evaluasi_list.php', kemungkinan ada tabel evaluasi.
// Mari kita cek query di evaluasi_list.php nanti kalau perlu. Untuk sekarang kita pakai placeholder jika tabel tdk jelas, 
// tapi sebaiknya check connection.
// "mahasiswa_kip" seem to be the main table. Let's use status count for now if evaluasi table unknown.
// Or just reuse total mahasiswa for now but label it differently? 
// Wait, user wants "Grafik". 
// Let's create dummy distribution arrays for graphs to look nice like Pengurus dashboard.

// --- GRAFIK SK KIP (Per Tahun & Status) ---
$sk_labels = [];
$sk_years = [];
$sk_pending = [];
$sk_approve = [];
$sk_reject = [];
$raw_sk = [];

// Get all unique years first
$q_years = $koneksi->query("SELECT DISTINCT tahun FROM sk_kipk ORDER BY tahun ASC LIMIT 5");
if ($q_years) {
    while($r = $q_years->fetch_assoc()) {
        $sk_years[] = $r['tahun'];
    }
}

// Initialize structure
foreach ($sk_years as $y) {
    if (!isset($raw_sk[$y])) {
        $raw_sk[$y] = ['pending' => 0, 'approve' => 0, 'reject' => 0];
    }
}

// Fetch Data
$q_sk_stat = $koneksi->query("SELECT tahun, status, COUNT(*) as jml FROM sk_kipk GROUP BY tahun, status");
if ($q_sk_stat) {
    while($r = $q_sk_stat->fetch_assoc()) {
        $y = $r['tahun'];
        if (!in_array($y, $sk_years)) continue; // Skip if not in top years list

        $st = strtolower(trim($r['status']));
        if (strpos($st, 'approv') !== false || strpos($st, 'setuju') !== false || strpos($st, 'verif') !== false || $st == 'approved') {
            $raw_sk[$y]['approve'] += $r['jml'];
        } elseif (strpos($st, 'reject') !== false || strpos($st, 'tolak') !== false) {
            $raw_sk[$y]['reject'] += $r['jml'];
        } else {
            $raw_sk[$y]['pending'] += $r['jml'];
        }
    }
}

// Flatten
foreach ($sk_years as $y) {
    $sk_labels[] = "Tahun " . $y;
    $sk_pending[] = $raw_sk[$y]['pending'];
    $sk_approve[] = $raw_sk[$y]['approve'];
    $sk_reject[]  = $raw_sk[$y]['reject'];
}


// --- GRAFIK MAHASISWA PER TAHUN (SKEMA 1 vs SKEMA 2) ---
$years = [];
$skema1_data = [];
$skema2_data = [];
$raw_stats = [];

// Fetch data grouped by Year and Skema
$q_stats = $koneksi->query("SELECT tahun, skema, COUNT(*) as jml FROM mahasiswa_kip GROUP BY tahun, skema ORDER BY tahun ASC");

if ($q_stats) {
    while ($r = $q_stats->fetch_assoc()) {
        $yr = $r['tahun'];
        $sk = $r['skema'];
        if (empty($yr)) continue;

        if (!isset($raw_stats[$yr])) {
            $raw_stats[$yr] = ['s1' => 0, 's2' => 0];
        }

        // Logic to categorize Skema (Loose matching for '1' or '2')
        if (strpos($sk, '1') !== false) {
            $raw_stats[$yr]['s1'] += $r['jml'];
        } elseif (strpos($sk, '2') !== false) {
            $raw_stats[$yr]['s2'] += $r['jml'];
        } else {
             $raw_stats[$yr]['s1'] += $r['jml']; // Default/Fallback
        }
    }
}

// Flatten for Chart.js
foreach ($raw_stats as $y => $counts) {
    $years[] = "Tahun " . $y;
    $skema1_data[] = $counts['s1'];
    $skema2_data[] = $counts['s2'];
}


// --- GRAFIK LAPORAN (Hanya Diproses & Selesai) ---
$lapor_labels = ['Selesai', 'Diproses'];
$lapor_data = [0, 0]; // Index 0: Selesai, Index 1: Diproses

// Fetch raw data
$q_lapor_raw = $koneksi->query("SELECT status_tindak, COUNT(*) as jml FROM laporan GROUP BY status_tindak");
if ($q_lapor_raw) {
    while($r = $q_lapor_raw->fetch_assoc()) {
        $st = strtolower(trim($r['status_tindak'] ?? ''));
        $count = (int)$r['jml'];
        
        // Filter Logic: Only Selesai and Proses
        if ($st === 'selesai' || $st === 'approve' || $st === 'approved') {
            $lapor_data[0] += $count; // Selesai
        } elseif ($st === 'diproses' || $st === 'proses' || $st === 'pending' || $st === '') {
            $lapor_data[1] += $count; // Diproses
        }
        // Reject is ignored as per request
    }
}

// --- GRAFIK EVALUASI (Validasi Status) ---
$eval_labels = [];
$eval_data = [];
$eval_colors = []; 

$total_evaluasi = $koneksi->query("SELECT COUNT(*) FROM evaluasi")->fetch_row()[0] ?? 0;

$q_eval = $koneksi->query("SELECT status_verifikasi, COUNT(*) as jml FROM evaluasi GROUP BY status_verifikasi");
if ($q_eval && $q_eval->num_rows > 0) {
    while($r = $q_eval->fetch_assoc()) {
        $status = $r['status_verifikasi'];
        if ($status === null || $status === '') {
            $status = 'Menunggu';
        }
        $eval_labels[] = $status;
        $eval_data[] = (int)$r['jml'];
        
        // Color Logic (Existing)
        $s_lower = strtolower($status);
        if (strpos($s_lower, 'diterima') !== false || strpos($s_lower, 'verified') !== false) {
            $eval_colors[] = '#4caf50'; // Green
        } elseif (strpos($s_lower, 'belum') !== false || strpos($s_lower, 'belum diverifikasi') !== false || strpos($s_lower, 'ditolak') !== false || strpos($s_lower, 'reject') !== false) {
            $eval_colors[] = '#f44336'; // Red
        } else {
            $eval_colors[] = '#ff9800'; // Orange
        }
    }
} else {
    $eval_labels = ['Menunggu', 'Diterima', 'Belum Diverifikasi'];
    $eval_data = [0, 0, 0];
    $eval_colors = ['#ff9800', '#4caf50', '#f44336'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | KIP Kuliah Polinela</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

        /* MAIN CONTENT */
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

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(78, 10, 138, 0.05);
            border: 1px solid rgba(123, 53, 212, 0.1);
            display: flex;
            flex-direction: column;
        }

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
        <span>Dashboard Admin — <?= htmlspecialchars($_SESSION['username']) ?></span>
    </div>
    <div class="header-right">
        <i class="far fa-clock"></i>
        <span id="liveClock">Loading...</span>
    </div>
</div>

<div class="main-container">

    <!-- TOP STATS -->
    <div class="stats-grid">
        <!-- 1. SK KIP -->
        <div class="stat-card animate-up delay-1">
            <div class="stat-icon" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <i class="fas fa-file-contract"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_sk ?></h3>
                <p>Total SK KIP</p>
            </div>
        </div>
        <!-- 2. Data Mahasiswa -->
        <div class="stat-card animate-up delay-2">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ff9966, #ff5e62);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_mahasiswa ?></h3>
                <p>Total Mahasiswa</p>
            </div>
        </div>
        <!-- 3. Data Laporan -->
        <div class="stat-card animate-up delay-3">
            <div class="stat-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_laporan ?></h3>
                <p>Data Laporan</p>
            </div>
        </div>
        <!-- 4. Evaluasi Mhs -->
        <div class="stat-card animate-up delay-4">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_evaluasi ?></h3>
                <p>Evaluasi Mhs</p>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="chart-grid">
        <!-- Grafik SK KIP -->
        <div class="chart-card animate-up delay-1">
            <h3><i class="fas fa-file-contract"></i> Statistik SK per Tahun</h3>
            <div class="chart-container">
                <canvas id="chartSK"></canvas>
            </div>
        </div>

        <!-- Grafik Mahasiswa -->
        <div class="chart-card animate-up delay-2">
            <h3><i class="fas fa-calendar-alt"></i> Mahasiswa per Tahun (Skema)</h3>
            <div class="chart-container">
                <canvas id="chartMhs"></canvas>
            </div>
        </div>

        <!-- Grafik Laporan -->
        <div class="chart-card animate-up delay-3">
            <h3><i class="fas fa-file-invoice"></i> Status Laporan</h3>
            <div class="chart-container">
                <canvas id="chartLapor"></canvas>
            </div>
        </div>

        <!-- Grafik Evaluasi -->
        <div class="chart-card animate-up delay-4">
            <h3><i class="fas fa-check-circle"></i> Validasi Evaluasi</h3>
            <div class="chart-container">
                <canvas id="chartEval"></canvas>
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

const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'bottom', labels: { font: { family: 'Poppins' }, usePointStyle: true } },
        tooltip: {
            backgroundColor: 'rgba(78, 10, 138, 0.9)',
            padding: 10,
            cornerRadius: 10,
        }
    },
    animation: {
        duration: 2000,
        easing: 'easeOutQuart'
    },
    scales: { x: { grid: { display:false } }, y: { beginAtZero: true, grid: { color:'#f0f0f0' } } }
};

// 1. Chart SK (Status Stacked: Pending, Approve, Reject)
new Chart(document.getElementById('chartSK'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($sk_labels) ?>,
        datasets: [
            {
                label: 'Approve',
                data: <?= json_encode($sk_approve) ?>,
                backgroundColor: '#4caf50', // Green
                borderRadius: 4
            },
            {
                label: 'Pending',
                data: <?= json_encode($sk_pending) ?>,
                backgroundColor: '#ff9800', // Orange
                borderRadius: 4
            },
            {
                label: 'Reject',
                data: <?= json_encode($sk_reject) ?>,
                backgroundColor: '#d32f2f', // Red
                borderRadius: 4
            }
        ]
    },
    options: {
        ...commonOptions,
        scales: {
             x: { stacked: true, grid: { display:false } },
             y: { stacked: true, beginAtZero: true }
        }
    }
});

// 2. Chart Mahasiswa (Per Tahun Grouped Skema)
new Chart(document.getElementById('chartMhs'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($years) ?>,
        datasets: [
            {
                label: 'Skema 1',
                data: <?= json_encode($skema1_data) ?>,
                backgroundColor: '#4e0a8a',
                borderRadius: 4,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            },
            {
                label: 'Skema 2',
                data: <?= json_encode($skema2_data) ?>,
                backgroundColor: '#9c27b0',
                borderRadius: 4,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            }
        ]
    },
    options: {
        ...commonOptions,
        scales: {
            x: { grid: { display: false } },
            y: { beginAtZero: true }
        }
    }
});

// 3. Chart Laporan (Status: Diproses, Selesai)
new Chart(document.getElementById('chartLapor'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($lapor_labels) ?>,
        datasets: [{
            data: <?= json_encode($lapor_data) ?>,
            backgroundColor: ['#4caf50', '#ff9800'], // Selesai=Green, Diproses=Orange
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: { 
            legend: { position: 'right', labels: { font: { family: 'Poppins' } } },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.raw;
                    }
                }
            }
        }
    }
});

// 4. Chart Evaluasi (Validasi) - CUSTOM COLORS
new Chart(document.getElementById('chartEval'), {
    type: 'pie',
    data: {
        labels: <?= json_encode($eval_labels) ?>,
        datasets: [{
            data: <?= json_encode($eval_data) ?>,
            backgroundColor: <?= json_encode($eval_colors) ?>, 
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { position: 'right', labels: { font: { family: 'Poppins' } } } 
        }
    }
});
</script>

</body>
</html>
