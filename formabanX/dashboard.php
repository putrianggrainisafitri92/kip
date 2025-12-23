<?php
include "auth_formaban.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard Formaban</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<?php include "sidebar.php"; ?>

<div class="ml-64 p-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard Formaban</h1>
            <a class="bg-red-600 text-white px-3 py-1 rounded" href="../logout.php">Logout</a>
        </div>

        <div class="grid grid-cols-3 gap-6 mt-6">
            <div class="p-6 bg-white rounded shadow text-center">
                <i class="fa fa-newspaper text-3xl text-blue-700"></i>
                <h3 class="mt-3 font-semibold">Kelola Berita</h3>
                <p class="text-sm text-gray-500">Tambah, edit, hapus berita</p>
                <a class="mt-4 inline-block text-sm text-blue-600" href="berita/list.php">Buka</a>
            </div>

            <div class="p-6 bg-white rounded shadow text-center">
                <i class="fa fa-file text-3xl text-blue-700"></i>
                <h3 class="mt-3 font-semibold">Kelola Pedoman</h3>
                <p class="text-sm text-gray-500">Upload & kelola pedoman</p>
                <a class="mt-4 inline-block text-sm text-blue-600" href="pedoman/pedoman.php">Buka</a>
            </div>

            <div class="p-6 bg-white rounded shadow text-center">
                <i class="fa fa-envelope text-3xl text-blue-700"></i>
                <h3 class="mt-3 font-semibold">Pelaporan</h3>
                <p class="text-sm text-gray-500">Lihat & proses laporan</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
