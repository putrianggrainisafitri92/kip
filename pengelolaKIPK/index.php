<?php
include __DIR__ . '/../koneksi.php';


// Ambil IP dan tanggal hari ini
$ip = $_SERVER['REMOTE_ADDR'];
$tanggal = date('Y-m-d');

// Cek apakah IP ini sudah tercatat hari ini
$cek = mysqli_query($koneksi,
    "SELECT * FROM visitor_log 
     WHERE ip_address='$ip' AND visit_date='$tanggal'"
);

// Jika belum → simpan sebagai pengunjung baru
if (mysqli_num_rows($cek) == 0) {
    mysqli_query($koneksi,
        "INSERT INTO visitor_log (ip_address, visit_date)
         VALUES ('$ip', '$tanggal')"
    );
}

// Hitung total pengunjung
$q1 = mysqli_query($koneksi, 
    "SELECT COUNT(*) AS total FROM visitor_log"
);
$total_pengunjung = mysqli_fetch_assoc($q1)['total'];

// Hitung pengunjung hari ini
$q2 = mysqli_query($koneksi,
    "SELECT COUNT(*) AS hari_ini FROM visitor_log
     WHERE visit_date='$tanggal'"
);
$pengunjung_hari_ini = mysqli_fetch_assoc($q2)['hari_ini'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda | Sistem Informasi KIP-K POLINELA</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#4B007D] to-[#5A0AA8]">

  <?php include 'sidebar.php'; ?>

  <!-- KONTEN UTAMA -->
  <div id="main-content" class="ml-0 md:ml-64 transition-all duration-300 p-6 pt-20 space-y-8">

    <!-- HERO CARD -->
    <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-xl p-10 text-center text-white fade-in">
      <h1 class="text-4xl font-extrabold mb-4">Sistem Informasi KIP-K Politeknik Negeri Lampung</h1>
      <p class="text-gray-200 text-lg">
        Portal pengelolaan data, evaluasi, pelaporan, dan penerbitan SK mahasiswa penerima KIP-K
      </p>
    </div>

    <!-- STATISTIK -->
    <div class="grid md:grid-cols-3 gap-6 fade-in">

      <div class="bg-white rounded-2xl p-6 shadow-xl border-l-4 border-purple-500">
        <h3 class="text-lg font-bold text-gray-800">Pengunjung Hari Ini</h3>
        <p class="text-3xl font-extrabold text-purple-700"><?= $pengunjung_hari_ini ?></p>
      </div>

      <div class="bg-white rounded-2xl p-6 shadow-xl border-l-4 border-purple-700">
        <h3 class="text-lg font-bold text-gray-800">Total Pengunjung</h3>
        <p class="text-3xl font-extrabold text-purple-900"><?= $total_pengunjung ?></p>
      </div>

      <div class="bg-white rounded-2xl p-6 shadow-xl border-l-4 border-indigo-700">
        <h3 class="text-lg font-bold text-gray-800">Status Sistem</h3>
        <p class="text-xl font-semibold text-gray-700">Aktif & Berjalan</p>
      </div>

    </div>

    <!-- MENU CEPAT / DASHBOARD -->
    <div class="grid md:grid-cols-3 gap-6 text-center fade-in">

      <a href="evaluasi_list.php"
         class="bg-white/10 hover:bg-white/20 text-white font-semibold py-6 rounded-2xl shadow-xl transition transform hover:scale-105">
        📊 Kelola Evaluasi
      </a>

      <a href="pelaporan.php"
         class="bg-white/10 hover:bg-white/20 text-white font-semibold py-6 rounded-2xl shadow-xl transition transform hover:scale-105">
        📝 Kelola Pelaporan
      </a>

      <a href="mahasiswa.php"
         class="bg-white/10 hover:bg-white/20 text-white font-semibold py-6 rounded-2xl shadow-xl transition transform hover:scale-105">
        🎓 Kelola Mahasiswa + SK
      </a>

    </div>

    <!-- INFORMASI TAMBAHAN -->
    <div class="bg-soft-white rounded-2xl shadow-xl p-8 fade-in">
      <h2 class="text-2xl font-bold text-primary-mid mb-4">Fitur Utama</h2>
      <ul class="space-y-2 text-gray-700 text-justify">
        <li>• Pengelolaan data mahasiswa penerima KIP-K</li>
        <li>• Input evaluasi per semester</li>
        <li>• Pembuatan laporan otomatis</li>
        <li>• Upload dan penerbitan SK mahasiswa</li>
        <li>• Statistik visitor real-time</li>
      </ul>
    </div>

  </div>

</body>
</html>
