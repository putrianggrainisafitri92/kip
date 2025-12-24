<?php
include 'koneksi.php';

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
.news-card::after {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(
    to right,
    transparent 0%,
    rgba(255,255,255,0.15) 50%,
    transparent 100%
  );
  transform: rotate(30deg);
  opacity: 0;
  transition: opacity 0.3s;
}

.news-card:hover::after {
  opacity: 1;
  animation: shimmer 2s infinite;
}

@keyframes shimmer {
  0% { transform: translateX(-100%) rotate(30deg); }
  100% { transform: translateX(100%) rotate(30deg); }
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
  padding: 2.5rem;
  position: relative;
  z-index: 1;
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
  .main-content {
    padding: 1rem;
  }
  /* Hero section */
  .h-\[60vh\] {
    height: 50vh !important;
  }
  .text-4xl {
    font-size: 1.75rem !important;
  }
  .text-6xl {
    font-size: 2rem !important;
  }
  /* Chart section */
  .h-80 {
    height: 250px !important;
  }
  .p-10 {
    padding: 1.5rem !important;
  }
  .px-8 {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
  }
  .text-3xl {
    font-size: 1.5rem !important;
  }
  /* News cards: 2 Kolom di Tablet */
  .grid.md\:grid-cols-3 {
    grid-template-columns: repeat(2, 1fr) !important;
  }
  .gap-8 {
    gap: 1rem !important;
  }
}

