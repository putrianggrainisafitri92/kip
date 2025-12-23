<?php
include "../auth_formaban.php";
include "../../koneksi.php";

$id_admin = intval($_SESSION['id_admin']);

// jika ingin hanya menampilkan pedoman milik admin ini, uncomment baris bawah:
// $query = mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id_admin='$id_admin' ORDER BY id_pedoman DESC");

$query = mysqli_query($koneksi, "SELECT * FROM pedoman ORDER BY id_pedoman DESC");

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id_pedoman = $id LIMIT 1"));
    if ($data) {
        $path = "../../" . $data['file_path'];
        if (file_exists($path)) @unlink($path);
        mysqli_query($koneksi, "DELETE FROM pedoman WHERE id_pedoman = $id");
        echo "<script>alert('Pedoman berhasil dihapus!'); window.location='pedoman.php';</script>";
        exit;
    }
}
?>
<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><title>Kelola Pedoman</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex">
<?php include "../sidebar.php"; ?>
<div class="flex-1 p-10 ml-64">
  <div class="bg-white p-8 rounded-xl shadow-lg border">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-blue-800">Kelola Pedoman</h1>
      <a href="upload_pedoman.php" class="bg-blue-700 text-white px-4 py-2 rounded">+ Upload Pedoman</a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-300 rounded-lg">
        <thead class="bg-blue-900 text-white">
          <tr>
            <th class="py-3 px-4">No</th>
            <th class="py-3 px-4">Nama File</th>
            <th class="py-3 px-4 text-center">Status</th>
            <th class="py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white text-gray-700">
          <?php
          $no = 1;
          if ($query && mysqli_num_rows($query) > 0) {
              while ($row = mysqli_fetch_assoc($query)) {
                  $status = $row['status'] ?? 'pending';
                  $statusClass = $status === 'approved' ? 'text-green-600' : ($status === 'rejected' ? 'text-red-600' : 'text-yellow-600');
                  echo "<tr class='border-b hover:bg-gray-50'>
                      <td class='py-3 px-4'>{$no}</td>
                      <td class='py-3 px-4'>".htmlspecialchars($row['nama_file'])."</td>
                      <td class='py-3 px-4 text-center {$statusClass}'>".ucfirst($status)."</td>
                      <td class='py-3 px-4 text-center'>
                          <a href='../../".htmlspecialchars($row['file_path'])."' target='_blank' class='bg-green-600 text-white px-3 py-1 rounded text-xs'>Lihat</a>
                          <a href='pedoman_edit.php?id={$row['id_pedoman']}' class='bg-yellow-500 text-white px-3 py-1 rounded text-xs'>Edit</a>
                          <a href='?hapus={$row['id_pedoman']}' onclick='return confirm(\"Hapus pedoman ini?\")' class='bg-red-600 text-white px-3 py-1 rounded text-xs'>Hapus</a>
                      </td>
                  </tr>";
                  $no++;
              }
          } else {
              echo "<tr><td colspan='4' class='py-5 text-center text-gray-500 italic'>Belum ada pedoman ditambahkan.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
