<?php
session_start();
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

// Ambil nama lengkap dari session
$nama = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : "admin";

// ==================== QUERY STATISTIK (Task List / To-Do) ====================

// 1. Validasi Berita (Pending)
$q_berita = mysqli_query($koneksi, "SELECT COUNT(*) FROM berita WHERE status='pending'");
$h_berita = mysqli_fetch_row($q_berita)[0];

// 2. Validasi SK (Pending)
$q_sk = mysqli_query($koneksi, "SELECT COUNT(*) FROM sk_kipk WHERE status='pending'");
$h_sk = mysqli_fetch_row($q_sk)[0];

// 3. Validasi Pedoman (Pending)
$q_pedoman = mysqli_query($koneksi, "SELECT COUNT(*) FROM pedoman WHERE status='pending'");
$h_pedoman = mysqli_fetch_row($q_pedoman)[0];

// 4. Validasi Tahapan (Pending)
$q_tahapan = mysqli_query($koneksi, "SELECT COUNT(*) FROM pedoman_tahapan WHERE status='pending'");
$h_tahapan = mysqli_fetch_row($q_tahapan)[0];

// 5. Validasi Jumlah KIP (Mahasiswa Pending)
$q_kip = mysqli_query($koneksi, "SELECT COUNT(*) FROM mahasiswa_kip WHERE status='pending'");
$h_kip = mysqli_fetch_row($q_kip)[0];

// 6. Validasi Prestasi (Pending)
$q_prestasi = mysqli_query($koneksi, "SELECT COUNT(*) FROM mahasiswa_prestasi WHERE status='pending'");
$h_prestasi = mysqli_fetch_row($q_prestasi)[0];

// 7. Lihat Laporan (Pending + Diproses)
$q_lapor = mysqli_query($koneksi, "SELECT COUNT(*) FROM laporan WHERE status_tindak='pending' OR status_tindak='diproses'");
$h_lapor = mysqli_fetch_row($q_lapor)[0];

// 8. Lihat Evaluasi (Belum Diverifikasi)
// Assuming table 'evaluasi' and column 'status_verifikasi' being NULL or 'Belum Diverifikasi'
// Or counting plain records if no complex status logic exists yet. Let's check logic used in charts:
// Chart used 'status_verifikasi'.
$q_eval = mysqli_query($koneksi, "SELECT COUNT(*) FROM evaluasi WHERE status_verifikasi IS NULL OR status_verifikasi='Belum Diverifikasi' OR status_verifikasi='pending'");
$h_eval = mysqli_fetch_row($q_eval)[0];

// 9. Total User (CRUD User)
$q_user = mysqli_query($koneksi, "SELECT COUNT(*) FROM admin");
$h_user = mysqli_fetch_row($q_user)[0];

// 10. Saran (Total)
$q_saran = mysqli_query($koneksi, "SELECT COUNT(*) FROM saran");
$h_saran = mysqli_fetch_row($q_saran)[0];

// 11. Pertanyaan (Belum Dijawab)
$q_tanya = mysqli_query($koneksi, 
    "SELECT COUNT(*) FROM pertanyaan WHERE status_balasan='belum'");
$h_tanya = mysqli_fetch_row($q_tanya)[0] ?? 0;

// ==================== CHART DATA EXTENSION ====================

// A. Saran Trend (Per Month)
$saran_labels = [];
$saran_data = [];
// Group by Year-Month
$q_saran_trend = mysqli_query($koneksi, "SELECT DATE_FORMAT(tanggal, '%M %Y') as periode, COUNT(*) as jml, MAX(tanggal) as tgl_sort FROM saran GROUP BY YEAR(tanggal), MONTH(tanggal) ORDER BY tgl_sort ASC LIMIT 12");
while($r = mysqli_fetch_assoc($q_saran_trend)){
    $saran_labels[] = $r['periode'];
    $saran_data[] = (int)$r['jml'];
}
// Color for Saran (Single color)
$saran_colors = array_fill(0, count($saran_labels), '#7b35d4');


// --- DATA FOR CHARTS ---

