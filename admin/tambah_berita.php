<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judul = $_POST['judul'];
  $isi = $_POST['isi'];

  // ✅ Cek apakah file gambar diupload
  if (empty($_FILES['gambar']['name'])) {
    echo "<script>alert(' Gambar wajib diupload!'); history.back();</script>";
    exit;
  }

  $namaFile = time() . '_' . basename($_FILES['gambar']['name']);
  $targetDir = '../uploads/berita/';
  $targetFile = $targetDir . $namaFile;

  // Pastikan folder tujuan ada
  if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
  }

  // Validasi format file
  $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
  if (!in_array($ext, $allowed)) {
    echo "<script>alert(' Format gambar tidak diizinkan! (Hanya JPG, JPEG, PNG, GIF, WEBP)'); history.back();</script>";
    exit;
  }

  // Maksimal ukuran 5MB
  if ($_FILES['gambar']['size'] > 5 * 1024 * 1024) {
    echo "<script>alert(' Ukuran gambar maksimal 5MB!'); history.back();</script>";
    exit;
  }

  // Pindahkan file
  if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
    echo "<script>alert(' Upload gambar gagal!'); history.back();</script>";
    exit;
  }

  $gambar = $namaFile;

  // Simpan ke database
  $sql = "INSERT INTO berita (judul, isi, gambar) VALUES ('$judul', '$isi', '$gambar')";
  if (mysqli_query($koneksi, $sql)) {
    echo "<script>alert(' Berita berhasil diupload!'); window.location='manajemen_berita.php';</script>";
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}
?>

<?php include 'sidebar.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Berita</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <!-- Sidebar -->
  <div class="w-64">
    <!-- sidebar.php sudah include di atas -->
  </div>

  <!-- Konten utama -->
  <div class="flex-1 p-10">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200">
      <h2 class="text-2xl font-bold mb-6 text-center bg-gradient-to-r from-blue-800 to-blue-600 bg-clip-text text-transparent">
        Upload Berita Baru
      </h2>
      <form method="POST" enctype="multipart/form-data" class="space-y-5">
        <div>
          <label class="block font-semibold mb-2 text-gray-700">Judul Berita</label>
          <input type="text" name="judul" required class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
        </div>
        <div>
          <label class="block font-semibold mb-2 text-gray-700">Isi Berita</label>
          <textarea name="isi" rows="5" required class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700"></textarea>
        </div>
        <div>
          <label class="block font-semibold mb-2 text-gray-700">Gambar (WAJIB)</label>
          <input type="file" name="gambar" accept="image/*" required class="w-full border border-gray-300 p-3 rounded-lg">
          <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, GIF, WEBP (maks. 5MB)</p>
        </div>
        <button type="submit" class="w-full bg-gradient-to-r from-blue-800 to-blue-600 text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
          Upload
        </button>
      </form>
    </div>
  </div>

</body>
</html>
