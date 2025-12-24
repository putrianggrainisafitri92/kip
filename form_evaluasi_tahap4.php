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
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Tahap 4 - Unggah Dokumen | KIP Kuliah Polinela</title>
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
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white font-bold ring-4 ring-purple-400/50 text-lg shadow">4</div>
              <span class="mt-2 text-sm font-bold text-purple-800 text-center uppercase tracking-wide">Unggah<br>Dokumen</span>
            </div>
        </div>
      </div>

     <!-- FORM CONTENT -->
     <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-8 md:p-10 relative z-10 border border-purple-100">
       <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 text-transparent bg-clip-text bg-gradient-to-r from-purple-800 to-purple-600">
            Tahap 4 — Unggah Dokumen
       </h2>

        <div class="bg-blue-50 text-blue-800 p-5 rounded-xl mb-8 border border-blue-200 shadow-sm">
            <h3 class="font-bold flex items-center gap-2 mb-3"><i class="bi bi-info-circle-fill"></i> Ketentuan Dokumen:</h3>
            <ol class="list-decimal ml-5 space-y-1 text-sm font-medium">
                <li>Slip gaji orang tua atau surat keterangan penghasilan</li>
                <li>Scan Kartu Keluarga</li>
                <li>KKS/PKH/DTKS/SKTM</li>
                <li>Sertifikat lomba (opsional)</li>
                <li>Surat aktif organisasi (opsional)</li>
                <li>Foto rumah</li>
                <li>Surat nikah/cerai/kematian (opsional)</li>
                <li>Surat pernyataan evaluasi bermeterai</li>
            </ol>
            <p class="mt-3 text-sm font-bold text-blue-900 bg-blue-100 p-2 rounded inline-block"><i class="bi bi-file-earmark-pdf-fill mr-1"></i> Gabungkan semua dokumen menjadi 1 file PDF (Maks 10 MB)</p>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
            <div class="font-bold mb-1"><i class="bi bi-exclamation-triangle-fill mr-2"></i>Gagal Upload:</div>
            <?php foreach($errors as $e) echo "<div class='ml-6'>- ".htmlspecialchars($e)."</div>"; ?>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">

            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:border-purple-300 transition-colors">
                <label class="font-bold text-gray-800 block mb-3 text-lg">Upload Dokumen Evaluasi (Wajib)</label>
                <div class="relative">
                    <input type="file" name="file_eval" required class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2.5 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-purple-100 file:text-purple-700
                    hover:file:bg-purple-200
                    cursor-pointer border border-gray-300 rounded-lg bg-white p-1
                    focus:outline-none focus:ring-2 focus:ring-purple-400
                  "/>
                </div>
                <p class="text-xs text-gray-500 mt-2 ml-1">Format accepted: .pdf, .doc, .docx (Max 10MB)</p>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-100">
                <a href="form_evaluasi_tahap3.php" class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition text-center">
                    <i class="bi bi-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-purple-700 to-purple-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-purple-500/30 hover:scale-[1.02] transition duration-300 flex items-center justify-center gap-2">
                    <i class="bi bi-cloud-upload"></i> Kirim Evaluasi
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
