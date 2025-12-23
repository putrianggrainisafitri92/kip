<?php
session_start();
include 'koneksi.php';

// ---- VALIDASI LOGIN ----
if (!isset($_SESSION['npm'])) {
    header("Location: form_evaluasi_tahap3.php");
    exit;
}

$npm = $_SESSION['npm'];
$res = mysqli_query($koneksi, "SELECT id_mahasiswa_kip FROM mahasiswa_kip WHERE npm='$npm' LIMIT 1");
$user = mysqli_fetch_assoc($res);
if (!$user) die("Mahasiswa tidak ditemukan");

$id = intval($user['id_mahasiswa_kip']);

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uploadDir = __DIR__ . "/uploads/evaluasi/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $allowed_ext = ['pdf', 'doc', 'docx'];
    $max_size = 10 * 1024 * 1024;

    $fields = [
        "file_eval" => "",
    ];

   $errors = [];

foreach ($fields as $key => $val) {
    if (!empty($_FILES[$key]['name'])) {
        $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) {
            $errors[] = "Format file $key harus PDF/DOC/DOCX!";
            continue;
        }
        if ($_FILES[$key]['size'] > $max_size) {
            $errors[] = "Ukuran file $key melebihi 10MB!";
            continue;
        }

        $newName = $key."_".$id."_".time().".".$ext;
        $targetFile = $uploadDir . $newName;

        if (move_uploaded_file($_FILES[$key]['tmp_name'], $targetFile)) {
            $fields[$key] = $newName;
        } else {
            $errors[] = "Gagal upload file $key!";
        }
    }
}

// Validasi wajib file_eval
if (empty($fields["file_eval"])) {
    $errors[] = "Dokumen Evaluasi wajib diupload!";
}

// Jika tidak ada error, simpan ke session
if (empty($errors)) {
    $_SESSION['tahap4'] = $fields;
    header("Location: submit_evaluasi.php");
    exit;
}
}

    
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tahap 4 - Unggah Dokumen | KIP Kuliah Polinela</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

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
          4
        </div>
        <span class="mt-2 text-sm font-semibold text-purple-800 text-center">
          Unggah<br>Dokumen
        </span>
      </div>
    </div>
  </div>
</div>

<main class="flex justify-center mt-10 mb-6 px-4">

<div class="bg-white text-gray-800 rounded-2xl shadow-2xl p-8 max-w-3xl w-full">
    <h2 class="text-2xl font-bold text-purple-800 mb-6 text-center">Tahap 4 — Unggah Dokumen Pendukung</h2>

    <div class="bg-purple-100 text-purple-800 p-4 rounded-lg mb-6">
        <h3 class="font-semibold mb-2">Ketentuan Dokumen:</h3>
        <ol class="list-decimal ml-5 space-y-1 text-sm">
            <li>Slip gaji orang tua atau surat keterangan penghasilan</li>
            <li>Scan Kartu Keluarga</li>
            <li>KKS/PKH/DTKS/SKTM</li>
            <li>Sertifikat lomba (opsional)</li>
            <li>Surat aktif organisasi (opsional)</li>
            <li>Foto rumah</li>
            <li>Surat nikah/cerai/kematian (opsional)</li>
            <li>Surat pernyataan evaluasi bermeterai</li>
        </ol>
        <p class="mt-2 text-sm">Semua dokumen gabungkan menjadi 1 PDF maksimal 10MB.</p>
    </div>

    <?php if($error_message): ?>
        <p class="text-red-600 mb-4 font-semibold"><?=$error_message?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">

        <div>
            <label class="font-semibold">Dokumen Evaluasi (Wajib)</label>
            <input type="file" name="file_eval" required class="w-full border rounded-lg p-3">
        </div>

        <div class="flex justify-between mt-6">
            <a href="form_evaluasi_tahap3.php" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-700 to-purple-900 text-white font-semibold rounded-full shadow-md hover:scale-105 transition-transform">
                <i class="bi bi-cloud-upload"></i> Kirim Evaluasi
            </button>
        </div>

    </form>
</div>
</main>
<?php include 'footer.php'; ?>
</html>
