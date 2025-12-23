<?php
include "../auth_formaban.php";
include "../../koneksi.php";

if (!isset($_GET['id'])) { header("Location: list.php"); exit; }
$id = intval($_GET['id']);

// ambil gambar untuk dihapus dari filesystem
$res = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id_berita = '$id' LIMIT 1");
$row = mysqli_fetch_assoc($res);
if ($row && !empty($row['gambar'])) {
    $path = "../../uploads/berita/" . $row['gambar'];
    if (file_exists($path)) @unlink($path);
}

mysqli_query($koneksi, "DELETE FROM berita WHERE id_berita = '$id'");
header("Location: list.php");
exit;
