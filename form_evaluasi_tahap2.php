<?php
// form_evaluasi_tahap2.php
session_start();
include 'koneksi.php';

// --- CEK SESSION NPM ---
if (!isset($_SESSION['npm'])) {
    header("Location: form_evaluasi_validasi.php");
    exit();
}

// --- AMBIL DATA MAHASISWA BERDASARKAN NPM ---
$npm = $_SESSION['npm'];
$stmt = $koneksi->prepare("SELECT * FROM mahasiswa_kip WHERE npm = ? LIMIT 1");
$stmt->bind_param("s", $npm);
$stmt->execute();
$res = $stmt->get_result();
$mhs = $res->fetch_assoc();

if (!$mhs) {
    die("Data mahasiswa tidak ditemukan untuk NPM $npm");
}

$id_mhs = $mhs['id_mahasiswa_kip'];

// Ambil session sebelumnya untuk prefill
$kondisi_awal_array = $_SESSION['tahap2']['kondisi_awal'] ?? [];
$kondisi_awal_lain  = $_SESSION['tahap2']['kondisi_awal_lain'] ?? '';
$keaktifan          = $_SESSION['tahap2']['keaktifan'] ?? '';
$prestasi           = $_SESSION['tahap2']['prestasi'] ?? '';

$errors = [];

