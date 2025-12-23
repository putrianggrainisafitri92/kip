<?php
// form_evaluasi_tahap1.php
session_start();
include 'koneksi.php';

// --- Validasi login berdasarkan NPM ---
$npm = $_SESSION['npm'] ?? null;
if (!$npm) {
    die("Anda belum login! Silakan lakukan validasi NPM terlebih dahulu.");
}

// --- Ambil id_mahasiswa_kip dari database berdasarkan NPM ---
$stmt = $koneksi->prepare("SELECT id_mahasiswa_kip, nama_mahasiswa FROM mahasiswa_kip WHERE npm=?");
$stmt->bind_param("s", $npm);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$id_mahasiswa_kip = $row['id_mahasiswa_kip'] ?? null;

if (!$id_mahasiswa_kip) {
    die("NPM tidak ditemukan di database!");
}

// -------------------- PROSES SUBMIT --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $persetujuan = $_POST['persetujuan'] ?? '';

    // Simpan data tahap 1 ke SESSION
    $_SESSION['tahap1'] = [
        'persetujuan' => $persetujuan
    ];

    // Lanjut ke tahap 2
    header("Location: form_evaluasi_tahap2.php");
    exit();
}


// Ambil session untuk prefill
$persetujuan = $_SESSION['tahap1']['persetujuan'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Tahap 1 - Persetujuan Pengisian | Evaluasi</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    body {
        background-image: url('assets/bg-pelaporan.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
</style>
</head>
  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>
<body class="text-gray-900 flex flex-col relative">

 <div class="mt-40 flex justify-center">
  <div class="bg-white rounded-2xl shadow-lg px-6 py-4 inline-block">
    <div class="flex flex-wrap items-center gap-6">

      <div class="flex flex-col items-center">
        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white font-bold ring-4 ring-purple-400/50">1</div>
        <span class="mt-2 text-sm font-semibold text-purple-800 text-center">Persetujuan<br>Pengisian</span>
      </div>

     
    </div>
  </div>
</div>



<!-- Overlay biar teks jelas -->
<div class="absolute inset-0 bg-black/50 -z-10"></div>

<main class="flex justify-center mt-10 mb-6 px-4">

<div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-8">
    <h2 class="text-2xl font-bold text-purple-800 mb-4 text-center">Persetujuan Pengisian</h2>

    <form action="" method="POST" class="space-y-6">
        <div>
            <p class="font-semibold mb-2">Apakah Anda telah membaca ketentuan pengisian?</p>
            <div class="flex items-center space-x-4">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="persetujuan" value="Ya" <?= $persetujuan=='Ya' ? 'checked' : '' ?> required class="w-5 h-5 text-purple-700">
                    <span>Ya</span>
                </label>

                <label class="flex items-center space-x-2">
                    <input type="radio" name="persetujuan" value="Tidak" <?= $persetujuan=='Tidak' ? 'checked' : '' ?> required class="w-5 h-5 text-purple-700">
                    <span>Tidak</span>
                </label>
            </div>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="index.php" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <button type="submit"
                class="px-8 py-3 bg-gradient-to-r from-purple-700 to-purple-900 text-white font-semibold rounded-full shadow-md hover:scale-105 transition-transform duration-300">
                Lanjut <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

</main>

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
