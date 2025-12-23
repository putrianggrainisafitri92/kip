<?php include 'sidebar.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pusat Layanan – KIP Kuliah</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    .bg-hero {
      background-image: url('/KIPWEB/assets/bg-pelaporan.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    /* PAKSA SEMUA DI DALAM FOOTER JADI NON-TRANSPARAN */
    .footer-solid *, 
    .footer-solid {
        background-color: #1d0b33 !important; /* ungu gelap */
        opacity: 1 !important;
        backdrop-filter: none !important;
    }
  </style>
</head>

<body class="bg-hero">

<!-- OVERLAY UTAMA -->
<div class="bg-black bg-opacity-60 min-h-screen pt-32 pb-20 flex justify-center">

  <div class="w-full max-w-4xl backdrop-blur-xl bg-white bg-opacity-10 rounded-3xl shadow-2xl p-10">

    <h1 class="text-4xl font-extrabold text-white text-center mb-4 drop-shadow-xl">
      Pusat Layanan KIP Kuliah
    </h1>

    <p class="text-center text-gray-200 text-lg max-w-2xl mx-auto mb-12 leading-relaxed">
      Pusat layanan ini disediakan untuk memudahkan mahasiswa dalam menyampaikan 
      <span class="font-semibold text-purple-300">saran & pertanyaan</span>, serta 
      melakukan <span class="font-semibold text-red-300">pelaporan mahasiswa tidak layak</span> 
      penerima KIP-Kuliah.  
      Silakan pilih layanan yang sesuai dengan kebutuhan Anda.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-5">

      <a href="form_saran_pertanyaan.php"
        class="bg-white bg-opacity-20 backdrop-blur-md rounded-2xl shadow-lg hover:shadow-2xl 
               p-6 border border-white/20 hover:border-purple-500 transition transform
               hover:scale-[1.03] duration-300 block">
        <h2 class="text-2xl font-bold text-purple-300 mb-3 drop-shadow-sm">
          Kotak Saran & Pertanyaan
        </h2>
        <p class="text-gray-100 drop-shadow-sm leading-relaxed">
          Ajukan pertanyaan atau sampaikan masukan terkait layanan KIP-Kuliah.
        </p>
      </a>

      <a href="form_pelaporan.php"
        class="bg-white bg-opacity-20 backdrop-blur-md rounded-2xl shadow-lg hover:shadow-2xl 
               p-6 border border-white/20 hover:border-red-500 transition transform
               hover:scale-[1.03] duration-300 block">
        <h2 class="text-2xl font-bold text-red-300 mb-3 drop-shadow-sm">
          Pelaporan Mahasiswa Tidak Layak
        </h2>
        <p class="text-gray-100 drop-shadow-sm leading-relaxed">
          Laporkan mahasiswa yang diduga tidak memenuhi syarat sebagai penerima bantuan KIP-Kuliah.
        </p>
      </a>

    </div>

    <div class="mt-12 text-center">
      <a href="index.php"
        class="px-6 py-3 text-white font-semibold rounded-xl bg-white bg-opacity-20 
               backdrop-blur-lg border border-white/30 hover:bg-opacity-30 transition 
               transform hover:scale-[1.05]">
        ← Kembali ke Beranda
      </a>
    </div>

  </div>

</div> <!-- End Overlay -->



<!-- FOOTER FIX — DIJAMIN TIDAK TRANSPARAN -->
<div class="footer-solid w-full mt-0">
  <?php include 'footer.php'; ?>
</div>



</body>
</html>
