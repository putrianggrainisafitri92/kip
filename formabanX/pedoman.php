<?php
include "../auth_formaban.php";
include "../../koneksi.php";

$id_admin = $_SESSION['id_admin'];

// Ambil seluruh pedoman milik formaban
$query = mysqli_query($koneksi, "SELECT * FROM pedoman ORDER BY id_pedoman DESC");

// === PROSES HAPUS PEDOMAN ===
if (isset($_GET['hapus'])) {

    $id = intval($_GET['hapus']);

    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id_pedoman=$id"));

    if ($data) {
        // Hapus file
        $path = "../../" . $data['file_path'];
        if (file_exists($path)) {
            unlink($path);
        }

        mysqli_query($koneksi, "DELETE FROM pedoman WHERE id_pedoman=$id");

        echo "<script>alert('Pedoman berhasil dihapus!'); window.location='pedoman.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pedoman - Formaban</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">

<?php include "../sidebar.php"; ?>

<div class="flex-1 p-10 ml-64">

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-800">Kelola Pedoman</h1>

            <a href="upload_pedoman.php"
               class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
               + Upload Pedoman
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-blue-900 text-white text-sm uppercase">
                    <tr>
                        <th class="py-3 px-4 text-left w-10">No</th>
                        <th class="py-3 px-4 text-left">Nama File</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white text-gray-700 text-sm">
                    <?php
                    $no = 1;

                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {

                            $statusColor = [
                                'pending'  => 'text-yellow-600 font-semibold',
                                'approved' => 'text-green-600 font-semibold',
                                'rejected' => 'text-red-600 font-semibold'
                            ];

                            echo "
                            <tr class='border-b hover:bg-gray-50'>
                                <td class='py-3 px-4 font-medium'>$no</td>
                                <td class='py-3 px-4'>{$row['nama_file']}</td>

                                <td class='py-3 px-4 text-center {$statusColor[$row['status']]}'>
                                    " . ucfirst($row['status']) . "
                                </td>

                                <td class='py-3 px-4 text-center space-x-2'>
                                    <a href='../../{$row['file_path']}' target='_blank'
                                       class='bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs'>
                                       Lihat
                                    </a>

                                    <a href='pedoman_edit.php?id={$row['id_pedoman']}'
                                       class='bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs'>
                                       Edit
                                    </a>

                                    <a href='?hapus={$row['id_pedoman']}'
                                       onclick='return confirm(\"Hapus pedoman ini?\")'
                                       class='bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs'>
                                       Hapus
                                    </a>
                                </td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "
                        <tr>
                            <td colspan='4' class='py-5 text-center text-gray-500 italic'>
                                Belum ada pedoman ditambahkan.
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
