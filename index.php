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
<body class="bg-gradient-to-br from-[#8A4FFF] to-[#C084FC]">
<style>

#heroImage {
    background-size: cover;
    background-position: center 70%; /* lebih turun */
    transition: opacity 0.7s ease-in-out;
}

  .hero-bg { opacity: 1; transition: opacity 0.8s ease-in-out; }

  .slider-btn {
    cursor: pointer;
    user-select: none;
  }
</style>


  <style>
    .main-content {
      transition: margin-left 0.3s ease;
      padding: 2.5rem;
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
  <div class="bg-purple-700 rounded-2xl shadow-xl p-6 hover:scale-105 transition duration-300 text-white">


    <!-- Gambar pertama -->
    <?php if (!empty($b['gambar'])): ?>
      <img src="uploads/berita/<?= htmlspecialchars($b['gambar']) ?>" 
           alt="<?= htmlspecialchars($b['judul']) ?>" 
           class="rounded-xl mb-4 w-full h-48 object-cover shadow-lg">
    <?php endif; ?>

    <!-- Judul -->
    <h4 class="font-semibold text-xl mb-2 text-white">
      <?= htmlspecialchars($b['judul']) ?>
    </h4>

    <!-- Tombol ke detail berita -->
    <a href="berita_detail.php?id=<?= $b['id_berita'] ?>" 
   class="inline-block bg-white text-purple-700 font-semibold px-4 py-2 rounded-lg hover:bg-gray-200 transition">
   Baca Selengkapnya →
</a>

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
