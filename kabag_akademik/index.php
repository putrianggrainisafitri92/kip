<?php
include '../protect.php';
check_level(13);       // pastikan user level Kabag Akademik
include '../koneksi.php';
include 'sidebar.php';

// Ambil nama lengkap dari session, jika tidak ada beri default
$nama = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : "User";

// Hitung berita pending
$jml_berita = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM berita WHERE status='pending'"
))['jml'];

// Hitung SK pending
$jml_sk = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM sk_kipk WHERE status='pending'"
))['jml'];

// Hitung KIP pending
$jml_kip = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM mahasiswa_kip WHERE status='pending'"
))['jml'];

// Hitung Pedoman pending
$jml_pedoman = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM pedoman WHERE status='pending'"
))['jml'];

// Hitung status untuk grafik
$valid_berita = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM berita WHERE status='approved'"
))['jml'];
$pending_berita = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM berita WHERE status='pending'"
))['jml'];

$valid_sk = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM sk_kipk WHERE status='approved'"
))['jml'];
$pending_sk = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM sk_kipk WHERE status='pending'"
))['jml'];

$valid_kip = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM mahasiswa_kip WHERE status='approved'"
))['jml'];
$pending_kip = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM mahasiswa_kip WHERE status='pending'"
))['jml'];

$valid_pedoman = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM pedoman WHERE status='approved'"
))['jml'];
$pending_pedoman = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM pedoman WHERE status='pending'"
))['jml'];


?>

<style>

body {
    background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
    background-size: cover;
}


.main-content {
    margin-left: 240px;
    padding: 0px;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

.card-box {
    padding: 20px;
    border-radius: 12px;
    color: #fff;
    flex: 1;
    min-width: 230px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transition: 0.2s ease-in-out;
}
.card-box:hover {
    transform: translateY(-5px);
}
.chart-card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
</style>

<div class="main-content">
    <div style="
     background: linear-gradient(180deg, #4e0a8a, #7b35d4); /* UNGU GRADIENT */
    color: white; 
    padding: 18px 25px; 
    border-radius: 10px; 
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
">
    <h2>Selamat datang Kabag Akademik</h2>
    <div style="font-size: 16px; margin-top: 5px;" id="jamRealtime"></div>
</div>


    <!-- Kartu Statistik -->
    <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">
        <div class="card-box" style="background:#3949AB;">
            <h3>Validasi Berita</h3>
            <p><?= $jml_berita ?> berita menunggu validasi</p>
        </div>
        <div class="card-box" style="background:#1E88E5;">
            <h3>Validasi SK</h3>
            <p><?= $jml_sk ?> SK menunggu validasi</p>
        </div>
        <div class="card-box" style="background:#43A047;">
            <h3>Validasi KIP</h3>
            <p><?= $jml_kip ?> KIP menunggu validasi</p>
        </div>
        <div class="card-box" style="background:#8E24AA;">
            <h3>Validasi Pedoman</h3>
            <p><?= $jml_pedoman ?> pedoman menunggu validasi</p>
        </div>
    </div>

    <!-- Grafik -->
    <div class="chart-card" style="margin-top:40px;">
        <h3 style="margin-bottom:15px;">Perbandingan Status Validasi</h3>
        <canvas id="chartValidasi" style="max-height:340px;"></canvas>
    </div>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chartValidasi'), {
    type: 'line',
    data: {
        labels: ['Berita', 'SK', 'KIP', 'Pedoman'],
        datasets: [
            {
                label: 'Valid',
                data: [
                    <?= $valid_berita ?>,
                    <?= $valid_sk ?>,
                    <?= $valid_kip ?>,
                    <?= $valid_pedoman ?>
                ],
                borderColor: '#43A047',
                backgroundColor: 'rgba(67,160,71,0.25)',
                tension: 0.4,
                borderWidth: 3
            },
            {
                label: 'Pending',
                data: [
                    <?= $pending_berita ?>,
                    <?= $pending_sk ?>,
                    <?= $pending_kip ?>,
                    <?= $pending_pedoman ?>
                ],
                borderColor: '#FB8C00',
                backgroundColor: 'rgba(251,140,0,0.25)',
                tension: 0.4,
                borderDash: [6,4],
                borderWidth: 3
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: {
                labels: {
                    font: { weight: 600 }
                }
            }
        }
    }
});

</script>

<script>
// Jam realtime + hari + tanggal Indonesia
function updateTime() {
    const hariIndo = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
    const bulanIndo = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    const now = new Date();
    const hari = hariIndo[now.getDay()];
    const tanggal = now.getDate();
    const bulan = bulanIndo[now.getMonth()];
    const tahun = now.getFullYear();

    let jam = now.getHours().toString().padStart(2, '0');
    let menit = now.getMinutes().toString().padStart(2, '0');
    let detik = now.getSeconds().toString().padStart(2, '0');

    document.getElementById("jamRealtime").innerHTML =
        `${hari}, ${tanggal} ${bulan} ${tahun} | ${jam}:${menit}:${detik}`;
}

setInterval(updateTime, 1000);
updateTime();
</script>

