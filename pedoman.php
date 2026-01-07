<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedoman KIP-Kuliah 202</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('assets/bgpolinela.jpeg') no-repeat center center fixed;
      background-size: cover;
      overflow-x: hidden;
    }

    /* Header */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 70px;
      background: linear-gradient(90deg, #4a148c, #6a1b9a);
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
      padding: 0 25px;
      box-shadow: 0 3px 12px rgba(0,0,0,0.2);
      z-index: 1001;
    }
    .header img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
    }
    .header h1 {
      font-size: 20px;
      font-weight: 600;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: -260px;
      width: 250px;
      height: 100vh;
      background-color: #2b0066;
      color: white;
      padding-top: 70px;
      transition: all 0.3s ease;
      z-index: 1002;
      box-shadow: 3px 0 10px rgba(0,0,0,0.3);
    }
    .sidebar.active {
      left: 0;
    }

    .sidebar ul li {
      padding: 15px 25px;
      transition: 0.3s;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .sidebar ul li:hover {
      background: rgba(255,255,255,0.15);
    }

    /* Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInLeft {
      from { opacity: 0; transform: translateX(-30px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes zoomIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }

    .animate-fade-up { animation: fadeInUp 0.8s ease-out fill-mode: both; }
    .animate-slide-left { animation: slideInLeft 0.8s ease-out fill-mode: both; }
    .animate-zoom { animation: zoomIn 0.8s ease-out fill-mode: both; }

    .card-section {
      background: white;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      margin-bottom: 40px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-section:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(106, 27, 154, 0.2);
    }

    .benefit-card {
      transition: all 0.3s ease;
    }
    .benefit-card:hover {
      transform: scale(1.03);
      background: white;
    }

    .step-card {
      transition: all 0.3s ease;
    }
    .step-card:hover {
      transform: translateX(10px);
      background: #f3e8ff;
    }

    .main-content {
      transition: margin-left 0.3s ease;
      margin-top: 100px;
      padding: 25px;
    }

    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 1024px) {
      .header h1 {
        font-size: 16px;
      }
      .main-content {
        padding: 20px;
      }
      .card-section {
        padding: 30px;
      }
    }

    @media (max-width: 768px) {
      .header {
        padding: 0 15px;
        height: 60px;
      }
      .header h1 {
        font-size: 14px;
      }
      .header img {
        width: 35px;
        height: 35px;
      }
      .main-content {
        margin-top: 65px; /* Lebih rapat ke header */
        padding: 10px;
      }
      .main-content.shifted {
        margin-left: 0;
      }
      .card-section {
        padding: 15px;       
        border-radius: 15px;
        margin-bottom: 15px; /* Jarak antar kartu lebih dekat */
      }
      .card-section h1 {
        font-size: 1.5rem !important;
      }
      .card-section h3 {
        font-size: 1.15rem !important;
      }
      .grid.md\:grid-cols-2 {
        grid-template-columns: 1fr !important;
        gap: 15px !important; /* Jarak grid lebih rapat */
      }
      .grid.md\:grid-cols-5 {
        grid-template-columns: repeat(2, 1fr) !important;
      }
    }

    @media (max-width: 480px) {
      .header h1 {
        font-size: 12px;
      }
      .main-content {
        padding: 10px;
        margin-top: 70px;
      }
      .card-section {
        padding: 15px;
        border-radius: 12px;
      }
      .card-section h1 {
        font-size: 1.5rem !important;
      }
      table {
        font-size: 12px;
      }
      table th, table td {
        padding: 8px 6px !important;
      }
    }

  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header">
    <div class="flex items-center gap-3">
      <i class="fas fa-bars menu-toggle text-xl cursor-pointer" id="menu-btn"></i>
      <img src="/KIPWEB/assets/logo-polinela.png">
      <h1>Sistem Informasi KIP-KULIAH POLINELA</h1>
    </div>
  </div>

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content" id="main-content">
    <div class="w-full max-w-6xl mx-auto">

      <!-- Title Card -->
      <div class="card-section animate-zoom text-center bg-purple-700 text-white shadow-xl">
        <h1 class="text-4xl font-extrabold mb-2">Pedoman KIP-Kuliah 2025</h1>
        <p class="text-lg opacity-90">Pahami syarat, tahapan, dan dokumen resmi program KIP-K.</p>
      </div>

      <!-- Informasi -->
      <div class="grid md:grid-cols-2 gap-8">

        <div class="card-section animate-fade-up">
          <h3 class="text-2xl font-bold text-purple-700 mb-3">
            <i class="fas fa-bullseye text-purple-700"></i> Tujuan Program
          </h3>
          <p class="text-gray-700">
            Memberikan akses pendidikan tinggi bagi siswa kurang mampu dengan dukungan biaya pendidikan & biaya hidup.
          </p>
        </div>

        <div class="card-section animate-fade-up" style="animation-delay: 0.1s;">
  <h3 class="text-2xl font-bold text-purple-700 mb-3">
    <i class="fas fa-check-circle text-purple-700"></i> Persyaratan
  </h3>
  <ul class="list-disc pl-6 text-gray-700 space-y-2">
    <li>Lulusan SMA/SMK/MA 2 tahun terakhir</li>
    <li>Lulus seleksi SNBP, SNBT, atau Mandiri</li>
    <li>Masuk DTKS / pemegang KIP / PKH / KKS</li>
  </ul>
