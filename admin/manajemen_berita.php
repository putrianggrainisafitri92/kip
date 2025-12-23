<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include '../koneksi.php';
include 'sidebar.php';
$berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Berita</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f6fb]">



  <!-- Konten utama -->
  <div class="ml-[250px] p-10">
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
      <h2 class="text-2xl font-bold mb-6 text-blue-700 flex items-center">
        📰 <span class="ml-2">Manajemen Berita</span>
      </h2>

      <div class="text-right mb-5">
        <a href="tambah_berita.php"
           class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white px-5 py-2 rounded-lg shadow hover:opacity-90 transition">
          + Tambah Berita
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
          <thead>
            <tr class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white text-left">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Judul</th>
              <th class="py-3 px-4">Gambar</th>
              <th class="py-3 px-4">Tanggal</th>
              <th class="py-3 px-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php while ($b = mysqli_fetch_assoc($berita)) : ?>
              <tr class="hover:bg-blue-50">
                <td class="py-3 px-4"><?= $b['id'] ?></td>
                <td class="py-3 px-4 font-medium"><?= htmlspecialchars($b['judul']) ?></td>
                <td class="py-3 px-4">
                  <?php if ($b['gambar']) : ?>
                    <img src="../uploads/berita/<?= $b['gambar'] ?>" alt="Gambar" class="w-16 h-16 object-cover rounded-md">
                  <?php else : ?>
                    <span class="text-gray-400 italic">Tidak ada</span>
                  <?php endif; ?>
                </td>
                <td class="py-3 px-4 text-gray-600"><?= $b['tanggal'] ?? '-' ?></td>
                <td class="py-3 px-4 text-center">
                  <a href="edit_berita.php?id=<?= $b['id'] ?>"
                     class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition">Edit</a>
                  <a href="hapus_berita.php?id=<?= $b['id'] ?>"
                     onclick="return confirm('Yakin ingin menghapus berita ini?')"
                     class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700 ml-2 transition">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>
