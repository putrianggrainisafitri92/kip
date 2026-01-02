<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pusat Layanan – KIP Kuliah</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    .bg-hero {
      background-image: url('assets/bg-pelaporan.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    /* PAKSA FOOTER JADI NON-TRANSPARAN */
    .footer-solid {
        background-color: #1d0b33;
        position: relative;
        z-index: 50;
    }
    
    /* Force footer element to be solid and opaque */
    .footer-solid footer {
        background-color: #1d0b33 !important;
        background-image: none !important;
        opacity: 1 !important;
    }

    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 768px) {
      .pt-32 {
        padding-top: 6rem !important;
      }
      .pb-20 {
        padding-bottom: 3rem !important;
      }
      .p-10 {
        padding: 1.5rem !important;
      }
      .text-4xl {
        font-size: 1.75rem !important;
      }
      .text-2xl {
        font-size: 1.25rem !important;
      }
      .text-lg {
        font-size: 1rem !important;
      }
      .gap-10 {
        gap: 1.5rem !important;
      }
      .max-w-4xl {
        max-width: 95% !important;
        margin-left: auto;
        margin-right: auto;
      }
      .rounded-3xl {
        border-radius: 1rem !important;
      }
    }

    @media (max-width: 480px) {
      .pt-32 {
        padding-top: 5rem !important;
      }
      .p-10 {
        padding: 1rem !important;
      }
      .p-6 {
        padding: 1rem !important;
      }
      .text-4xl {
        font-size: 1.5rem !important;
      }
      .text-2xl {
        font-size: 1.1rem !important;
      }
      .mb-12 {
        margin-bottom: 1.5rem !important;
      }
      .mt-12 {
        margin-top: 1.5rem !important;
      }
      .px-6 {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
      }
      .py-3 {
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
      }
    }

    /* Animations */
    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-down { animation: fadeInDown 0.8s ease-out both; }
    .animate-fade-up { animation: fadeInUp 0.8s ease-out both; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
  </style>
</head>

<body class="bg-hero">
<?php include 'sidebar.php'; ?>

<!-- OVERLAY UTAMA -->
<div class="bg-black bg-opacity-60 min-h-screen pt-32 pb-20 flex justify-center">

  <div class="w-full max-w-4xl backdrop-blur-xl bg-white bg-opacity-10 rounded-3xl shadow-2xl p-10">

    <h1 class="text-4xl font-extrabold text-white text-center mb-4 drop-shadow-xl animate-fade-down">
      Pusat Layanan KIP Kuliah
    </h1>

    <p class="text-center text-gray-200 text-lg max-w-2xl mx-auto mb-12 leading-relaxed animate-fade-down delay-100">
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
               hover:scale-[1.05] duration-300 block animate-fade-up delay-200">
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
               hover:scale-[1.05] duration-300 block animate-fade-up delay-300">
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




<?php include 'chatbot_widget.php'; ?>
</body>
</html>
