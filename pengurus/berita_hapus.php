<?php
session_start();
if($_SESSION['level'] != '11') {
    die("Akses ditolak!");
}

include "../koneksi.php";

// Pastikan ada parameter id
if(!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID berita tidak valid.");
}

$id = intval($_GET['id']); // pastikan integer untuk keamanan

// Hapus berita dari database
$query = mysqli_query($koneksi, "DELETE FROM berita WHERE id_berita = $id");

if($query) {
    // Jika sukses, redirect ke halaman daftar berita yang benar
    header("Location: berita_list.php?pesan=hapus_sukses");
    exit;
} else {
    echo "Gagal menghapus berita. Error: " . mysqli_error($koneksi);
}
?>
