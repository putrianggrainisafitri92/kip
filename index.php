<?php
include 'koneksi.php';
include 'visitor_counter.php';

// =========================
// Ambil data Penerima KIP Pertahun (approved saja)
// =========================

// Total mahasiswa approved
$totalQuery = $koneksi->query("SELECT COUNT(*) AS total FROM mahasiswa_kip WHERE status='approved'");
$totalMahasiswa = $totalQuery->fetch_assoc()['total'] ?? 0;

// Grafik pertahun
$grafikQuery = $koneksi->query("
    SELECT tahun, COUNT(*) AS jumlah 
    FROM mahasiswa_kip 
    WHERE status='approved'
    GROUP BY tahun 
    ORDER BY tahun ASC
");

$grafik_tahun = [];
$grafik_jumlah = [];

while ($row = $grafikQuery->fetch_assoc()) {
    $grafik_tahun[] = $row['tahun'];
    $grafik_jumlah[] = $row['jumlah'];
}


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
  <title>Beranda | Sistem Informasi KIP-Kuliah POLINELA</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>


 <script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          'primary-dark': '#5B21B6',   // ungu ke biru tua elegan
          'primary-mid':  '#6D28D9',   // ungu sedang natural
          'primary-light':'#8B5CF6',   // ungu muda lembut
          'accent-blue':  '#7C3AED',   // ungu kebiruan harmonis
          'soft-white':   '#F3F0FF'    // putih dengan sedikit ungu lembut
        }
      }
    }
  }
</script>
<body class="min-h-screen overflow-x-hidden">

<!-- ========== ANIMATED BACKGROUND ========== -->
<div class="animated-bg-container">
  <!-- Animated Gradient Base -->
  <div class="gradient-animate"></div>
  
  <!-- Animated Wave Layers -->
  <div class="wave-container">
    <svg class="wave wave-1" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="rgba(139, 92, 246, 0.3)" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,138.7C672,128,768,160,864,186.7C960,213,1056,235,1152,218.7C1248,203,1344,149,1392,122.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
    <svg class="wave wave-2" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="rgba(124, 58, 237, 0.2)" d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,106.7C672,117,768,171,864,181.3C960,192,1056,160,1152,144C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
    <svg class="wave wave-3" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="rgba(168, 85, 247, 0.15)" d="M0,224L48,202.7C96,181,192,139,288,138.7C384,139,480,181,576,197.3C672,213,768,203,864,181.3C960,160,1056,128,1152,128C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
  </div>

  <!-- Floating Geometric Shapes -->
  <div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
    <div class="shape shape-5"></div>
    <div class="shape shape-6"></div>
    <div class="shape shape-7"></div>
    <div class="shape shape-8"></div>
  </div>

  <!-- Glowing Particles -->
  <div class="glow-particles">
    <div class="glow-particle"></div>
    <div class="glow-particle"></div>
    <div class="glow-particle"></div>
    <div class="glow-particle"></div>
    <div class="glow-particle"></div>
    <div class="glow-particle"></div>
    <div class="glow-particle"></div>
    <div class="glow-particle"></div>
  </div>
</div>

<style>
/* ========== ANIMATED BACKGROUND STYLES ========== */
.animated-bg-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  overflow: hidden;
}

.news-card {
  position: relative;
  overflow: hidden;
  transition: all 0.4s ease;
}

.news-card:hover {
  transform: translateY(-10px) scale(1.03);
  box-shadow:
    0 25px 50px -12px rgba(0,0,0,0.4),
    0 0 30px rgba(139,92,246,0.6);
}