</div>


      </div>

      <!-- Persyaratan Ekonomi -->
      <div class="card-section animate-fade-up" style="animation-delay: 0.2s;">
        <h3 class="text-2xl font-bold text-purple-700 mb-4">
          <i class="fas fa-users"></i> Persyaratan Ekonomi Penerima
        </h3>

        <p class="text-gray-700 mb-4">
          Penerima KIP Kuliah diprioritaskan untuk mahasiswa dari keluarga miskin atau rentan miskin berdasarkan verifikasi perguruan tinggi. Urutan prioritas adalah:
        </p>

        <ul class="space-y-3 text-gray-700">
          <li><i class="fas fa-check text-purple-700"></i> Pemegang KIP SMA/SMK yang lulus SNBP, SNBT, atau Mandiri.</li>
          <li><i class="fas fa-check text-purple-700"></i> Keluarga masuk DTKS atau penerima bansos (PKH/KKS) yang lulus seleksi PTN/PTS.</li>
          <li><i class="fas fa-check text-purple-700"></i> Pemegang KIP SMA/SMK yang lulus seleksi mandiri PTS.</li>
          <li><i class="fas fa-check text-purple-700"></i> Keluarga DTKS penerima bansos yang lulus seleksi mandiri PTS.</li>
          <li><i class="fas fa-check text-purple-700"></i> Mahasiswa dengan status miskin/rentan miskin maksimal desil 3 PPKE (SNBP, SNBT, Mandiri PTN).</li>
          <li><i class="fas fa-check text-purple-700"></i> Mahasiswa miskin/rentan miskin desil 3 PPKE yang lulus Mandiri PTS.</li>
          <li><i class="fas fa-check text-purple-700"></i> Mahasiswa dari panti sosial atau panti asuhan yang lulus seleksi PTN/PTS.</li>
        </ul>
      </div>

      <!-- Keunggulan Penerima KIP Kuliah -->
<div class="card-section animate-fade-up" style="animation-delay: 0.3s;">

  <div class="text-center mb-8">
  <h3 class="text-3xl font-extrabold text-purple-700">
    <i class="fas fa-award text-purple-600"></i> Keunggulan Penerima KIP Kuliah
  </h3>
  <p class="text-gray-600 mt-2 text-lg">
    Benefit utama yang diterima mahasiswa penerima KIP Kuliah untuk mendukung proses studi.
  </p>