// Proses submit — simpan hanya ke session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kondisi_awal = $_POST['kondisi_awal'] ?? [];
    $kondisi_awal_lain = trim($_POST['kondisi_awal_lain'] ?? '');

    if ($kondisi_awal_lain !== '') $kondisi_awal[] = $kondisi_awal_lain;
    if (empty($kondisi_awal)) $kondisi_awal = ["Tidak ada"];

    // 🔥 FIX PENTING – AMBIL DARI POST DULU
    $keaktifan = $_POST['keaktifan'] ?? '';

    $keaktifan_options = [
        "AKTIF",
        "TIDAK AKTIF",
        "CUTI AKADEMIK / CUTI SEPIHAK",
        "CUTI SAKIT",
        "Menolak / Mundur",
        "Mengundurkan Diri"
    ];

    if(empty($keaktifan)){
        $errors[] = "Keaktifan harus dipilih.";
    } elseif(!in_array($keaktifan, $keaktifan_options)){
        $errors[] = "Status keaktifan tidak valid.";
    }

    $prestasi  = trim($_POST['prestasi'] ?? '');


    if (count($errors) === 0) {
    $_SESSION['tahap2'] = [
        'kondisi_awal' => $kondisi_awal,
        'kondisi_awal_lain' => $kondisi_awal_lain,
        'keaktifan' => $keaktifan,
        'prestasi' => $prestasi
    ];

    // TIDAK ADA QUERY DATABASE DI SINI
    header("Location: form_evaluasi_tahap3.php");
    exit();
}
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Form Evaluasi — Tahap 2</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-image: url('assets/bg-pelaporan.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* Main Layout */
    .main-content {
      transition: margin-left 0.3s ease;
      padding-top: 90px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-bottom: 50px;
    }
    .main-content.shifted {
      margin-left: 260px;
    }
    
    @media (max-width: 768px) {
      .main-content.shifted { margin-left: 0; }
      .main-content { padding-top: 80px; padding-left: 1rem; padding-right: 1rem; }
    }
</style>
</head>

<body class="text-gray-900 relative">
  
  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>

  <div class="main-content" id="main-content">
  
      <!-- STEP INDICATOR -->
      <div class="mb-8 w-full max-w-3xl flex justify-center">
        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-lg px-8 py-4 inline-block border border-purple-100">
            <div class="flex flex-col items-center">
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white font-bold ring-4 ring-purple-400/50 text-lg shadow">2</div>
              <span class="mt-2 text-sm font-bold text-purple-800 text-center uppercase tracking-wide">Data<br>Mahasiswa</span>
            </div>
        </div>
      </div>

     <!-- FORM CONTENT -->
     <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-8 md:p-10 relative z-10 border border-purple-100">
      <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-transparent bg-clip-text bg-gradient-to-r from-purple-800 to-purple-600">
        Tahap 2 — Data Mahasiswa
      </h2>

      <?php if (!empty($errors)): ?>
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
          <div class="font-bold flex items-center gap-2"><i class="bi bi-exclamation-circle-fill"></i> Perhatian:</div>
          <?php foreach($errors as $e) echo "<div class='ml-6'>- ".htmlspecialchars($e)."</div>"; ?>
        </div>
      <?php endif; ?>

      <?php if ($mhs): ?>
        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-100 p-6 mb-8 rounded-xl shadow-sm">
          <h3 class="font-bold text-purple-800 mb-4 border-b border-purple-200 pb-2"><i class="bi bi-person-badge mr-2"></i>Informasi Mahasiswa</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
             <div><span class="font-semibold block text-purple-600">NPM:</span> <?= htmlspecialchars($mhs['npm']) ?></div>
             <div><span class="font-semibold block text-purple-600">Nama:</span> <?= htmlspecialchars($mhs['nama_mahasiswa']) ?></div>
             <div><span class="font-semibold block text-purple-600">Prodi:</span> <?= htmlspecialchars($mhs['program_studi']) ?></div>
             <div><span class="font-semibold block text-purple-600">Jurusan:</span> <?= htmlspecialchars($mhs['jurusan']) ?></div>
          </div>
        </div>
      <?php endif; ?>

      <form method="POST" class="space-y-6">
        <!-- Kondisi Awal -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
          <label class="font-bold text-gray-800 text-lg mb-3 block">Kondisi Awal <span class="text-red-500">*</span></label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
            <?php
              $opsi = ["Terdata DTKS","Penerima PKH","Penerima KKS","Pemegang SKTM","P3KE Desil 1-3","P3KE Desil 4-7","Tinggal di Panti Asuhan"];
              foreach ($opsi as $o):
                $checked = in_array($o, $kondisi_awal_array) ? "checked" : "";
            ?>
              <label class="flex items-center gap-3 p-3 bg-white rounded-lg border hover:border-purple-400 cursor-pointer transition">
                <input type="checkbox" name="kondisi_awal[]" value="<?= htmlspecialchars($o) ?>" <?= $checked ?> class="w-5 h-5 text-purple-700 rounded focus:ring-purple-500">
                <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($o) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
          <input type="text" name="kondisi_awal_lain" placeholder="Lainnya (opsional)"
                 class="mt-4 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400 outline-none transition"
                 value="<?= htmlspecialchars($kondisi_awal_lain) ?>">
        </div>

        <!-- Keaktifan -->
        <div>
          <label class="font-bold text-gray-800 text-lg mb-2 block">Keaktifan <span class="text-red-500">*</span></label>
          <div class="relative">
             <select name="keaktifan" class="w-full border border-gray-300 rounded-lg p-3 pr-10 appearance-none focus:ring-2 focus:ring-purple-400 outline-none bg-white font-medium text-gray-700" required>
                <option value="">-- Pilih Status Keaktifan --</option>
                <option value="AKTIF" <?= $keaktifan === "AKTIF" ? "selected" : "" ?>>AKTIF</option>
                <option value="TIDAK AKTIF" <?= $keaktifan === "TIDAK AKTIF" ? "selected" : "" ?>>TIDAK AKTIF</option>
                <option value="CUTI AKADEMIK / CUTI SEPIHAK" <?= $keaktifan === "CUTI AKADEMIK / CUTI SEPIHAK" ? "selected" : "" ?>>CUTI AKADEMIK / CUTI SEPIHAK</option>
                <option value="CUTI SAKIT" <?= $keaktifan === "CUTI SAKIT" ? "selected" : "" ?>>CUTI SAKIT</option>
                <option value="Menolak / Mundur" <?= $keaktifan === "Menolak / Mundur" ? "selected" : "" ?>>Menolak / Mundur</option>
                <option value="Mengundurkan Diri" <?= $keaktifan === "Mengundurkan Diri" ? "selected" : "" ?>>Mengundurkan Diri</option>
             </select>
             <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-purple-700">
               <i class="fa fa-chevron-down"></i>
             </div>
          </div>
        </div>

        <!-- Prestasi -->
        <div>
          <label class="font-bold text-gray-800 text-lg mb-2 block">Prestasi Non Akademik (Opsional)</label>
          <input type="text" name="prestasi" value="<?= htmlspecialchars($prestasi) ?>" 
                 placeholder="Contoh: Juara 1 Lomba Web Design Nasional"
                 class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400 outline-none transition">
        </div>

        <!-- Tombol Navigasi -->
        <div class="flex flex-col-reverse sm:flex-row justify-between items-center gap-4 mt-10 pt-6 border-t border-gray-100">
          <a href="form_evaluasi_tahap1.php" class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition text-center">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
          </a>
          <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-purple-700 to-purple-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-purple-500/30 hover:scale-[1.02] transition duration-300 flex items-center justify-center gap-2">
            Lanjut Tahap 3 <i class="bi bi-arrow-right"></i>
          </button>
        </div>

      </form>
    </div>

  </div> <!-- End Main Content -->

<!-- SCRIPT -->
<script>
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            if (sidebar) sidebar.classList.toggle('active');
            if (mainContent) mainContent.classList.toggle('shifted');
        });
    }
</script>

<?php include 'footer.php'; ?>

</body>
</html>