function getChartStats($koneksi, $table, $col_status) {
    $labels = []; 
    $data = []; 
    $colors = [];
    
    // Default colors
    $c_green = '#4caf50';
    $c_orange = '#ff9800';
    $c_red = '#f44336';
    $c_def = '#4e0a8a';

    $q = mysqli_query($koneksi, "SELECT $col_status, COUNT(*) as jml FROM $table GROUP BY $col_status");
    
    while($r = mysqli_fetch_assoc($q)) {
        $st_raw = $r[$col_status];
        if ($st_raw == '' || $st_raw == null) $st_raw = 'Belum';
        
        $st = strtolower($st_raw);
        $labels[] = ucfirst($st_raw);
        $data[] = (int)$r['jml'];

        // Assign Color
        if (in_array($st, ['approved', 'approve', 'selesai', 'diterima', 'verified', 'sudah', 'valid'])) {
            $colors[] = $c_green;
        } elseif (in_array($st, ['rejected', 'reject', 'ditolak', 'gagal', 'tidak valid'])) {
            $colors[] = $c_red;
        } elseif (in_array($st, ['pending', 'diproses', 'proses', 'menunggu', 'belum', 'belum diverifikasi'])) {
            $colors[] = $c_orange;
        } else {
            $colors[] = $c_def;
        }
    }
    return ['labels' => $labels, 'data' => $data, 'colors' => $colors];
}

