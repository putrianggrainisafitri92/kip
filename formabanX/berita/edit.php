<?php
include "../auth_formaban.php";
include "../../koneksi.php";

if (!isset($_GET['id'])) { echo "<script>alert('Berita tidak ditemukan!'); window.location='list.php';</script>"; exit; }
$id = intval($_GET['id']);

$result = mysqli_query($koneksi, "SELECT * FROM berita WHERE id_berita = '$id' LIMIT 1");
$berita = mysqli_fetch_assoc($result);
if (!$berita) { echo "<script>alert('Data berita tidak ada!'); window.location='list.php';</script>"; exit; }

$gambar_lama = $berita['gambar'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi   = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $gambarBaru = $gambar_lama;

    if (!empty($_FILES['gambar']['name'])) {
        $namaFileBaru = time() . '_' . basename($_FILES['gambar']['name']);
        $targetDir = '../../uploads/berita/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $targetFile = $targetDir . $namaFileBaru;

        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) { echo "<script>alert('Format gambar tidak valid!'); history.back();</script>"; exit; }
        if ($_FILES['gambar']['size'] > 5*1024*1024) { echo "<script>alert('Ukuran gambar maksimal 5MB!'); history.back();</script>"; exit; }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            if (!empty($gambar_lama) && file_exists("../../uploads/berita/" . $gambar_lama)) {
                @unlink("../../uploads/berita/" . $gambar_lama);
            }
            $gambarBaru = $namaFileBaru;
        } else { echo "<script>alert('Upload gagal!'); history.back();</script>"; exit; }
    }

    $update = mysqli_query($koneksi, "UPDATE berita SET judul='".mysqli_real_escape_string($koneksi,$judul)."', isi='".mysqli_real_escape_string($koneksi,$isi)."', gambar='".mysqli_real_escape_string($koneksi,$gambarBaru)."' WHERE id_berita = '$id'");
    if ($update) {
        echo "<script>alert('Berita berhasil diperbarui!'); window.location='list.php';</script>";
        exit;
    } else { echo "Error: " . mysqli_error($koneksi); }
}
?>
<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><title>Edit Berita</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex">
<?php include "../sidebar.php"; ?>
<div class="flex-1 p-10 ml-64">
  <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg border">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-800">Edit Berita</h2>
    <form method="POST" enctype="multipart/form-data" class="space-y-5">
      <div><label class="block">Judul</label><input type="text" name="judul" required value="<?= htmlspecialchars($berita['judul']); ?>" class="w-full p-3 border rounded"></div>
      <div><label class="block">Isi</label><textarea name="isi" rows="5" required class="w-full p-3 border rounded"><?= htmlspecialchars($berita['isi']); ?></textarea></div>
      <div>
        <label class="block">Gambar Saat Ini</label>
        <?php if(!empty($berita['gambar']) && file_exists('../../uploads/berita/'.$berita['gambar'])): ?>
            <img src="../../uploads/berita/<?= htmlspecialchars($berita['gambar']); ?>" width="200" class="rounded mb-3">
        <?php else: ?>
            <p class="text-sm text-gray-500">Tidak ada gambar.</p>
        <?php endif; ?>
        <label class="block mt-2">Ganti Gambar (Optional)</label>
        <input type="file" name="gambar" accept="image/*" class="w-full">
        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
      </div>
      <button class="w-full bg-blue-800 text-white py-3 rounded">Simpan Perubahan</button>
    </form>
  </div>
</div>
</body>
</html>
