<?php
include 'koneksi.php';

$id = intval($_GET['id']);

// tampilkan berita yang disetujui
$q = $koneksi->prepare("SELECT * FROM berita WHERE id_berita = ? AND status = 'approved' LIMIT 1");
$q->bind_param("i", $id);
$q->execute();
$res = $q->get_result();
$berita = $res->fetch_assoc();
$q->close();

if (!$berita) {
    die("Berita tidak ditemukan atau belum disetujui.");
}

// ambil gambar terkait (urut berdasarkan sortorder)
$gq = $koneksi->prepare("SELECT * FROM berita_gambar WHERE id_berita = ? ORDER BY sortorder ASC, id_gambar ASC");
$gq->bind_param("i", $id);
$gq->execute();
$gres = $gq->get_result();
$gambars = $gres->fetch_all(MYSQLI_ASSOC);
$gq->close();
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($berita['judul']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ========== BASE STYLES ========== */
* {
  font-family: 'Poppins', sans-serif;
}

body {
  margin: 0;
  min-height: 100vh;
  overflow-x: hidden;
}

/* ========== ANIMATED BACKGROUND ========== */
.animated-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  overflow: hidden;
}

/* Gradient Animation - Very Visible */
.gradient-bg {
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(-45deg, #1e1b4b, #4338ca, #6d28d9, #8b5cf6, #a855f7, #7c3aed);
  background-size: 400% 400%;
  animation: gradientMove 10s ease infinite;
}

@keyframes gradientMove {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

/* Floating Orbs - VERY VISIBLE with solid colors and pulsing */
.floating-circles {
  position: absolute;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.circle {
  position: absolute;
  border-radius: 50%;
  animation: floatCircle 18s ease-in-out infinite;
}

.circle-1 {
  width: 300px;
  height: 300px;
  background: rgba(139,92,246,0.4);
  border: 3px solid rgba(167,139,250,0.6);
  box-shadow: 
    0 0 60px 20px rgba(139,92,246,0.5),
    inset 0 0 60px rgba(255,255,255,0.1);
  top: -50px;
  left: -50px;
  animation-delay: 0s;
}

.circle-2 {
  width: 350px;
  height: 350px;
  background: rgba(124,58,237,0.35);
  border: 3px solid rgba(139,92,246,0.5);
  box-shadow: 
    0 0 80px 25px rgba(124,58,237,0.4),
    inset 0 0 50px rgba(255,255,255,0.08);
  top: 25%;
  right: -60px;
  animation-delay: -4s;
  animation-duration: 22s;
}

.circle-3 {
  width: 250px;
  height: 250px;
  background: rgba(167,139,250,0.4);
  border: 3px solid rgba(192,132,252,0.5);
  box-shadow: 
    0 0 50px 15px rgba(167,139,250,0.5),
    inset 0 0 40px rgba(255,255,255,0.1);
  bottom: 10%;
  left: 8%;
  animation-delay: -8s;
  animation-duration: 20s;
}

.circle-4 {
  width: 280px;
  height: 280px;
  background: rgba(192,132,252,0.35);
  border: 3px solid rgba(216,180,254,0.4);
  box-shadow: 
    0 0 70px 20px rgba(192,132,252,0.4),
    inset 0 0 50px rgba(255,255,255,0.08);
  top: 50%;
  left: 40%;
  animation-delay: -6s;
  animation-duration: 25s;
}

@keyframes floatCircle {
  0%, 100% {
    transform: translate(0, 0) scale(1);
  }
  25% {
    transform: translate(40px, -50px) scale(1.1);
  }
  50% {
    transform: translate(-30px, 30px) scale(0.95);
  }
  75% {
    transform: translate(50px, 20px) scale(1.05);
  }
}

/* Glowing Stars - VERY VISIBLE with pulsing */
.stars {
  position: absolute;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.star {
  position: absolute;
  width: 14px;
  height: 14px;
  background: white;
  border-radius: 50%;
  box-shadow: 
    0 0 20px 10px rgba(255,255,255,0.9),
    0 0 50px 20px rgba(167,139,250,0.7),
    0 0 100px 40px rgba(139,92,246,0.5);
  animation: twinkle 5s ease-in-out infinite;
}

.star:nth-child(1) { left: 10%; top: 15%; animation-delay: 0s; }
.star:nth-child(2) { left: 25%; top: 45%; animation-delay: -1s; animation-duration: 6s; }
.star:nth-child(3) { left: 50%; top: 20%; animation-delay: -2s; animation-duration: 4s; }
.star:nth-child(4) { left: 72%; top: 35%; animation-delay: -0.5s; animation-duration: 5s; }
.star:nth-child(5) { left: 85%; top: 60%; animation-delay: -1.5s; animation-duration: 7s; }
.star:nth-child(6) { left: 15%; top: 75%; animation-delay: -2.5s; animation-duration: 5.5s; }

@keyframes twinkle {
  0%, 100% {
    transform: scale(1);
    opacity: 0.7;
  }
  50% {
    transform: scale(1.8);
    opacity: 1;
  }
}

/* Wave Bottom */
.wave-bottom {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 200%;
  height: 150px;
  animation: waveSlide 12s linear infinite;
}

.wave-bottom svg {
  width: 100%;
  height: 100%;
}

@keyframes waveSlide {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* ========== CONTENT STYLES ========== */
.content-wrapper {
  position: relative;
  z-index: 1;
  padding: 2rem 1rem;
}

.article-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border-radius: 1.5rem;
  box-shadow: 
    0 25px 50px -12px rgba(0, 0, 0, 0.25),
    0 0 40px rgba(124, 58, 237, 0.15);
  overflow: hidden;
  animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.image-container {
  overflow: hidden;
  border-radius: 0.75rem;
  box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}

.image-container:hover {
  transform: scale(1.02);
}

.image-container img {
  transition: transform 0.5s ease;
}

.image-container:hover img {
  transform: scale(1.05);
}

.btn-back {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #7c3aed, #6d28d9);
  color: white;
  border-radius: 0.75rem;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
}

.btn-back:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(124, 58, 237, 0.5);
}

.btn-back:active {
  transform: scale(0.97);
}

/* ========== RESPONSIVE ========== */
@media (max-width: 1024px) {
  .circle-1 { width: 180px; height: 180px; }
  .circle-2 { width: 220px; height: 220px; }
  .circle-3 { width: 150px; height: 150px; }
  .circle-4 { width: 130px; height: 130px; }
}

@media (max-width: 768px) {
  .content-wrapper {
    padding: 1rem 0.75rem;
  }
  
  .article-card {
    border-radius: 1rem;
  }
  
  .circle-1 { width: 120px; height: 120px; }
  .circle-2 { width: 150px; height: 150px; }
  .circle-3, .circle-4 { display: none; }
  
  .star:nth-child(4),
  .star:nth-child(5),
  .star:nth-child(6) { display: none; }
  
  .wave-bottom { height: 80px; }
}

@media (max-width: 480px) {
  .content-wrapper {
    padding: 0.75rem 0.5rem;
  }
  
  .circle-1, .circle-2 { 
    width: 80px; 
    height: 80px; 
  }
  
  .star { width: 4px; height: 4px; }
  
  .wave-bottom { height: 50px; }
  
  .btn-back {
    width: 100%;
    justify-content: center;
  }
}
</style>
</head>
<body>

<!-- ANIMATED BACKGROUND -->
<div class="animated-bg">
  <div class="gradient-bg"></div>
  
  <div class="floating-circles">
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
    <div class="circle circle-3"></div>
    <div class="circle circle-4"></div>
  </div>
  
  <div class="stars">
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
  </div>
  
  <div class="wave-bottom">
    <svg viewBox="0 0 2880 150" preserveAspectRatio="none">
      <path fill="rgba(139, 92, 246, 0.2)" d="M0,75 C480,150 960,0 1440,75 C1920,150 2400,0 2880,75 L2880,150 L0,150 Z"></path>
      <path fill="rgba(124, 58, 237, 0.15)" d="M0,100 C480,50 960,150 1440,100 C1920,50 2400,150 2880,100 L2880,150 L0,150 Z"></path>
    </svg>
  </div>
</div>

<!-- CONTENT -->
<div class="content-wrapper">
  <div class="max-w-4xl mx-auto">
    <div class="article-card p-6 sm:p-8 md:p-10">

      <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-purple-700 mb-4">
        <?= htmlspecialchars($berita['judul']) ?>
      </h1>

      <p class="text-gray-500 text-sm mb-2 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Dipublikasikan pada: <?= date('d M Y', strtotime($berita['tanggal'])) ?>
      </p>

      <?php if (!empty($berita['tanggal_kegiatan'])): ?>
      <p class="text-purple-600 font-semibold text-sm mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
        </svg>
        Tanggal Kegiatan: <?= date('d M Y', strtotime($berita['tanggal_kegiatan'])) ?>
      </p>
      <?php endif; ?>

      <!-- GAMBAR & CAPTION -->
      <?php foreach ($gambars as $g): ?>
        <div class="mb-8">
          <div class="image-container">
            <img src="uploads/berita/<?= htmlspecialchars($g['file']) ?>" 
                 class="w-full object-cover max-h-[500px] sm:max-h-[600px] md:max-h-[650px]"
                 alt="<?= htmlspecialchars($berita['judul']) ?>">
          </div>

          <?php if (!empty($g['caption'])): ?>
            <div class="mt-4 px-4 py-5 bg-gradient-to-r from-purple-50 to-indigo-50 border-l-4 border-purple-500 rounded-r-lg">
              <p class="text-gray-700 text-base leading-relaxed text-justify whitespace-pre-line">
                <?= nl2br(htmlspecialchars($g['caption'])) ?>
              </p>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <a href="index.php#berita" class="btn-back mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Berita
      </a>

    </div>
  </div>
</div>

</body>
</html>