$c_berita = getChartStats($koneksi, 'berita', 'status');
$c_sk = getChartStats($koneksi, 'sk_kipk', 'status');
$c_pedoman = getChartStats($koneksi, 'pedoman', 'status');
$c_tahapan = getChartStats($koneksi, 'pedoman_tahapan', 'status');
$c_prestasi = getChartStats($koneksi, 'mahasiswa_prestasi', 'status');
$c_lapor = getChartStats($koneksi, 'laporan', 'status_tindak');
$c_eval = getChartStats($koneksi, 'evaluasi', 'status_verifikasi');
$c_tanya = getChartStats($koneksi, 'pertanyaan', 'status_balasan');

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.1s; }
        .delay-3 { animation-delay: 0.15s; }
        .delay-4 { animation-delay: 0.2s; }
        .delay-5 { animation-delay: 0.25s; }
        .delay-6 { animation-delay: 0.3s; }
        .delay-7 { animation-delay: 0.35s; }
        .delay-8 { animation-delay: 0.4s; }
        .delay-9 { animation-delay: 0.45s; }
        .delay-10 { animation-delay: 0.5s; }

        /* HEADER */
        .header-bar {
            margin-left: 240px;
            background: linear-gradient(90deg, #4e0a8a, #7b35d4);
            padding: 15px 30px;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: sticky; top: 0; z-index: 50;
            display: flex; justify-content: space-between; align-items: center;
        }

        .header-left { font-size: 20px; font-weight: 600; display: flex; align-items: center; }
        .header-right { font-size: 14px; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 20px; }

        /* MAIN CONTENT */
        .main-container {
            margin-left: 240px;
            padding: 30px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* STATS GRID - 5 items per row ideally, but auto-fit */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        /* STAT_CARD MATCHING PENGURUS */
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
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(78, 10, 138, 0.15); }

        /* Icon Base Style */
        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: white;
            flex-shrink: 0;
            /* Gradient handled inline per card */
        }

        .stat-info h3 { margin: 0; font-size: 24px; color: #4e0a8a; font-weight: 800; }
        .stat-info p { margin: 5px 0 0; font-size: 12px; color: #666; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Notification Badge for high numbers */
        .alert-badge {
            position: absolute; top: 10px; right: 10px;
            background: #ff4757; color: white;
            font-size: 10px; padding: 2px 6px; border-radius: 10px;
            font-weight: bold;
        }

        /* CHART GRID */
        .chart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(78, 10, 138, 0.05);
            border: 1px solid rgba(123, 53, 212, 0.1);
            transition: .3s ease;
            display: flex; flex-direction: column;
        }
        
        .chart-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(78, 10, 138, 0.15); }
        
        .chart-card h3 {
            margin: 0 0 15px 0;
            font-size: 18px; color: #4e0a8a; font-weight: 700;
            border-bottom: 2px solid #f3e8ff; padding-bottom: 10px;
            display: flex; align-items: center; gap: 10px;
        }
        
        .chart-container { height: 250px; width: 100%; position: relative; }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .header-bar, .main-container { margin-left: 0; }
            .header-bar { padding-left: 60px; } 
        }
        @media (max-width: 768px) {
            .chart-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<div class="header-bar animate-up">
    <div class="header-left">
        <i class="fas fa-desktop mr-2"></i> 
        <span>Dashboard Kabag — <?= htmlspecialchars($nama) ?></span>
    </div>
    <div class="header-right">
        <i class="far fa-clock"></i>
        <span id="liveClock">Loading...</span>
    </div>
</div>

<div class="main-container">

    <!-- DASHBOARD STATS (11 Items) -->
    <div class="stats-grid">
        
        <!-- 1. Validasi Berita -->
        <div class="stat-card animate-up delay-1">
            <div class="stat-icon" style="background: linear-gradient(135deg, #6a11cb, #2575fc);"><i class="fa-solid fa-newspaper"></i></div>
            <div class="stat-info">
                <h3><?= $h_berita ?></h3>
                <p>Validasi Berita</p>
                <?php if($h_berita > 0) echo '<span class="alert-badge">!</span>'; ?>
            </div>
        </div>

        <!-- 2. Validasi SK -->
        <div class="stat-card animate-up delay-2">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ff9966, #ff5e62);"><i class="fa-solid fa-file-signature"></i></div>
            <div class="stat-info">
                <h3><?= $h_sk ?></h3>
                <p>Validasi SK</p>
            </div>
        </div>

        <!-- 3. Validasi Pedoman -->
        <div class="stat-card animate-up delay-3">
            <div class="stat-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);"><i class="fa-solid fa-book"></i></div>
            <div class="stat-info">
                <h3><?= $h_pedoman ?></h3>
                <p>Validasi Pedoman</p>
            </div>
        </div>

        <!-- 4. Validasi Tahapan -->
        <div class="stat-card animate-up delay-4">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);"><i class="fa-solid fa-list-check"></i></div>
            <div class="stat-info">
                <h3><?= $h_tahapan ?></h3>
                <p>Validasi Tahapan</p>
            </div>
        </div>

        <!-- 5. Validasi Jumlah KIP (Mahasiswa Pending) -->
        <div class="stat-card animate-up delay-5">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-info">
                <h3><?= $h_kip ?></h3>
                <p>Validasi Jml KIP</p>
            </div>
        </div>
        
        <!-- 6. Validasi Prestasi -->
        <div class="stat-card animate-up delay-6">
            <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);"><i class="fa-solid fa-user-graduate"></i></div>
            <div class="stat-info">
                <h3><?= $h_prestasi ?></h3>
                <p>Validasi Prestasi</p>
            </div>
        </div>

        <!-- 7. Lihat Laporan -->
        <div class="stat-card animate-up delay-7">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);"><i class="fa-solid fa-chart-line"></i></div>
            <div class="stat-info">
                <h3><?= $h_lapor ?></h3>
                <p>Laporan Masuk</p>
            </div>
        </div>

        <!-- 8. Lihat Evaluasi -->
        <div class="stat-card animate-up delay-8">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);"><i class="fa-solid fa-clipboard-check"></i></div>
            <div class="stat-info">
                <h3><?= $h_eval ?></h3>
                <p>Cek Evaluasi</p>
            </div>
        </div>

        <!-- 9. CRUD User (Total) -->
        <div class="stat-card animate-up delay-9">
            <div class="stat-icon" style="background: linear-gradient(135deg, #89f7fe, #66a6ff);"><i class="fa-solid fa-users-cog"></i></div>
            <div class="stat-info">
                <h3><?= $h_user ?></h3>
                <p>Total User</p>
            </div>
        </div>

        <!-- 10. Saran -->
        <div class="stat-card animate-up delay-10">
            <div class="stat-icon" style="background: linear-gradient(135deg, #c471f5, #fa71cd);"><i class="fa-solid fa-lightbulb"></i></div>
            <div class="stat-info">
                <h3><?= $h_saran ?></h3>
                <p>Saran Masuk</p>
            </div>
        </div>

        <!-- 11. Pertanyaan (Unanswered) -->
        <div class="stat-card animate-up delay-10">
            <div class="stat-icon" style="background: linear-gradient(135deg, #48c6ef, #6f86d6);"><i class="fa-solid fa-circle-question"></i></div>
            <div class="stat-info">
                <h3><?= $h_tanya ?></h3>
                <p>Pertanyaan</p>
            </div>
        </div>

    </div>

    <!-- CHARTS GRID: Matching the Stats Boxes where applicable -->
    <div class="chart-grid">
        <!-- 1. Berita -->
        <div class="chart-card animate-up delay-1">
            <h3><i class="fa-solid fa-newspaper"></i> Statistik Berita</h3>
            <div class="chart-container"><canvas id="cBerita"></canvas></div>
        </div>
        <!-- 2. SK -->
        <div class="chart-card animate-up delay-2">
            <h3><i class="fa-solid fa-file-signature"></i> Statistik SK</h3>
            <div class="chart-container"><canvas id="cSK"></canvas></div>
        </div>
        <!-- 3. Pedoman -->
        <div class="chart-card animate-up delay-3">
            <h3><i class="fa-solid fa-book"></i> Statistik Pedoman</h3>
            <div class="chart-container"><canvas id="cPedoman"></canvas></div>
        </div>
        <!-- 4. Tahapan -->
        <div class="chart-card animate-up delay-4">
            <h3><i class="fa-solid fa-list-check"></i> Statistik Tahapan</h3>
            <div class="chart-container"><canvas id="cTahapan"></canvas></div>
        </div>
        <!-- 5. Prestasi -->
        <div class="chart-card animate-up delay-5">
            <h3><i class="fa-solid fa-user-graduate"></i> Statistik Prestasi</h3>
            <div class="chart-container"><canvas id="cPrestasi"></canvas></div>
        </div>
        <!-- 6. Laporan -->
        <div class="chart-card animate-up delay-6">
            <h3><i class="fa-solid fa-chart-line"></i> Statistik Laporan</h3>
            <div class="chart-container"><canvas id="cLapor"></canvas></div>
        </div>
        <!-- 7. Evaluasi -->
        <div class="chart-card animate-up delay-7">
            <h3><i class="fa-solid fa-clipboard-check"></i> Statistik Evaluasi</h3>
            <div class="chart-container"><canvas id="cEval"></canvas></div>
        </div>

        <!-- 8. Saran (Trend) -->
        <div class="chart-card animate-up delay-8">
            <h3><i class="fa-solid fa-lightbulb"></i> Trend Saran Masuk</h3>
            <div class="chart-container"><canvas id="cSaran"></canvas></div>
        </div>

        <!-- 9. Pertanyaan (Status) -->
        <div class="chart-card animate-up delay-9">
            <h3><i class="fa-solid fa-circle-question"></i> Statistik Pertanyaan</h3>
            <div class="chart-container"><canvas id="cPertanyaan"></canvas></div>
        </div>
    </div>

