<?php
// sidebar.php
// pastikan session sudah start di file yang meng-include sidebar
?>
<div class="bg-blue-900 text-white w-64 h-screen fixed left-0 top-0 shadow-lg">
    <div class="p-6 text-center border-b border-blue-700">
        <h2 class="text-xl font-bold">FORMABAN</h2>
        <p class="text-sm"><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Nama Pengguna'); ?></p>
    </div>

    <ul class="mt-4 space-y-1">
        <li><a href="dashboard.php" class="block px-6 py-3 hover:bg-blue-700 transition">Dashboard</a></li>
        <li><a href="berita/list.php" class="block px-6 py-3 hover:bg-blue-700 transition">Kelola Berita</a></li>
        <li><a href="pedoman/pedoman.php" class="block px-6 py-3 hover:bg-blue-700 transition">Kelola Pedoman</a></li>
        <li><a href="../logout.php" class="block px-6 py-3 hover:bg-red-700 transition">Logout</a></li>
    </ul>
</div>
