<?php
include "../auth_formaban.php";
include "../../koneksi.php";

$id_admin = intval($_SESSION['id_admin']);

$query = mysqli_query($koneksi, "SELECT * FROM berita WHERE id_admin = '$id_admin' ORDER BY id_berita DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Kelola Berita - Formaban</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

<?php include "../sidebar.php"; ?>

<div class="flex-1 p-10 ml-64">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-800">Kelola Berita</h1>
            <a href="tambah.php" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg">+ Tambah Berita</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg">
                <thead class="bg-blue-900 text-white text-sm">
                    <tr>
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Judul</th>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-gray-700 text-sm">
                    <?php
                    if ($query && mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                            $idb = intval($row['id_berita']);
                            echo "<tr class='border-b hover:bg-gray-50'>
                                <td class='py-3 px-4 font-medium'>{$no}</td>
                                <td class='py-3 px-4'>".htmlspecialchars($row['judul'])."</td>
                                <td class='py-3 px-4'>".htmlspecialchars($row['tanggal'])."</td>
                                <td class='py-3 px-4 text-center space-x-2'>
                                    <a href='edit.php?id={$idb}' class='bg-yellow-500 text-white px-3 py-1 rounded text-xs'>Edit</a>
                                    <a href='hapus.php?id={$idb}' onclick='return confirm(\"Hapus berita ini?\")' class='bg-red-600 text-white px-3 py-1 rounded text-xs'>Hapus</a>
                                </td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-5 text-gray-500 italic'>Belum ada berita yang ditambahkan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