</div>

<script>
// CLOCK
function updateClock() {
    const now = new Date();
    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('liveClock').textContent = 
        `${now.toLocaleDateString('id-ID', options)} — ${now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} WIB`;
}
setInterval(updateClock, 1000);
updateClock();

// CHART CONFIG HELPER
function createChart(ctxId, labelName, labels, data, colors) {
    new Chart(document.getElementById(ctxId), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: labelName,
                data: data,
                backgroundColor: colors,
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { 
                    backgroundColor: 'rgba(78, 10, 138, 0.9)',
                    titleFont: { family: 'Poppins' },
                    bodyFont: { family: 'Poppins' }
                }
            },
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });
}

// RENDER CHARTS
createChart('cBerita', 'Jumlah Berita', <?= json_encode($c_berita['labels']) ?>, <?= json_encode($c_berita['data']) ?>, <?= json_encode($c_berita['colors']) ?>);
createChart('cSK', 'Jumlah SK', <?= json_encode($c_sk['labels']) ?>, <?= json_encode($c_sk['data']) ?>, <?= json_encode($c_sk['colors']) ?>);
createChart('cPedoman', 'Jumlah Pedoman', <?= json_encode($c_pedoman['labels']) ?>, <?= json_encode($c_pedoman['data']) ?>, <?= json_encode($c_pedoman['colors']) ?>);
createChart('cTahapan', 'Jumlah Tahapan', <?= json_encode($c_tahapan['labels']) ?>, <?= json_encode($c_tahapan['data']) ?>, <?= json_encode($c_tahapan['colors']) ?>);
createChart('cPrestasi', 'Jumlah Prestasi', <?= json_encode($c_prestasi['labels']) ?>, <?= json_encode($c_prestasi['data']) ?>, <?= json_encode($c_prestasi['colors']) ?>);
createChart('cLapor', 'Jumlah Laporan', <?= json_encode($c_lapor['labels']) ?>, <?= json_encode($c_lapor['data']) ?>, <?= json_encode($c_lapor['colors']) ?>);
createChart('cEval', 'Jumlah Evaluasi', <?= json_encode($c_eval['labels']) ?>, <?= json_encode($c_eval['data']) ?>, <?= json_encode($c_eval['colors']) ?>);
createChart('cSaran', 'Jumlah Saran', <?= json_encode($saran_labels) ?>, <?= json_encode($saran_data) ?>, <?= json_encode($saran_colors) ?>);
createChart('cPertanyaan', 'Jumlah Pertanyaan', <?= json_encode($c_tanya['labels']) ?>, <?= json_encode($c_tanya['data']) ?>, <?= json_encode($c_tanya['colors']) ?>);
</script>

</body>
</html>
