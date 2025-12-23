<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>


<?php
include '../koneksi.php';

// === PROSES UPLOAD FILE ===
if (isset($_POST['upload'])) {
    $nama_file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $folder = "../uploads/pedoman/";

    if (!is_dir($folder)) mkdir($folder, 0777, true);

    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $nama_unik = pathinfo($nama_file, PATHINFO_FILENAME) . "_" . uniqid() . "." . $ext;

    $path_server = $folder . $nama_unik;
    $path_public = "uploads/pedoman/" . $nama_unik;

    if (move_uploaded_file($tmp, $path_server)) {
        mysqli_query($koneksi, "INSERT INTO pedoman (nama_file, file_path) VALUES ('$nama_file', '$path_public')");
        header("Location: daftar_pedoman.php?success=1");
        exit;
    } else {
        header("Location: daftar_pedoman.php?error=1");
        exit;
    }
}

// === PROSES HAPUS FILE ===
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id=$id"));
    if ($data) {
        $path = "../" . $data['file_path'];
        if (file_exists($path)) unlink($path);
        mysqli_query($koneksi, "DELETE FROM pedoman WHERE id=$id");
        header("Location: daftar_pedoman.php?deleted=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pedoman KIP-Kuliah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .content {
      margin-left: 250px;
      padding: 30px;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <div class="content">
    <div class="bg-white rounded-2xl shadow-lg p-8">

      <!-- Header -->
      <section class="text-center py-10 text-white bg-blue-900 rounded-2xl shadow-md mb-10">
        <h1 class="text-3xl font-extrabold">Kelola Pedoman KIP-Kuliah</h1>
      </section>

      <!-- Notifikasi -->
      <?php if (isset($_GET['success'])): ?>
        <div class="bg-green-100 text-green-700 px-5 py-3 mb-5 rounded-lg border border-green-300 font-medium">
          File berhasil diunggah!
        </div>
      <?php elseif (isset($_GET['deleted'])): ?>
        <div class="bg-red-100 text-red-700 px-5 py-3 mb-5 rounded-lg border border-red-300 font-medium">
          🗑 File berhasil dihapus!
        </div>
      <?php elseif (isset($_GET['error'])): ?>
        <div class="bg-yellow-100 text-yellow-700 px-5 py-3 mb-5 rounded-lg border border-yellow-300 font-medium">
          ⚠ Gagal mengunggah file!
        </div>
      <?php endif; ?>

      <!-- Form Upload -->
      <form action="" method="POST" enctype="multipart/form-data"
            class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl shadow-md mb-10">
        <label class="block text-lg font-semibold text-gray-700 mb-2">Upload File Pedoman (PDF)</label>
        <input type="file" name="file" accept=".pdf" required
               class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-700 focus:outline-none mb-4">
        <button type="submit" name="upload"
                class="bg-blue-900 hover:bg-blue-800 text-white px-6 py-2 rounded-lg font-semibold transition">
          Upload File
        </button>
      </form>

      <!-- Daftar File -->
      <h2 class="text-2xl font-bold text-blue-900 mb-4">📂 Daftar Pedoman</h2>

      <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-blue-900 text-white text-xs uppercase font-semibold tracking-wider">
            <tr>
              <th class="py-3 px-4 text-left w-12">#</th>
              <th class="py-3 px-4 text-left">Nama File</th>
              <th class="py-3 px-4 text-center w-56">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            <?php
            $result = mysqli_query($koneksi, "SELECT * FROM pedoman ORDER BY id DESC");
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $file_path = "../" . $row['file_path'];
                echo "<tr class='hover:bg-gray-50'>
                        <td class='py-3 px-4 text-gray-700 font-medium'>$no</td>
                        <td class='py-3 px-4 text-gray-800'>{$row['nama_file']}</td>
                        <td class='py-3 px-4 text-center space-x-2'>
                          " . (file_exists($file_path)
                            ? "<a href='{$row['file_path']}' target='_blank'
                                 class='bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs transition'>
                                 Lihat
                               </a>"
                            : "<span class='text-red-600 font-semibold text-xs'>File tidak ditemukan!</span>") . "
                          <a href='?hapus={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus file ini?\")'
                             class='bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs transition'>
                             Hapus
                          </a>
                        </td>
                      </tr>";
                $no++;
              }
            } else {
              echo "<tr><td colspan='3' class='text-center py-5 text-gray-500 italic'>Belum ada file pedoman diupload.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
