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
<style>
    body {
        background-image: url('assets/bg-pelaporan.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
</style>
</head>

<body class="text-gray-900 flex flex-col relative">
<div class="absolute inset-0 bg-black/50 -z-10"></div>

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>
<body class="text-gray-900 flex flex-col relative">

 <div class="mt-40 flex justify-center">
  <div class="bg-white rounded-2xl shadow-lg px-6 py-4 inline-block">
    <div class="flex items-center gap-6">
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 flex items-center justify-center rounded-full
          bg-gradient-to-br from-purple-700 to-purple-900
          text-white font-bold ring-4 ring-purple-400/50">
          2
        </div>
        <span class="mt-2 text-sm font-semibold text-purple-800 text-center">
          Data<br>Mahasiswa
        </span>
      </div>
    </div>
  </div>
</div>

<main class="flex justify-center mt-10 mb-6 px-4">


<div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-8">
 

 <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-8">
  <h2 class="text-2xl font-bold text-purple-800 mb-6 text-center">Tahap 2 — Data Mahasiswa</h2>

  <?php if (!empty($errors)): ?>
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
      <?php foreach($errors as $e) echo "<div>- ".htmlspecialchars($e)."</div>"; ?>
    </div>
  <?php endif; ?>

  <?php if ($mhs): ?>
    <div class="bg-purple-100 border-l-4 border-purple-600 p-4 mb-6 rounded">
      <p><b>NPM:</b> <?= htmlspecialchars($mhs['npm']) ?></p>
      <p><b>Nama:</b> <?= htmlspecialchars($mhs['nama_mahasiswa']) ?></p>
      <p><b>Prodi:</b> <?= htmlspecialchars($mhs['program_studi']) ?></p>
      <p><b>Jurusan:</b> <?= htmlspecialchars($mhs['jurusan']) ?></p>
    </div>
  <?php endif; ?>

  <form method="POST" class="space-y-6">

    <!-- Kondisi Awal -->
    <div>
      <label class="font-semibold">Kondisi Awal *</label>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
        <?php
          $opsi = ["Terdata DTKS","Penerima PKH","Penerima KKS","Pemegang SKTM","P3KE Desil 1-3","P3KE Desil 4-7","Tinggal di Panti Asuhan"];
          foreach ($opsi as $o):
            $checked = in_array($o, $kondisi_awal_array) ? "checked" : "";
        ?>
          <label class="flex items-center gap-2">
            <input type="checkbox" name="kondisi_awal[]" value="<?= htmlspecialchars($o) ?>" <?= $checked ?>>
            <?= htmlspecialchars($o) ?>
          </label>
        <?php endforeach; ?>
      </div>
      <input type="text" name="kondisi_awal_lain" placeholder="Lainnya (opsional)"
             class="mt-3 w-full border rounded p-3"
             value="<?= htmlspecialchars($kondisi_awal_lain) ?>">
    </div>

    <!-- Keaktifan -->
    <div>
      <label class="font-semibold">Keaktifan *</label>
      <select name="keaktifan" class="w-full border rounded p-3" required>
          <option value="">-- Pilih --</option>
          <option value="AKTIF" <?= $keaktifan === "AKTIF" ? "selected" : "" ?>>AKTIF</option>
          <option value="TIDAK AKTIF" <?= $keaktifan === "TIDAK AKTIF" ? "selected" : "" ?>>TIDAK AKTIF</option>
          <option value="CUTI AKADEMIK / CUTI SEPIHAK" <?= $keaktifan === "CUTI AKADEMIK / CUTI SEPIHAK" ? "selected" : "" ?>>CUTI AKADEMIK / CUTI SEPIHAK</option>
          <option value="CUTI SAKIT" <?= $keaktifan === "CUTI SAKIT" ? "selected" : "" ?>>CUTI SAKIT</option>
          <option value="Menolak / Mundur" <?= $keaktifan === "Menolak / Mundur" ? "selected" : "" ?>>Menolak / Mundur</option>
          <option value="Mengundurkan Diri" <?= $keaktifan === "Mengundurkan Diri" ? "selected" : "" ?>>Mengundurkan Diri</option>
      </select>
    </div>

    <!-- Prestasi -->
    <div>
      <label class="font-semibold">Prestasi Non Akademik (Opsional)</label>
      <input type="text" name="prestasi" value="<?= htmlspecialchars($prestasi) ?>" class="w-full border rounded p-3">
    </div>

    <!-- Tombol Navigasi -->
    <div class="flex justify-between items-center mt-8">
      <a href="form_evaluasi_tahap1.php" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
        ‹ Kembali
      </a>
      <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-700 to-purple-900 text-white font-semibold rounded-full shadow-md hover:scale-105 transition">
        Lanjut ke tahap 3 →
      </button>
    </div>

  </form>
</div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