</div>


  <!-- GRID UTAMA -->
  <div class="grid md:grid-cols-2 gap-8">

    <!-- Pembebasan Biaya Pendaftaran -->
    <div class="p-6 rounded-2xl shadow-lg bg-gradient-to-br from-purple-50 to-white border border-purple-200 benefit-card">
      <h4 class="text-xl font-bold text-purple-700 mb-3 flex items-center gap-2">
        <i class="fas fa-ticket-alt text-purple-600 text-2xl"></i>
        Pembebasan Biaya UTBK–SNBT
      </h4>

      <p class="text-gray-700 mb-3">
        Pelamar KIP Kuliah berhak mendapatkan pembebasan biaya pendaftaran UTBK–SNBT jika termasuk dalam kategori:
      </p>

      <ul class="space-y-2 text-gray-700">
        <li><i class="fas fa-check text-green-600"></i> Pemegang KIP Pendidikan Menengah</li>
        <li><i class="fas fa-check text-green-600"></i> Keluarga DTKS / PKH / KKS</li>
        <li><i class="fas fa-check text-green-600"></i> Keluarga miskin/rentan miskin (desil 3 PPKE)</li>
      </ul>
    </div>

    <!-- Pembebasan Biaya Kuliah -->
    <div class="p-6 rounded-2xl shadow-lg bg-gradient-to-br from-blue-50 to-white border border-blue-200 benefit-card">
      <h4 class="text-xl font-bold text-blue-700 mb-3 flex items-center gap-2">
        <i class="fas fa-university text-blue-700 text-2xl"></i>
        Bebas Biaya Kuliah (UKT/SPP)
      </h4>

      <p class="text-gray-700 leading-relaxed">
        Semua penerima KIP Kuliah dibebaskan dari pembayaran UKT/SPP. Biaya kuliah akan dibayarkan langsung oleh pemerintah ke perguruan tinggi.
      </p>
    </div>

    <!-- Bantuan Biaya Hidup -->
    <div class="p-6 rounded-2xl shadow-lg bg-gradient-to-br from-green-50 to-white border border-green-200 md:col-span-2 benefit-card">
      <h4 class="text-xl font-bold text-green-700 mb-3 flex items-center gap-2">
        <i class="fas fa-hand-holding-usd text-green-700 text-2xl"></i>
        Bantuan Biaya Hidup Mahasiswa
      </h4>

      <p class="text-gray-700 mb-4">
        Bantuan biaya hidup ditetapkan berdasarkan indeks harga wilayah dan dibagi menjadi 5 klaster:
      </p>

      <div class="grid md:grid-cols-5 grid-cols-2 gap-3 text-gray-700 mb-4">
        <?php
        $q_biaya = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan WHERE kategori='biaya_hidup' AND status='approved' ORDER BY urutan ASC");
        while($b = mysqli_fetch_assoc($q_biaya)) {
            echo '
            <div class="p-3 bg-white border rounded-xl shadow text-center transform hover:scale-105 transition duration-300">
              <i class="fas fa-wallet text-purple-700 text-xl mb-1"></i>
              <p class="font-semibold text-purple-800">'.htmlspecialchars($b['judul']).'</p>
              <span class="text-xs text-gray-500 block mt-1">'.htmlspecialchars($b['deskripsi']).'</span>
            </div>';
        }
        ?>
      </div>

      <p class="text-gray-700">
        Bantuan cair <strong>setiap semester (per 6 bulan)</strong> langsung ke rekening mahasiswa.  
        Detail biaya hidup tiap kota dapat dilihat di:  
        <a href="https://kip-kuliah.kemdiktisaintek.go.id/" 
           class="text-purple-700 font-semibold underline" target="_blank">
          kip-kuliah.kemdiktisaintek.go.id
        </a> 
        dan validasi di kabag_akademik
      </p>
    </div>

  </div>
</div>


      <!-- ===================== JADWAL & TAHAPAN ===================== -->
<div class="w-full flex justify-center mt-10 mb-10">
  <div class="bg-white shadow-xl rounded-2xl px-8 py-5 border-l-8 border-purple-600 flex items-center gap-4">
    
    <div class="bg-purple-100 text-purple-700 p-4 rounded-full shadow-md">
      <i class="fas fa-calendar-alt text-3xl"></i>
    </div>

    <h3 class="text-3xl font-bold text-purple-700">
      Jadwal & Tahapan KIP Kuliah 2026
    </h3>

  </div>
</div>



