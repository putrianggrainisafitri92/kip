<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "koneksi.php";
include 'sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pelapor   = mysqli_real_escape_string($koneksi, $_POST['nama_pelapor']);
    $email_pelapor  = mysqli_real_escape_string($koneksi, $_POST['email_pelapor']);
    $nama_terlapor  = mysqli_real_escape_string($koneksi, $_POST['nama_terlapor']);
    $npm_terlapor   = mysqli_real_escape_string($koneksi, $_POST['npm_terlapor']);
    $jurusan        = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $prodi          = mysqli_real_escape_string($koneksi, $_POST['prodi']);
    $alasan         = mysqli_real_escape_string($koneksi, $_POST['alasan']);
    $detail_laporan = mysqli_real_escape_string($koneksi, $_POST['detail_laporan']);
    $pernyataan     = isset($_POST['pernyataan']) ? 1 : 0;

    // ✅ Bukti pendukung wajib
    if (empty($_FILES['bukti']['name'])) {
        echo "<script>alert(' Bukti pendukung wajib diupload!'); history.back();</script>";
        exit;
    }

    // ✅ Upload file bukti
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["bukti"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];

    if (!in_array($file_ext, $allowed)) {
        echo "<script>alert(' Format file tidak diizinkan! (Hanya JPG, PNG, PDF, DOC, DOCX)'); history.back();</script>";
        exit;
    }

    if (!move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
        echo "<script>alert(' Upload file gagal!'); history.back();</script>";
        exit;
    }

    $bukti = $file_name;

    // ✅ Simpan ke database
    $query = "INSERT INTO laporan 
        (nama_pelapor, email_pelapor, nama_terlapor, npm_terlapor, jurusan, prodi, alasan, detail_laporan, bukti, pernyataan) 
        VALUES 
        ('$nama_pelapor','$email_pelapor','$nama_terlapor','$npm_terlapor','$jurusan','$prodi','$alasan','$detail_laporan','$bukti','$pernyataan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Laporan berhasil dikirim!'); window.location='index.php';</script>";
    } else {
        echo " Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pelaporan Mahasiswa - Polinela</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Tahoma', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100">

  <!-- FORM CARD -->
  <div class="flex justify-center items-start min-h-screen p-6 pt-24"> 
    <!-- ✅ ubah items-center → items-start, tambahkan pt-24 untuk jarak dari navbar -->
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-2xl mt-4">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Pelaporan Mahasiswa</h2>
      <p class="text-center text-sm text-gray-500 mb-6">
        Laporkan mahasiswa <span class="text-blue-600 font-medium">yang tidak layak menerima KIP-Kuliah</span>.
      </p>

      <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Nama Pelapor</label>
          <input type="text" name="nama_pelapor" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Email Pelapor</label>
          <input type="email" name="email_pelapor" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Nama Mahasiswa yang Dilaporkan</label>
          <input type="text" name="nama_terlapor" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">NPM Mahasiswa</label>
          <input type="text" name="npm_terlapor" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700 font-medium mb-1">Jurusan</label>
            <input type="text" name="jurusan" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Program Studi</label>
            <input type="text" name="prodi" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Alasan Laporan</label>
          <input type="text" name="alasan" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Detail Laporan</label>
          <textarea name="detail_laporan" required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Bukti Pendukung (WAJIB)</label>
          <input type="file" name="bukti" required class="w-full border px-3 py-2 rounded-lg">
          <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF, DOC, DOCX (Maks. 5MB)</p>
        </div>

        <div class="flex items-center">
          <input type="checkbox" name="pernyataan" value="1" required class="h-4 w-4 text-blue-600 border-gray-300 rounded mr-2">
          <span class="text-sm text-gray-700">Saya menyatakan bahwa informasi ini benar dan dapat dipertanggungjawabkan</span>
        </div>

        <div class="flex justify-between">
          <button type="reset" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg shadow">Reset</button>
          <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-700 hover:opacity-90 text-white px-5 py-2 rounded-lg shadow">Kirim Laporan</button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
