<?php
session_start();
include "../koneksi.php";

// hanya level 12 dan 13 yang boleh
if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['12', '13'])) {
    die("Akses ditolak!");
}


// verifikasi semua data evaluasi
mysqli_query($koneksi, "UPDATE evaluasi SET status_verifikasi='Diterima'");

// kembali ke halaman list
header("Location: evaluasi_list.php?all_verified=1");
exit;
?>