/* Animated Gradient - More visible, slower */
.gradient-animate {
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(-45deg, #3B0764, #5B21B6, #7C3AED, #8B5CF6, #6D28D9, #4C1D95);
  background-size: 300% 300%;
  animation: gradientFlow 20s ease infinite;
}

@keyframes gradientFlow {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

/* Wave Container - More visible */
.wave-container {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 35%;
  overflow: hidden;
}

.wave {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 200%;
  height: 100%;
}

.wave-1 { animation: waveMove 10s linear infinite; }
.wave-2 { animation: waveMove 14s linear infinite reverse; }
.wave-3 { animation: waveMove 18s linear infinite; }

@keyframes waveMove {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* Floating Shapes - Larger, more visible, fewer elements */
.floating-shapes {
  position: absolute;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.shape {
  position: absolute;
  opacity: 0.6;
  animation: floatShape 25s ease-in-out infinite;
  backdrop-filter: blur(2px);
}

.shape-1 {
  width: 150px; height: 150px;
  background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.05));
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
  top: 8%; left: 5%;
  animation-delay: 0s;
}

.shape-2 {
  width: 200px; height: 200px;
  background: linear-gradient(135deg, rgba(192,132,252,0.3), rgba(139,92,246,0.1));
  border: 1px solid rgba(192,132,252,0.3);
  border-radius: 50%;
  top: 15%; right: 8%;
  animation-delay: -5s;
  animation-duration: 30s;
}

.shape-3 {
  width: 120px; height: 120px;
  background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
  top: 45%; left: 3%;
  animation-delay: -10s;
}

.shape-4 {
  width: 180px; height: 180px;
  background: linear-gradient(45deg, rgba(124,58,237,0.25), rgba(168,85,247,0.1));
  border: 1px solid rgba(168,85,247,0.2);
  border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
  bottom: 20%; right: 5%;
  animation-delay: -15s;
  animation-duration: 28s;
}

/* Hide some shapes on mobile */
.shape-5, .shape-6, .shape-7, .shape-8 {
  display: none;
}

@keyframes floatShape {
  0%, 100% {
    transform: translate(0, 0) rotate(0deg);
  }
  33% {
    transform: translate(40px, -30px) rotate(120deg);
  }
  66% {
    transform: translate(-30px, 40px) rotate(240deg);
  }
}

/* Glowing Particles - Larger, more visible */
.glow-particles {
  position: absolute;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.glow-particle {
  position: absolute;
  width: 12px;
  height: 12px;
  background: white;
  border-radius: 50%;
  box-shadow: 
    0 0 30px 8px rgba(255,255,255,0.6),
    0 0 60px 15px rgba(139,92,246,0.4),
    0 0 100px 25px rgba(124,58,237,0.2);
  animation: glowFloat 12s ease-in-out infinite;
}

.glow-particle:nth-child(1) { left: 8%; top: 20%; animation-delay: 0s; }
.glow-particle:nth-child(2) { left: 20%; top: 50%; animation-delay: -3s; animation-duration: 14s; }
.glow-particle:nth-child(3) { left: 35%; top: 70%; animation-delay: -6s; animation-duration: 10s; }
.glow-particle:nth-child(4) { left: 55%; top: 30%; animation-delay: -2s; animation-duration: 13s; }
.glow-particle:nth-child(5) { left: 70%; top: 60%; animation-delay: -4s; animation-duration: 11s; }
.glow-particle:nth-child(6) { left: 85%; top: 25%; animation-delay: -7s; animation-duration: 15s; }
.glow-particle:nth-child(7) { left: 45%; top: 15%; animation-delay: -5s; animation-duration: 12s; }
.glow-particle:nth-child(8) { left: 12%; top: 80%; animation-delay: -8s; animation-duration: 16s; }

@keyframes glowFloat {
  0%, 100% {
    transform: translateY(0) scale(1);
    opacity: 0.8;
  }
  50% {
    transform: translateY(-80px) scale(1.3);
    opacity: 1;
  }
}

/* ========== RESPONSIVE DESIGN ========== */
@media (max-width: 1024px) {
  .shape-1 { width: 100px; height: 100px; }
  .shape-2 { width: 140px; height: 140px; }
  .shape-3 { width: 80px; height: 80px; }
  .shape-4 { width: 120px; height: 120px; }
  .glow-particle { width: 10px; height: 10px; }
  .wave-container { height: 25%; }
}

@media (max-width: 768px) {
  .shape-1 { width: 70px; height: 70px; top: 5%; }
  .shape-2 { width: 100px; height: 100px; }
  .shape-3 { width: 50px; height: 50px; }
  .shape-4 { width: 80px; height: 80px; }
  .glow-particle { width: 8px; height: 8px; }
  .glow-particle:nth-child(5),
  .glow-particle:nth-child(6),
  .glow-particle:nth-child(7),
  .glow-particle:nth-child(8) { display: none; }
  .wave-container { height: 20%; }
  .main-content { padding: 1rem; }
}

@media (max-width: 480px) {
  .shape-3, .shape-4 { display: none; }
  .glow-particle { width: 6px; height: 6px; }
  .wave-container { height: 15%; }
  .main-content { padding: 0.75rem; }
}

/* ========== NEWS CARD ANIMATIONS ========== */

.news-card > * {
  position: relative;
  z-index: 1;
}

.news-card {
  position: relative;
  overflow: hidden;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.news-card::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255,255,255,0.25);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.5s ease, height 0.5s ease;
  z-index: 0;
}

.news-card:active::before {
  width: 500px;
  height: 500px;
}

.news-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 20px 40px -10px rgba(0,0,0,0.3), 0 0 25px rgba(139,92,246,0.25);
}

.news-card:active {
  transform: scale(0.97);
}

.news-card .card-content {
  position: relative;
  z-index: 1;
}

/* Shimmer effect */
/* Shimmer effect - Continuous subtle shine */
.news-card::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 50%;
  height: 100%;
  background: linear-gradient(
    to right,
    transparent 0%,
    rgba(255, 255, 255, 0.4) 50%,
    transparent 100%
  );
  transform: skewX(-25deg);
  z-index: 2;
  transition: none;
  pointer-events: none;
  animation: shimmerMove 3s infinite;
}