<!-- ===================== CARD 1 — TAHAPAN UMUM ===================== -->
<div class="card-section mb-10 animate-fade-up">
  <h4 class="text-2xl font-bold text-purple-700 flex items-center gap-2 mb-5">
    <i class="fas fa-stream text-purple-600"></i> Tahapan Umum 2026
  </h4>

    <?php
    $q_umum = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan WHERE kategori='tahapan_umum' AND status='approved' ORDER BY urutan ASC");
    $no = 1;
    if (mysqli_num_rows($q_umum) > 0) {
      while ($s = mysqli_fetch_assoc($q_umum)) {
        echo "
        <div class='group flex gap-4 p-6 bg-white rounded-xl border border-purple-200 shadow hover:shadow-lg transition step-card'>
          <div class=\"bg-purple-600 text-white w-12 h-12 flex items-center justify-center rounded-full font-bold\">
            {$no}
          </div>
          <div>
            <h4 class=\"font-bold text-purple-700 text-lg flex items-center gap-2\">
              <i class='fas fa-arrow-circle-right text-purple-600'></i> ".htmlspecialchars($s['judul'])."
            </h4>
            <p class=\"text-gray-600 text-sm flex items-center gap-2\">
              <i class='fas fa-clock text-purple-500'></i> ".htmlspecialchars($s['deskripsi'])."
            </p>
          </div>
        </div>
        ";
        $no++;
      }
    } else {
        echo "<p class='text-center text-gray-500'>Belum ada data tahapan umum.</p>";
    }
    ?>
</div>



<!-- ===================== CARD 2 — SNBP ===================== -->
<div class="card-section mb-10 animate-fade-up">
  <h4 class="text-2xl font-bold text-purple-700 flex items-center gap-2 mb-5">
    <i class="fas fa-graduation-cap text-purple-600"></i> Proses Seleksi Masuk SNBP
  </h4>

    <?php
    $q_snbp = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan WHERE kategori='snbp' AND status='approved' ORDER BY urutan ASC");
    if (mysqli_num_rows($q_snbp) > 0) {
      while ($step = mysqli_fetch_assoc($q_snbp)) {
        echo "
        <div class='group flex gap-4 p-6 bg-white rounded-xl border border-purple-200 shadow hover:shadow-lg transition step-card'>
          <div class='w-12 h-12 bg-purple-600 text-white flex items-center justify-center rounded-full'>
            <i class=\"fas fa-check\"></i>
          </div>
          <div>
            <h4 class='font-bold text-purple-700 text-lg flex items-center gap-2'>
              <i class=\"fas fa-arrow-right text-purple-600\"></i> ".htmlspecialchars($step['judul'])."
            </h4>
            <p class='text-gray-600 text-sm flex items-center gap-2'>
              <i class='fas fa-clock text-purple-500'></i> ".htmlspecialchars($step['deskripsi'])."
            </p>
          </div>
        </div>
        ";
      }
    }
    ?>
</div>



<!-- ===================== CARD 3 — UTBK SNBT ===================== -->
<div class="card-section mb-10 animate-fade-up">
  <h4 class="text-2xl font-bold text-purple-700 flex items-center gap-2 mb-5">
    <i class="fas fa-file-signature text-purple-600"></i> Proses Seleksi Masuk UTBK–SNBT
  </h4>

    <?php
    $q_utbk = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan WHERE kategori='utbk' AND status='approved' ORDER BY urutan ASC");
    if (mysqli_num_rows($q_utbk) > 0) {
      while ($step = mysqli_fetch_assoc($q_utbk)) {
        echo "
        <div class='group flex gap-4 p-6 bg-white rounded-xl border border-purple-200 shadow hover:shadow-lg transition step-card'>
          <div class='w-12 h-12 bg-purple-600 text-white flex items-center justify-center rounded-full'>
            <i class=\"fas fa-check\"></i>
          </div>
          <div>
            <h4 class='font-bold text-purple-700 text-lg flex items-center gap-2'>
              <i class=\"fas fa-arrow-right text-purple-600\"></i> ".htmlspecialchars($step['judul'])."
            </h4>
            <p class='text-gray-600 text-sm flex items-center gap-2'>
              <i class='fas fa-clock text-purple-500'></i> ".htmlspecialchars($step['deskripsi'])."
            </p>
          </div>
        </div>
        ";
      }
    }
    ?>
</div>



