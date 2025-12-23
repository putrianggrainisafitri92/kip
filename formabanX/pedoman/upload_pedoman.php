<?php
include "../auth_formaban.php";
include "../../koneksi.php";

$id_admin = intval($_SESSION['id_admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_file = mysqli_real_escape_string($koneksi, $_POST['nama_file']);

    if (empty($_FILES['file']['name'])) {
        echo "<script>alert('File wajib diupload!'); history.back();</script>"; exit;
    }

    $namaFile = time() . '_' . basename($_FILES['file']['name']);
    $targetDir = '../../uploads/pedoman/';
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $targetFile = $targetDir . $namaFile;

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
    if (!in_array($ext, $allowed)) { echo "<script>alert('Format file tidak valid! (pdf/doc/ppt)'); history.back();</script>"; exit; }
    if ($_FILES['file']['size'] > 10*1024*1024) { echo "<script>alert('Ukuran maksimal 10MB!'); history.back();</script>"; exit; }

    if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo "<script>alert('Upload file gagal!'); history.back();</script>"; exit;
    }

    $file_path = "uploads/pedoman/" . $namaFile; // path relatif dari root project
    $sql = "INSERT INTO pedoman (id_admin, nama_file, file_path, status, created_at) VALUES ('$id_admin', '$nama_file', '$file_path', 'pending', NOW())";
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Pedoman berhasil diupload!'); window.location='pedoman.php';</script>"; exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><title>Upload Pedoman</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex">
<?php include "../sidebar.php"; ?>
<div class="flex-1 p-10 ml-64">
  <div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-lg border">
    <h2 class="text-2xl font-bold mb-6 text-blue-800">Upload Pedoman</h2>
    <form method="POST" enctype="multipart/form-data" class="space-y-5">
      <div><label class="block">Nama File</label><input name="nama_file" required class="w-full p-3 border rounded"></div>
      <div><label class="block">File (pdf/doc/ppt)</label><input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" required class="w-full"></div>
      <button class="w-full bg-blue-800 text-white py-3 rounded">Upload</button>
    </form>
  </div>
</div>
</body>
</html>