@keyframes shimmerMove {
  0% { left: -100%; }
  20% { left: 200%; } /* Fast pass */
  100% { left: 200%; } /* Wait */
}

.news-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px -10px rgba(0,0,0,0.3), 0 0 25px rgba(139,92,246,0.3);
}

/* Button animation */
.btn-read-more {
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
}

.btn-read-more:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 20px rgba(124,58,237,0.4);
}

.btn-read-more:active {
  transform: scale(0.95);
}

/* ========== CONTENT STYLES ========== */
#heroImage {
  background-size: cover;
  background-position: center 70%;
  transition: opacity 0.7s ease-in-out;
}

.hero-bg { opacity: 1; transition: opacity 0.8s ease-in-out; }

.slider-btn {
  cursor: pointer;
  user-select: none;
}

.main-content {
  transition: margin-left 0.3s ease;
  padding: 0;
  position: relative;
  z-index: 1;
  width: 100%;
}

.main-content.shifted {
  margin-left: 250px;
}

html {
  scroll-behavior: smooth;
}

.fade-in {
  animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Responsive main content */
@media (max-width: 768px) {
  .main-content.shifted {
    margin-left: 0;
  }
}
</style>
</head>


  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Konten utama -->
  <div class="main-content space-y-10">


   <!-- Hero Section -->
<section class="relative w-full h-[60vh] pt-20 flex items-center justify-center select-none">

  <!-- Background SLIDESHOW (Full Width) -->
  <div id="heroBackground"
       class="absolute inset-0 px-0 hero-bg transition-opacity duration-700">
    <div class="relative w-full h-full overflow-hidden">
      <div id="heroImage"
           class="absolute inset-0 bg-cover bg-center transition-opacity duration-700"
           style="background-image: url('assets/bg-polinela.jpeg'); opacity: 1;">
      </div>

      <div class="absolute inset-0 bg-gradient-to-b
           from-black/50 via-black/40 to-black/10"></div>
    </div>
  </div>

  <!-- Tombol Navigasi DIHAPUS agar clean -->

  <!-- HERO CONTENT -->
  <div class="relative z-10 text-center px-6 max-w-3xl mx-auto">
    
    <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg leading-tight mb-4">
      Sistem Informasi KIP-Kuliah Politeknik Negeri Lampung
    </h1>

    <p class="text-lg md:text-xl text-gray-200 mb-8 drop-shadow">
      Platform resmi untuk pendaftaran, informasi, dan pengelolaan bantuan KIP-Kuliah.
    </p>

    <a href="#tentang"
       class="inline-block bg-primary-light hover:bg-primary-mid text-white font-semibold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
      Jelajahi Lebih Lanjut
    </a>

  </div>

</section>


<!-- ================== GRAFIK PENERIMAAN KIP PER TAHUN ================== -->
<section class="pt-6 pb-8 px-2 md:px-8 fade-in"> 

  <div class="max-w-5xl mx-auto bg-white/90 backdrop-blur-xl shadow-xl rounded-2xl p-2 md:p-8 border border-white/50">

    <h2 class="text-2xl md:text-3xl font-bold text-center text-primary-mid mb-6 mt-4">
      Grafik Penerimaan KIP-Kuliah per Tahun
    </h2>

    <!-- Canvas Grafik: Full Width, Tinggi Optimal, Tanpa Scroll -->
    <div class="w-full h-[350px] md:h-[500px] relative">
      <canvas id="grafikKipTahunan"></canvas>
    </div>

    <p class="text-center text-gray-700 mt-4 mb-4 text-sm md:text-base">
      Total Penerima: <span class="font-bold text-primary-dark text-lg"><?= $totalMahasiswa ?></span> Mahasiswa
    </p>

  </div>
</section>
 
<!-- BERITA & KEGIATAN -->
<?php
include 'koneksi.php';
$berita = mysqli_query($koneksi, "
    SELECT b.id_berita, b.judul, bg.file AS gambar
    FROM berita b
    LEFT JOIN berita_gambar bg ON b.id_berita = bg.id_berita
    AND bg.sortorder = (
        SELECT MIN(sortorder) 
        FROM berita_gambar 
        WHERE id_berita = b.id_berita
    )
    WHERE b.status='approved'
    GROUP BY b.id_berita
    ORDER BY b.id_berita DESC
    LIMIT 6
");

?>
<!-- ================== BERITA & KEGIATAN ================== -->
<section id="berita" class="relative pt-4 md:pt-8 pb-20 px-4 md:px-8">


  <!-- HEADER SECTION -->
  <div class="max-w-7xl mx-auto text-center mb-10 md:mb-14">
    <h2 class="
      text-2xl sm:text-3xl md:text-4xl
      font-extrabold
      text-white
      drop-shadow
      mb-3
    ">
      Berita & Kegiatan KIP-Kuliah
    </h2>

    <p class="
      text-sm sm:text-base md:text-lg
      text-purple-100
      max-w-2xl
      mx-auto
    ">
      Informasi terbaru seputar kegiatan, pengumuman, dan agenda resmi
      KIP-Kuliah Politeknik Negeri Lampung.
    </p>
  </div>

  <!-- WRAPPER PUTIH -->
  <div class="
    max-w-7xl mx-auto
    bg-white/95
    backdrop-blur-xl
    rounded-3xl
    shadow-2xl
    px-6 sm:px-8 md:px-10
    py-10 md:py-12
  ">

    <!-- SLIDER -->
    <div class="swiper beritaSwiper">
      <div class="swiper-wrapper">

        <?php while ($b = mysqli_fetch_assoc($berita)) : ?>
          <div class="swiper-slide h-auto">

 <div class="
  group news-card
  bg-gradient-to-br from-primary-mid to-primary-dark
  rounded-2xl
  p-4 sm:p-6
  text-white
  flex flex-col
  h-full
  shadow-lg
">



              <!-- GAMBAR -->
              <?php if (!empty($b['gambar'])): ?>
                <div class="relative overflow-hidden rounded-xl mb-4">
                  <img
                    src="uploads/berita/<?= htmlspecialchars($b['gambar']) ?>"
                    class="
                      w-full h-44 sm:h-48
                      object-cover
                      transition duration-500
                      group-hover:scale-110
                    "
                  >
                  <div class="absolute inset-0 bg-black/25"></div>
                </div>
              <?php endif; ?>

              <!-- JUDUL -->
              <h4 class="
                font-semibold
                text-base sm:text-lg
                mb-4
                leading-snug
                line-clamp-3
              ">
                <?= htmlspecialchars($b['judul']) ?>
              </h4>

              <!-- BUTTON -->
              <a href="berita_detail.php?id=<?= $b['id_berita'] ?>"
                 class="
                   mt-auto
                   inline-flex items-center gap-2
                   bg-white text-purple-700
                   font-semibold
                   px-4 py-2
                   rounded-lg
                   hover:bg-purple-100
                   transition
                 ">
                Baca Selengkapnya
                <span class="transition group-hover:translate-x-1">→</span>
              </a>

            </div>
          </div>
        <?php endwhile; ?>

      </div>

      <!-- NAVIGATION -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

      <!-- PAGINATION -->
      <div class="swiper-pagination mt-6"></div>
    </div>
  </div>
</section>




   <!-- TENTANG KIP-KULIAH -->
   <!-- TENTANG KIP-KULIAH -->
   <section id="tentang" class="relative w-full py-10 md:py-16 flex items-center justify-center overflow-hidden">

  <!-- Wrapper Background -->
  <div class="absolute inset-y-0 left-0 right-0 md:left-4 md:right-4">
    <div class="relative w-full h-full md:rounded-3xl overflow-hidden shadow-none md:shadow-lg">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('assets/bgpolinela.jpeg');"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-white/85 via-white/95 to-white"></div>
    </div>
  </div>
  
  <!-- CONTENT CARD -->
<div class="relative z-10 max-w-5xl mx-auto text-center px-4 md:px-6">

  <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4 drop-shadow">
    Tentang KIP-Kuliah
  </h2>

  <p class="text-sm md:text-base text-gray-700 mb-6 md:mb-8 drop-shadow max-w-xl mx-auto">
    Membuka akses pendidikan tinggi yang lebih merata bagi seluruh generasi muda Indonesia.
  </p>

  <!-- WRAPPER SEMUA CARD -->
  <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-lg p-4 md:p-8 max-w-5xl mx-auto space-y-6 md:space-y-8 border border-white/50">

    <!-- ===================== 2 KOLOM ===================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

      <!-- CARD KIRI: Apa Itu KIP-Kuliah -->
      <div class="bg-white rounded-xl shadow p-5 md:p-6 border border-purple-100 text-left hover:shadow-md transition">
        <h3 class="text-lg md:text-xl font-bold text-primary-mid mb-3 text-center md:text-left">
          Apa itu KIP-Kuliah?
        </h3>

        <p class="text-gray-700 text-xs md:text-sm leading-relaxed text-justify mb-3">
          KIP-Kuliah adalah program bantuan pendidikan dari pemerintah berupa pembebasan biaya kuliah sepenuhnya serta dukungan biaya hidup. Khusus bagi calon mahasiswa berprestasi namun terkendala ekonomi.
        </p>

        <div class="bg-purple-50 p-3 rounded-lg border border-purple-100">
          <h4 class="font-semibold text-primary-mid mb-2 text-sm md:text-base">Manfaat Utama:</h4>
          <ul class="space-y-1 text-gray-700 text-xs md:text-sm">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i> Gratis Biaya Kuliah</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i> Bantuan Biaya Hidup</li>
          </ul>
        </div>
      </div>

      <!-- CARD KANAN: Sejarah KIP Nasional -->
      <div class="bg-white rounded-xl shadow p-5 md:p-6 border border-indigo-100 text-left hover:shadow-md transition">
        <h3 class="text-lg md:text-xl font-bold text-accent-blue mb-3 text-center md:text-left">
          Sejarah Singkat
        </h3>

        <!-- Hapus h-full agar bg biru mengikuti panjang teks (biar gak keluar kolam) -->
        <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 rounded-lg shadow-sm">
          <p class="text-gray-700 text-xs md:text-sm text-justify leading-relaxed">
            Dimulai tahun 2010 sebagai <b>Bidikmisi</b>.
            <br><br>
            Tahun 2020 bertransformasi menjadi <b>KIP-Kuliah</b> untuk akses yang lebih luas dan merata bagi anak bangsa.
          </p>
        </div>
      </div>

    </div>
    <!-- ================== END 2 KOLOM ================== -->

    <!-- ================== CARD: Sejarah Polinela ================== -->
    <div class="bg-white rounded-xl shadow p-5 md:p-8 border border-purple-200 hover:shadow-md transition">

      <h3 class="text-xl md:text-2xl font-bold text-primary-mid mb-4 text-center">
       KIP-Kuliah di Polinela
      </h3>

      <div class="bg-gradient-to-br from-purple-50 to-white p-4 md:p-6 rounded-xl border border-purple-100">

        <p class="text-gray-700 leading-relaxed text-justify mb-5">
          Politeknik Negeri Lampung secara konsisten melaksanakan program ini
          melalui jalur SNBP, SNBT, dan Seleksi Mandiri setiap tahun. Proses verifikasi dilakukan
          sesuai ketentuan pemerintah untuk memastikan tepat sasaran.
        </p>

        <p class="text-gray-700 leading-relaxed text-justify mb-5">
         Program ini memberikan kesempatan luas bagi mahasiswa dari keluarga kurang mampu
          untuk menempuh pendidikan vokasi tanpa terbebani biaya kuliah. KIP-Kuliah berperan penting
          dalam meningkatkan akses, pemerataan, dan kualitas pendidikan tinggi di Lampung.
        </p>

      

      </div>
    </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Script sidebar -->
  <script>
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.getElementById('main-content');

    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('active');
      overlay.classList.toggle('active');
      mainContent.classList.toggle('shifted');
    });

    overlay.addEventListener('click', function() {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
      mainContent.classList.remove('shifted');
    });
  </script>

  <!-- BERITA & KEGIATAN -->
