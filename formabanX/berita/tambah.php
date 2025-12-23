<?php
include "../auth_formaban.php";
include "../../koneksi.php";

$id_admin = intval($_SESSION['id_admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi   = mysqli_real_escape_string($koneksi, $_POST['isi']);

    if (empty($_FILES['gambar']['name'])) {
        echo "<script>alert('Gambar wajib diupload!'); history.back();</script>";
        exit;
    }

    $namaFile = time() . '_' . basename($_FILES['gambar']['name']);
    $targetDir = '../../uploads/berita/';
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $targetFile = $targetDir . $namaFile;

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];
    if (!in_array($ext, $allowed)) { echo "<script>alert('Format gambar tidak valid!'); history.back();</script>"; exit; }
    if ($_FILES['gambar']['size'] > 5*1024*1024) { echo "<script>alert('Ukuran gambar maksimal 5MB!'); history.back();</script>"; exit; }

    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        echo "<script>alert('Upload gambar gagal!'); history.back();</script>"; exit;
    }

    $sql = "INSERT INTO berita (id_admin, judul, isi, gambar, tanggal) VALUES ('$id_admin', '$judul', '$isi', '$namaFile', NOW())";
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Berita berhasil ditambahkan!'); window.location='list.php';</script>"; exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><title>Tambah Berita</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex">
<?php include "../sidebar.php"; ?>
<div class="flex-1 p-10 ml-64">
  <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg border">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-800">Upload Berita Baru</h2>
    <form method="POST" enctype="multipart/form-data" class="space-y-5">
      <div><label class="block">Judul</label><input name="judul" required class="w-full p-3 border rounded"></div>
      <div><label class="block">Isi</label><textarea name="isi" rows="5" required class="w-full p-3 border rounded"></textarea></div>
      <div><label class="block">Gambar (Wajib)</label><input type="file" name="gambar" accept="image/*" required class="w-full"></div>
      <button class="w-full bg-blue-800 text-white py-3 rounded">Upload Berita</button>
    </form>
  </div>
</div>
</body>
</html>
