<?php
include "../auth_formaban.php";
include "../../koneksi.php";

if (!isset($_GET['id'])) { header("Location: pedoman.php"); exit; }
$id = intval($_GET['id']);

$row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id_pedoman = $id LIMIT 1"));
if (!$row) { header("Location: pedoman.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_file = mysqli_real_escape_string($koneksi, $_POST['nama_file']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    // jika upload file baru
    if (!empty($_FILES['file']['name'])) {
        $namaFile = time() . '_' . basename($_FILES['file']['name']);
        $targetDir = '../../uploads/pedoman/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $targetFile = $targetDir . $namaFile;

        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $allowed = ['pdf','doc','docx','ppt','pptx'];
        if (!in_array($ext, $allowed)) { echo "<script>alert('Format file tidak valid!'); history.back();</script>"; exit; }
        if ($_FILES['file']['size'] > 10*1024*1024) { echo "<script>alert('Ukuran maksimal 10MB!'); history.back();</script>"; exit; }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            if (!empty($row['file_path']) && file_exists('../../' . $row['file_path'])) @unlink('../../' . $row['file_path']);
            $file_path = "uploads/pedoman/" . $namaFile;
            mysqli_query($koneksi, "UPDATE pedoman SET nama_file='{$nama_file}', file_path='{$file_path}', status='{$status}' WHERE id_pedoman = $id");
            echo "<script>alert('Pedoman berhasil diperbarui!'); window.location='pedoman.php';</script>"; exit;
        } else { echo "<script>alert('Upload gagal!'); history.back();</script>"; exit; }
    } else {
        mysqli_query($koneksi, "UPDATE pedoman SET nama_file='".mysqli_real_escape_string($koneksi,$nama_file)."', status='".mysqli_real_escape_string($koneksi,$status)."' WHERE id_pedoman = $id");
        echo "<script>alert('Pedoman berhasil diperbarui!'); window.location='pedoman.php';</script>"; exit;
    }
}
?>
<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><title>Edit Pedoman</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex">
<?php include "../sidebar.php"; ?>
<div class="flex-1 p-10 ml-64">
  <div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-lg border">
    <h2 class="text-2xl font-bold mb-6 text-blue-800">Edit Pedoman</h2>
    <form method="POST" enctype="multipart/form-data" class="space-y-5">
      <div><label class="block">Nama File</label><input name="nama_file" value="<?= htmlspecialchars($row['nama_file']); ?>" required class="w-full p-3 border rounded"></div>
      <div>
        <label class="block">File Saat Ini</label>
        <?php if(!empty($row['file_path']) && file_exists('../../'.$row['file_path'])): ?>
            <a href="../../<?= htmlspecialchars($row['file_path']); ?>" target="_blank" class="text-blue-600">Lihat file</a>
        <?php else: ?>
            <p class="text-sm text-gray-500">Tidak ada file.</p>
        <?php endif; ?>
      </div>
      <div><label class="block">Ganti File (opsional)</label><input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" class="w-full"></div>
      <div>
        <label class="block">Status</label>
        <select name="status" class="w-full p-2 border rounded">
          <option value="pending" <?= $row['status']==='pending' ? 'selected':''; ?>>Pending</option>
          <option value="approved" <?= $row['status']==='approved' ? 'selected':''; ?>>Approved</option>
          <option value="rejected" <?= $row['status']==='rejected' ? 'selected':''; ?>>Rejected</option>
        </select>
      </div>
      <button class="w-full bg-blue-800 text-white py-3 rounded">Simpan</button>
    </form>
  </div>
</div>
</body>
</html>
