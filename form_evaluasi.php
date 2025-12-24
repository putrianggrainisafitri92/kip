<?php
include 'koneksi.php';
session_start();


$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_mhs'])) {
    $npm  = trim($_POST['npm'] ?? '');
    $nama = trim($_POST['nama'] ?? '');

    if (!$npm || !$nama) {
        $error = "Silakan lengkapi Nama dan NPM terlebih dahulu.";
    } else {
        $q = "SELECT id_mahasiswa_kip, nama_mahasiswa 
              FROM mahasiswa_kip 
              WHERE npm=? AND nama_mahasiswa=?";
        $stmt = $koneksi->prepare($q);
        $stmt->bind_param('ss', $npm, $nama);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            $_SESSION['id_mahasiswa_kip'] = $row['id_mahasiswa_kip'];
            $_SESSION['nama_mahasiswa']  = $row['nama_mahasiswa'];
            $_SESSION['npm']             = $npm;

            header("Location: form_evaluasi.php");
            exit;
        } else {
            $error = "Data mahasiswa tidak ditemukan. Pastikan Nama dan NPM sesuai.";
        }
    }
}


$nama = $_SESSION['nama_mahasiswa'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Evaluasi KIP Kuliah & BBP Polinela</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('assets/bg-pelaporan.jpg') no-repeat center center fixed;
      background-size: cover;
      overflow-x: hidden;
    }

    /* Header */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 65px;
      background: linear-gradient(90deg, #4a148c, #6a1b9a);
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
      padding: 0 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.25);
      z-index: 1001;
    }

    .header .logo {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .header img {
      width: 38px;
      height: 38px;
      border-radius: 50%;
    }

    .header h1 {
      font-size: 18px;
      margin: 0;
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
    }

    .sidebar.active {
      left: 0;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar ul li {
      padding: 15px 25px;
      transition: background 0.3s;
    }

    .sidebar ul li a {
      color: white;
      text-decoration: none;
      display: block;
    }

    .sidebar ul li:hover {
      background: rgba(255,255,255,0.2);
    }

    /* Main content */
    .main-content {
      margin-top: 90px;
      padding: 20px;
      display: flex;
      justify-content: center;
      transition: all 0.3s ease;
      min-height: calc(100vh - 90px);
    }

    /* Saat sidebar muncul, konten tetap di tengah */
    .main-content.shifted {
      margin-left: 125px;
    }

    /* Container putih */
    .content-box {
      background: white;
      color: #111;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      max-width: 1000px;
      padding: 40px 50px;
      line-height: 1.7;
    }

    .content-box h1 {
      color: #4a148c;
      text-align: center;
      font-weight: 800;
      margin-bottom: 30px;
    }

    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 1024px) {
      .header h1 {
        font-size: 16px;
      }
      .content-box {
        padding: 30px 35px;
        max-width: 90%;
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
        width: 32px;
        height: 32px;
      }
      .main-content {
        margin-top: 75px;
        padding: 15px;
      }
      .main-content.shifted {
        margin-left: 0;
      }
      .content-box {
        padding: 25px 20px;
        border-radius: 15px;
        max-width: 95%;
      }
      .content-box h1 {
        font-size: 1.5rem !important;
      }
      /* Step indicator */
      .flex.flex-wrap.justify-center.gap-6 {
        gap: 1rem !important;
      }
      .w-14 {
        width: 3rem !important;
        height: 3rem !important;
      }
      .w-10 {
        width: 1.5rem !important;
      }
    }

    @media (max-width: 480px) {
      .header h1 {
        font-size: 11px;
      }
      .header .flex.items-center.gap-4 {
        display: none; /* Hide logout on very small screens */
      }
      .main-content {
        padding: 10px;
        margin-top: 70px;
      }
      .content-box {
        padding: 15px;
        border-radius: 12px;
      }
      .content-box h1 {
        font-size: 1.25rem !important;
      }
      .content-box p, .content-box li {
        font-size: 14px;
      }
      /* Step indicator mobile */
      .flex.flex-wrap.justify-center.gap-6 {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem !important;
      }
      .w-10.h-1 {
        width: 2px !important;
        height: 1.5rem !important;
      }
      .w-14 {
        width: 2.5rem !important;
        height: 2.5rem !important;
        font-size: 1rem !important;
      }
      .text-sm {
        font-size: 12px !important;
      }
      /* Buttons */
      .px-8 {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
      }
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <div class="header">
    <div class="logo">
      <i class="fas fa-bars menu-toggle" id="menu-btn" style="cursor:pointer;"></i>
      <img src="uploads/logo.png" alt="Logo">
      <h1>Sistem Informasi KIP-KULIAH POLINELA</h1>
    </div>
    <div class="flex items-center gap-4">
      <span class="text-sm">Hai, <?= htmlspecialchars($nama) ?></span>
      <a href="logout.php" class="text-sm underline">Logout</a>
    </div>
  </div>

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content" id="main-content">
    <div class="content-box">

      <h1 class="text-3xl md:text-4xl font-extrabold mb-6 text-white"> Monitoring dan Evaluasi Penerima KIP Kuliah Merdeka dan Bantuan Biaya Pendidikan (BBP) Polinela </h1>
      <p class="mb-4"> Berdasarkan Peraturan Sekretaris Jenderal (Persesjen) Kemendikbudristek Nomor 13 Tahun 2023 tentang Petunjuk Pelaksanaan Program Indonesia Pintar Pendidikan Tinggi yang merupakan revisi atas Persesjen Nomor 10 Tahun 2022, mahasiswa penerima KIP Kuliah Merdeka dan BBP dapat dibatalkan bantuannya bila kondisi ekonomi keluarganya meningkat serta tidak memenuhi standar minimum IP/IPK yang ditetapkan perguruan tinggi masing-masing. </p> 
      <p class="mb-4"> Sehubungan dengan peraturan tersebut, Polinela akan mengevaluasi secara berkala kondisi ekonomi dan prestasi akademik mahasiswa agar penyaluran KIP Kuliah Merdeka dan BBP tepat sasaran. </p> 
      <p class="mb-4"> Mohon kerja sama mahasiswa/mahasiswi penerima KIP Kuliah Merdeka dan BBP Polinela untuk melengkapi data evaluasi dan melampirkan dokumen yang dibutuhkan dengan ketentuan sebagai berikut: </p> 
      <p class="mb-2 font-semibold">A. Dokumen yang disiapkan:</p> 
      <ul class="list-decimal list-inside mb-4 text-sm md:text-base"> 
        <li>Slip gaji orang tua 1 bulan terakhir (terbaru). Jika tidak ada slip gaji buat surat pernyataan penghasilan ditandatangani RT/RW/Pejabat Desa.</li> 
        <li>Scan Kartu Keluarga (KK).</li> 
        <li>Scan Kartu penerima KKS, PKH, DTKS, Bantuan Sembako (Jika ada), jika tidak ada diganti SKTM terbaru.</li> 
        <li>Scan Sertifikat lomba dan dokumentasi kegiatan juara 1–3 Tingkat Nasional atau Internasional (jika ada).</li> 
        <li>Scan Surat Keterangan Aktif Organisasi Kemahasiswaan UKM, Ormawa, HIMA (jika ada).</li> 
        <li>Foto rumah terbaru (tampak depan, kamar tidur, dapur, kamar mandi).</li> 
        <li>Surat nikah, surat cerai, atau surat kematian (jika ada perubahan kondisi keluarga).</li> 
        <li>Surat pernyataan Tanggung Jawab Evaluasi KIP sesuai format bermeterai dan ditandatangani mahasiswa dan ortu/wali (<a href="https://bit.ly/4hgzQnx" target="_blank" class="text-purple-700 underline hover:text-purple-900">unduh di sini</a>).
        </li> 
      </ul> 
      <p class="mb-2 font-semibold">B. Dokumen nomor 1 s.d. 8 dibuat dalam satu file PDF (maksimal 10 MB).</p> 
      <p class="mb-2 font-semibold">C. Isi dokumen harus berurutan sesuai format yang ditentukan.</p> 
      <p class="mb-4 font-semibold">D. Mahasiswa yang tidak mengisi evaluasi sampai batas waktu yang ditentukan dianggap mengundurkan diri sebagai penerima KIP Kuliah dan BBP.</p> 
      <p class="italic mb-2 text-sm text-gray-700"> Data terjamin kerahasiaannya dan akan digunakan untuk pengajuan KIP Kuliah Merdeka dan BBP Semester Genap TA 2024/2025. </p> 
      <p class="font-bold text-purple-800">Periode pengisian data dibuka: 16 Januari – 6 Februari 2025.</p> 
     

<!-- ================= VERIFIKASI ================= -->
<?php if (!isset($_SESSION['id_mahasiswa_kip'])): ?>

<div class="mt-10 bg-purple-50 border border-purple-200 rounded-xl p-6 shadow">

<h2 class="text-xl font-bold text-purple-800 mb-3 text-center">
Akses Tahap Evaluasi
</h2>

<p class="text-gray-700 text-sm mb-4 text-center leading-relaxed">
Untuk melanjutkan ke tahap <strong>monitoring dan evaluasi</strong>,
mahasiswa penerima <strong>KIP Kuliah Merdeka dan BBP</strong>
wajib melakukan verifikasi data terlebih dahulu
dengan memasukkan <strong>Nama Lengkap</strong> dan <strong>NPM</strong>.
</p>

<?php if ($error): ?>
<p class="text-red-600 text-sm mb-3 text-center"><?= $error ?></p>
<?php endif; ?>

<form method="POST" class="max-w-md mx-auto space-y-4">
<input type="text" name="nama" placeholder="Nama Lengkap"
       class="w-full border p-3 rounded-lg" required>

<input type="text" name="npm" placeholder="NPM"
       class="w-full border p-3 rounded-lg" required>

<button type="submit" name="login_mhs"
class="w-full bg-purple-700 text-white py-3 rounded-lg
       hover:bg-purple-800 transition font-semibold">
Verifikasi & Lanjutkan Evaluasi
</button>
</form>

</div>
<?php endif; ?>
      <!-- Step Indicator -->
      <div class="mt-10 flex flex-wrap justify-center gap-6">
        <div class="flex flex-col items-center">
          <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white text-xl font-bold shadow-lg ring-4 ring-purple-400/50">1</div>
          <span class="mt-2 text-sm font-semibold text-purple-800">Persetujuan<br>Pengisian</span>
        </div>
        <div class="w-10 h-1 bg-purple-400 rounded-full mt-7"></div>
        <div class="flex flex-col items-center">
          <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white text-xl font-bold shadow-lg ring-4 ring-purple-400/50">2</div>
          <span class="mt-2 text-sm font-semibold text-purple-800">Data<br>Mahasiswa</span>
        </div>
        <div class="w-10 h-1 bg-purple-400 rounded-full mt-7"></div>
        <div class="flex flex-col items-center">
          <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white text-xl font-bold shadow-lg ring-4 ring-purple-400/50">3</div>
          <span class="mt-2 text-sm font-semibold text-purple-800">Kondisi<br>Ekonomi</span>
        </div>
        <div class="w-10 h-1 bg-purple-400 rounded-full mt-7"></div>
        <div class="flex flex-col items-center">
          <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white text-xl font-bold shadow-lg ring-4 ring-purple-400/50">4</div>
          <span class="mt-2 text-sm font-semibold text-purple-800">Unggah<br>Dokumen</span>
        </div>
      </div>

      <!-- Tombol Mulai -->
      <div class="text-center mt-12">

<?php if (!isset($_SESSION['id_mahasiswa_kip'])): ?>

    <!-- TOMBOL NONAKTIF -->
    <div class="inline-block">
        <div
            class="px-8 py-3 bg-gray-400 text-white text-lg font-semibold
                   rounded-full shadow cursor-not-allowed opacity-70">
            <i class="fa fa-lock mr-2"></i> Mulai Isi Evaluasi
        </div>
        <p class="text-sm text-gray-600 mt-3 italic">
            Silakan lakukan verifikasi Nama dan NPM terlebih dahulu
            untuk membuka tahap evaluasi.
        </p>
    </div>
    

<?php else: ?>

    <!-- TOMBOL AKTIF -->
    <a href="form_evaluasi_tahap1.php"
       class="inline-block px-8 py-3
              bg-gradient-to-r from-purple-700 to-purple-900
              text-white text-lg font-semibold rounded-full shadow-lg
              hover:shadow-purple-600/50 hover:scale-105
              transition-transform duration-300">
        <i class="fa fa-pen-to-square mr-2"></i> Mulai Isi Evaluasi
    </a>

<?php endif; ?>

<?php if (isset($_SESSION['id_mahasiswa_kip'])): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const target = document.querySelector('.text-center.mt-12');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
});
</script>
<?php endif; ?>

</div>


    </div>
  </div>

  <!-- SCRIPT -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    if (menuBtn) menuBtn.addEventListener('click', () => {
      if (sidebar) sidebar.classList.toggle('active');
      if (mainContent) mainContent.classList.toggle('shifted');
    });
  </script>

<?php include 'footer.php'; ?>
</body>
</html>