<!-- ===================== CARD 4 — KIP-KULIAH ===================== -->
<div class="card-section mb-10 animate-fade-up">
  <h4 class="text-2xl font-bold text-purple-700 flex items-center gap-2 mb-5">
    <i class="fas fa-id-card text-purple-600"></i> Proses KIP Kuliah
  </h4>

    <?php
    $q_kip = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan WHERE kategori='kip' AND status='approved' ORDER BY urutan ASC");
    if (mysqli_num_rows($q_kip) > 0) {
      while ($step = mysqli_fetch_assoc($q_kip)) {
        echo "
        <div class='group flex gap-4 p-6 bg-white rounded-xl border border-purple-200 shadow hover:shadow-lg transition'>
          <div class='w-12 h-12 bg-purple-600 text-white flex items-center justify-center rounded-full'>
            <i class=\"fas fa-check\"></i>
          </div>
          <div>
            <h4 class='font-bold text-purple-700 text-lg flex items-center gap-2'>
              <i class=\"fas fa-arrow-right text-purple-600\"></i> ".htmlspecialchars($step['judul'])."
            </h4>
            <p class='text-gray-600 text-sm flex items-center gap-2'>
              <i class='fas fa-clock text-purple-500'></i> ".htmlspecialchars($step['deskripsi'])."
            </p>
          </div>
        </div>
        ";
      }
    }
    ?>
</div>


      <!-- Tabel -->
      <div class="card-section mt-10 animate-fade-up">
        <h3 class="text-2xl font-bold text-purple-700 mb-6">
          <i class="fas fa-file-alt"></i> Daftar Pedoman Resmi
        </h3>

        <div class="flex justify-between mb-4 flex-wrap gap-2">
          <div>
            <label>Tampilkan</label>
            <select class="border border-gray-300 rounded-lg px-2 py-1 ml-2">
              <option>10</option><option>25</option><option>50</option>
            </select>
          </div>

          <div>
            <input type="text" id="search"
              placeholder="Cari pedoman..."
              class="border border-gray-300 px-3 py-1 rounded-lg">
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full border rounded-lg overflow-hidden">
            <thead class="bg-purple-700 text-white">
              <tr>
                <th class="py-3 px-4 w-10">#</th>
                <th class="py-3 px-4">Nama File</th>
                <th class="py-3 px-4 w-48 text-center">Aksi</th>
              </tr>
            </thead>

            <tbody id="pedomanTable">
              <?php
              $result = mysqli_query($koneksi, "SELECT * FROM pedoman WHERE status='approved' ORDER BY id_pedoman DESC");
              $no = 1;

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                  $file_path = $row['file_path'];
                  $server_path = __DIR__ . '/' . $file_path;
                  $file_exist = file_exists($server_path);

                  if ($file_exist) {
                    $btn_class = "bg-purple-600 hover:bg-purple-700";
                    $btn_text = '<i class="fas fa-download"></i> Unduh';
                    $href = $row['file_path'];
                    $download = "download";
                  } else {
                    $btn_class = "bg-gray-400 cursor-not-allowed";
                    $btn_text = '<i class="fas fa-times-circle"></i> File Hilang';
                    $href = "#";
                    $download = "";
                  }

                  // Cleaning Filename for display
                  $rawName = $row['nama_file'];
                  // Remove extension
                  $cleanName = pathinfo($rawName, PATHINFO_FILENAME);
                  // Remove date prefix if matches YYYYMMDD-
                  $cleanName = preg_replace('/^\d{8}-/', '', $cleanName);
                  // Remove potential hash suffix like _abc123
                  $cleanName = preg_replace('/_[a-f0-9]{6,}$/i', '', $cleanName);
                  // Replace dashes/underscores with spaces
                  $cleanName = str_replace(['-', '_'], ' ', $cleanName);
                  // Capitalize first letters
                  $displayName = ucwords($cleanName);

                  echo "
                    <tr class='border-b hover:bg-purple-50'>
                      <td class='py-3 px-4 text-center font-semibold'>{$no}</td>
                      <td class='py-3 px-4 font-medium text-gray-700'>{$displayName}</td>
                      <td class='py-3 px-4 text-center'>
                        <a href='{$href}' {$download}
                           class='text-white font-medium px-4 py-2 rounded-lg shadow {$btn_class} transition duration-300'>
                          {$btn_text}
                        </a>
                      </td>
                    </tr>
                  ";
                  $no++;
                }
              } else {
                echo "<tr><td colspan='3' class='text-center py-6 text-gray-500 italic'>Belum ada pedoman.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- SCRIPT -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      mainContent.classList.toggle('shifted');
    });

    document.getElementById('search').addEventListener('input', function() {
      const filter = this.value.toLowerCase();
      document.querySelectorAll('#pedomanTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
      });
    });
  </script>

  <?php include 'footer.php'; ?>


  <?php include 'chatbot_widget.php'; ?>
</body>
</html>