@media (max-width: 480px) {
  .main-content {
    padding: 0.75rem;
  }
  /* Hero */
  .h-\[60vh\] {
    height: 45vh !important;
  }
  .pt-20 {
    padding-top: 4rem !important;
  }
  .text-4xl {
    font-size: 1.5rem !important;
  }
  .text-6xl {
    font-size: 1.75rem !important;
  }
  .text-lg {
    font-size: 0.95rem !important;
  }
  .py-3 {
    padding-top: 0.625rem !important;
    padding-bottom: 0.625rem !important;
  }
  .px-8 {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
  }
  /* Chart */
  .h-80 {
    height: 280px !important;
  }
  .p-10 {
    padding: 1rem !important;
  }
  .text-3xl {
    font-size: 1.25rem !important;
  }
  
  /* News cards: 1 Kolom di HP (permintaan user) */
  .grid.md\:grid-cols-3 {
    grid-template-columns: 1fr !important;
    gap: 1rem !important;
  }
  .news-card {
    padding: 1rem !important;
  }
  .news-card img {
    height: 150px !important; /* Tinggi sedang agar proporsional di 1 kolom */
    width: 100% !important;
    object-fit: cover !important;
    margin-bottom: 0.75rem !important;
  }
  .news-card h4 {
    font-size: 0.9rem !important;
    line-height: 1.2 !important;
    margin-bottom: 0.5rem !important;
  }
  .btn-read-more {
    font-size: 0.75rem !important;
    padding: 0.25rem 0.5rem !important;
  }

  /* Tentang KIP: Kurangi padding agar tidak 1 layar 1 kartu */
  .grid-cols-1.md\:grid-cols-2 > div {
    padding: 1.25rem !important;
  }
  #tentang p {
    font-size: 0.9rem !important;
    text-align: left !important; /* Justify kadang bolong di HP */
  }

  .mb-8 {
    margin-bottom: 1rem !important;
  }
  /* Slider buttons */
  .w-12 {
    width: 2.5rem !important;
    height: 2.5rem !important;
  }
  .left-6 {
    left: 0.5rem !important;
  }
  .right-6 {
    right: 0.5rem !important;
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

  <!-- Background SLIDESHOW -->
  <div id="heroBackground"
       class="absolute inset-0 px-4 hero-bg transition-opacity duration-700">
    <div class="relative w-full h-full rounded-2xl overflow-hidden">
      <div id="heroImage"
           class="absolute inset-0 bg-cover bg-center transition-opacity duration-700"
           style="background-image: url('assets/bg-polinela.jpeg'); opacity: 1;">
      </div>

      <div class="absolute inset-0 bg-gradient-to-b
           from-black/50 via-black/40 to-black/10"></div>
    </div>
  </div>

  <!-- Tombol Prev -->
<button id="prevBtn"
        class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center
               bg-white/20 hover:bg-white/40 text-white rounded-full shadow-lg backdrop-blur-md
               transition-all duration-300 group">
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="w-6 h-6 text-white group-hover:text-white" 
         fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
</button>

<!-- Tombol Next -->
<button id="nextBtn"
        class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center
               bg-white/20 hover:bg-white/40 text-white rounded-full shadow-lg backdrop-blur-md
               transition-all duration-300 group">
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="w-6 h-6 text-white group-hover:text-white" 
         fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
    </svg>
</button>

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
<section class="pt-4 pb-4 px-8 fade-in">


  <div class="max-w-5xl mx-auto bg-white/90 backdrop-blur-xl shadow-xl rounded-2xl p-10">

    <h2 class="text-3xl font-bold text-center text-primary-mid mb-8">
      Grafik Penerimaan KIP-Kuliah per Tahun
    </h2>

    <!-- Canvas Grafik -->
    <div class="w-full h-80">
      <canvas id="grafikKipTahunan"></canvas>
    </div>

    <p class="text-center text-gray-700 mt-6">
      Total Penerima: <span class="font-bold text-primary-dark"><?= $totalMahasiswa ?></span>
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
<section id="berita" class="relative pt-0 pb-6 px-6 -mt-16">




  <div class="relative w-full max-w-[95%] mx-auto rounded-t-2xl overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-br from-[#FFFFFF] to-[#FFFFFF]"></div>

    <div class="relative z-10 text-white px-6 py-10">

     <!-- JUDUL BERWARNA UNGU -->
      <h3 class="text-3xl font-bold text-center mb-12 text-purple-700">
        Berita & Kegiatan KIP-Kuliah
      </h3>


     <div class="grid md:grid-cols-3 gap-8 max-w-7xl mx-auto">

<?php while ($b = mysqli_fetch_assoc($berita)) : ?>
  <div class="news-card bg-purple-700 rounded-2xl shadow-xl p-6 text-white">
    <div class="card-content">
      <!-- Gambar pertama -->
      <?php if (!empty($b['gambar'])): ?>
        <img src="uploads/berita/<?= htmlspecialchars($b['gambar']) ?>" 
             alt="<?= htmlspecialchars($b['judul']) ?>" 
             class="rounded-xl mb-4 w-full h-48 object-cover shadow-lg transition-transform duration-300 hover:scale-105">
      <?php endif; ?>

      <!-- Judul -->
      <h4 class="font-semibold text-xl mb-2 text-white">
        <?= htmlspecialchars($b['judul']) ?>
      </h4>

      <!-- Tombol ke detail berita -->
      <a href="berita_detail.php?id=<?= $b['id_berita'] ?>" 
         class="btn-read-more inline-block bg-white text-purple-700 font-semibold px-4 py-2 rounded-lg">
         Baca Selengkapnya →
      </a>
    </div>
  </div>
<?php endwhile; ?>

</div>
    </div>
  </div>
</section>



   <!-- TENTANG KIP-KULIAH -->
   <section id="tentang" class="relative w-full pt-20 pb-20 flex items-center justify-center">

  <!-- Wrapper pembatas ukuran seperti HERO -->
  <div class="absolute inset-y-0 left-4 right-4">
    <div class="relative w-full h-full rounded-2xl overflow-hidden">

      <!-- Background Image -->
      <div class="absolute inset-0 bg-cover bg-center"
           style="background-image: url('assets/bgpolinela.jpeg');"></div>

      <!-- Overlay -->
      <div class="absolute inset-0 bg-gradient-to-b
           from-white/70 via-white/80 to-white/90"></div>

    </div>
  </div>


  
  <!-- CONTENT CARD -->
<div class="relative z-10 max-w-6xl mx-auto text-center px-6">

  <h2 class="text-4xl font-bold text-gray-900 mb-4 drop-shadow">
    Tentang KIP-Kuliah
  </h2>

  <p class="text-lg text-gray-700 mb-10 drop-shadow">
    Membuka akses pendidikan tinggi yang lebih merata bagi seluruh generasi muda Indonesia.
  </p>

  <!-- WRAPPER SEMUA CARD -->
  <div class="bg-white/90 rounded-2xl shadow-xl p-10 max-w-6xl mx-auto backdrop-blur-md space-y-10">

    <!-- ===================== 2 KOLOM ===================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- CARD KIRI: Apa Itu KIP-Kuliah -->
      <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition duration-300 border border-purple-200">
        <h3 class="text-2xl font-bold text-primary-mid mb-4 text-center">
          Apa itu KIP-Kuliah?
        </h3>

        <p class="text-gray-700 leading-relaxed text-justify mb-4">
          KIP-Kuliah adalah program bantuan pendidikan dari pemerintah berupa pembebasan biaya kuliah sepenuhnya serta dukungan biaya hidup bagi mahasiswa. Bantuan ini diberikan khusus kepada calon mahasiswa yang memiliki prestasi akademik maupun non-akademik, tetapi berasal dari keluarga dengan kondisi ekonomi yang kurang mampu
        </p>

        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-5 rounded-xl border border-purple-100">
          <h4 class="font-semibold text-primary-mid mb-3 text-lg">Manfaat KIP-Kuliah:</h4>
          <ul class="space-y-2 text-gray-700 text-left">
            <li class="flex items-center"><span class="text-green-500 mr-2">✔</span>Pembebasan biaya pendidikan</li>
            <li class="flex items-center"><span class="text-green-500 mr-2">✔</span>Bantuan biaya hidup</li>
          </ul>
        </div>
      </div>

      <!-- CARD KANAN: Sejarah KIP Nasional -->
      <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition duration-300 border border-indigo-200">
        <h3 class="text-2xl font-bold text-accent-blue mb-4 text-center">
          Sejarah KIP-Kuliah (Nasional)
        </h3>

        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-l-4 border-primary-light p-5 rounded-xl shadow-sm">
          <p class="text-gray-700 text-justify leading-relaxed">
            Program KIP pertama kali diperkenalkan pada tahun 2007.  
            Tahun 2020, pemerintah meluncurkan KIP-Kuliah sebagai pengembangan Bidikmisi,
            untuk mendukung mahasiswa prasejahtera menempuh pendidikan tinggi tanpa hambatan biaya.
          </p>
        </div>
      </div>

    </div>
    <!-- ================== END 2 KOLOM ================== -->


    <!-- ================== CARD: Sejarah Polinela ================== -->
    <div class="bg-white rounded-2xl shadow-lg p-10 hover:shadow-2xl transition duration-300 border border-purple-300 max-w-6xl mx-auto">

      <h3 class="text-3xl font-bold text-primary-mid mb-6 text-center">
       KIP-Kuliah di Politeknik Negeri Lampung
      </h3>

      <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border-l-4 border-primary-mid p-8 rounded-xl shadow-sm">

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

  document.getElementById("nextBtn").addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % heroImages.length;
    showImage(currentIndex);
  });

  document.getElementById("prevBtn").addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + heroImages.length) % heroImages.length;
    showImage(currentIndex);
  });

  // Auto Slide
  setInterval(() => {
    currentIndex = (currentIndex + 1) % heroImages.length;
    showImage(currentIndex);
  }, 5000);
</script>


</body>
</html>
