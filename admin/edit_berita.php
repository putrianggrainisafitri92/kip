<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id'"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judul = $_POST['judul'];
  $isi = $_POST['isi'];
  $gambar = $data['gambar'];

  if (!empty($_FILES['gambar']['name'])) {
    $namaFile = time() . '_' . basename($_FILES['gambar']['name']);
    $targetDir = '../uploads/berita/';
    $targetFile = $targetDir . $namaFile;

    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
      $gambar = $namaFile;
    }
  }

  mysqli_query($koneksi, "UPDATE berita SET judul='$judul', isi='$isi', gambar='$gambar' WHERE id='$id'");
  echo "<script>alert('Berita berhasil diupdate!'); window.location='manajemen_berita.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Berita</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-purple-700">Edit Berita</h2>
    <form method="POST" enctype="multipart/form-data" class="space-y-5">
      <div>
        <label class="block font-semibold mb-2">Judul Berita</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required class="w-full border border-gray-300 p-3 rounded-lg">
      </div>
      <div>
        <label class="block font-semibold mb-2">Isi Berita</label>
        <textarea name="isi" rows="5" required class="w-full border border-gray-300 p-3 rounded-lg"><?= htmlspecialchars($data['isi']) ?></textarea>
      </div>
      <div>
        <label class="block font-semibold mb-2">Gambar </label>
        <?php if ($data['gambar']): ?>
          <img src="../uploads/berita/<?= $data['gambar'] ?>" class="w-32 h-32 object-cover rounded-md mb-2">
        <?php endif; ?>
        <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 p-3 rounded-lg">
      </div>
      <button type="submit" class="w-full bg-purple-700 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition">
        Update
      </button>
    </form>
  </div>
</body>
</html>