<?php
include 'koneksi.php';
// Ambil 6 berita terbaru yang sudah disetujui beserta 1 gambar pertama (jika ada)
$berita = mysqli_query($koneksi, "
    SELECT b.id_berita, b.judul, bg.file AS gambar
    FROM berita b
    LEFT JOIN berita_gambar bg ON b.id_berita = bg.id_berita
    AND bg.sortorder = (
        SELECT MIN(sortorder) 
        FROM berita_gambar 
        WHERE id_berita = b.id_berita
    )
    WHERE b.status='approved'
    GROUP BY b.id_berita
    ORDER BY b.id_berita DESC
    LIMIT 6
");
?>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctxKIP = document.getElementById('grafikKipTahunan').getContext('2d');

// GRADIENT AREA (ungu → transparan)
let gradient = ctxKIP.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, "rgba(139, 92, 246, 0.35)");
gradient.addColorStop(1, "rgba(139, 92, 246, 0)");

new Chart(ctxKIP, {
    type: 'line',
    data: {
        labels: <?= json_encode($grafik_tahun) ?>,
        datasets: [{
            label: "Jumlah Penerima per Tahun",
            data: <?= json_encode($grafik_jumlah) ?>,

            // STYLE GARIS
            borderColor: "rgba(124, 58, 237, 1)", 
            borderWidth: 3,
            tension: 0.35, /* garis melengkung */

            // AREA (bendang lembut)
            backgroundColor: gradient,
            fill: true,

            // TITIK
            pointBackgroundColor: "#7C3AED",
            pointBorderColor: "#fff",
            pointRadius: 6,
            pointHoverRadius: 8,
            pointBorderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,  // AGAR MUDAH DICENTERKAN

        layout: {
            padding: {
                left: 20,
                right: 20
            }
        },

        scales: {
            y: {
                beginAtZero: true,
                ticks: { 
                    color: "#4B007D",
                    font: { weight: "600" }
                },
                grid: { color: "rgba(0,0,0,0.1)" }
            },
            x: {
                ticks: { 
                    color: "#4B007D",
                    font: { weight: "600" }
                },
                grid: { display: false }
            }
        },

        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: "#4B007D",
                titleFont: { weight: "bold" },
                bodyFont: { weight: "bold" },
                padding: 10
            }
        }
    }
});
</script>



<?php include 'footer.php'; ?>

<script>
  const heroImages = [
    "assets/polinela.jpg",
    "assets/bg-3.jpg",
    "assets/bg-polinela.jpeg"
  ];

  let currentIndex = 0;
  const heroImage = document.getElementById("heroImage");

  function showImage(index) {
    heroImage.style.opacity = 0;

    setTimeout(() => {
      heroImage.style.backgroundImage = `url('${heroImages[index]}')`;
      heroImage.style.opacity = 1;
    }, 300);
  }

  // Auto Slide
  setInterval(() => {
    currentIndex = (currentIndex + 1) % heroImages.length;
    showImage(currentIndex);
  }, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
new Swiper(".beritaSwiper", {
  slidesPerView: 1,
  spaceBetween: 24,
  loop: true,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    640: { slidesPerView: 2, spaceBetween: 20 },
    1024: { slidesPerView: 3, spaceBetween: 24 }
  }
});
</script>


</body>
</html>