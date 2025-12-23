<?php include 'sidebar.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kotak Saran & Pertanyaan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    .bg-hero {
      background-image: url('/KIPWEB/assets/bg-pelaporan.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
  </style>
</head>

<body class="bg-hero">

<!-- Overlay -->
<div class="bg-black bg-opacity-60 min-h-screen flex justify-center items-start p-8 pt-28">

  <!-- Card Putih -->
  <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl p-10 border border-purple-300/40">

    <!-- Judul -->
    <h2 class="text-3xl font-bold text-center text-purple-700 mb-2">
      Kotak Saran & Pertanyaan
    </h2>

    <p class="text-center text-gray-600 mb-8">
      Ajukan kritik, saran, atau pertanyaan mengenai layanan KIP-Kuliah.
    </p>

    <!-- Form -->
    <form id="layananForm" action="simpan_layanan.php" method="POST" class="space-y-5">

      <!-- Jenis Pesan -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Jenis Pesan</label>
        <select name="jenis" required
          class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50
                 focus:ring-2 focus:ring-purple-400 focus:border-purple-500 outline-none transition">
          <option value="">-- Pilih Jenis Pesan --</option>
          <option value="saran">Saran</option>
          <option value="pertanyaan">Pertanyaan</option>
        </select>
      </div>

      <!-- Nama -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Nama</label>
        <input 
          type="text" 
          name="nama" 
          required
          class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50
                 focus:ring-2 focus:ring-purple-400 focus:border-purple-500 outline-none transition"
        >
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Email</label>
        <input 
          type="email" 
          name="email" 
          required
          class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50
                 focus:ring-2 focus:ring-purple-400 focus:border-purple-500 outline-none transition"
        >
      </div>

      <!-- Pesan -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Pertanyaan / Saran</label>
        <textarea 
          name="pesan" 
          required 
          class="w-full px-4 py-3 rounded-xl border border-purple-300 bg-purple-50 h-32
                 focus:ring-2 focus:ring-purple-400 focus:border-purple-500 
                 outline-none transition"
        ></textarea>
      </div>

      <!-- Tombol Submit -->
      <button type="submit"
        class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-600 to-purple-400
               text-white font-bold shadow-lg hover:scale-[1.03] transition transform">
        Kirim
      </button>

    </form>

    <!-- Tombol kembali -->
    <div class="text-center mt-6">
      <a href="pusat_layanan.php" 
         class="inline-block px-5 py-2 rounded-xl text-purple-700 font-semibold
                border border-purple-300 bg-purple-100
                hover:bg-purple-200 hover:scale-[1.05] transition">
        ← Kembali
      </a>
    </div>

  </div>

</div>

<!-- ======================= POPUP MODAL ======================= -->
<div id="popupModal"
     class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50">

  <div class="bg-white w-96 p-7 rounded-3xl shadow-2xl text-center border border-purple-300">
      
      <h2 class="text-2xl font-bold text-purple-700 mb-3">
        Terima Kasih!
      </h2>

      <p class="text-gray-700 mb-6">
        Terima kasih atas saran dan pertanyaan Anda.<br>
        Untuk pertanyaan, silakan tunggu balasan dari admin.
      </p>

      <button id="popupOk"
        class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-600 to-purple-400
               text-white font-bold shadow-md hover:scale-[1.03] transition">
        Oke, Mengerti
      </button>

  </div>
</div>

<!-- ====================== SCRIPT POPUP ======================== -->
<script>
const form = document.getElementById("layananForm");
const popup = document.getElementById("popupModal");
const btnOk = document.getElementById("popupOk");

form.addEventListener("submit", function(e){
    e.preventDefault(); // hentikan pengiriman dulu
    popup.classList.remove("hidden"); // tampilkan popup
});

btnOk.addEventListener("click", function(){
    popup.classList.add("hidden");
    form.submit(); // lanjut kirim ke simpan_layanan.php
});
</script>

</body>
</html>
