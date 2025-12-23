<?php
include '../../koneksi.php';
include '../sidebar.php'; // opsional jika mau tetap di admin panel

// Pastikan ada id
if(!isset($_GET['id']) || empty($_GET['id'])){
    echo "<script>alert('ID tidak ditemukan!'); window.location='lihat_data_sk.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data file dulu supaya bisa dihapus
$result = $koneksi->query("SELECT file_path FROM sk_kipk WHERE id = $id");
if($result->num_rows == 0){
    echo "<script>alert('Data SK tidak ditemukan!'); window.location='lihat_data_sk.php';</script>";
    exit;
}

$row = $result->fetch_assoc();
$file_path = $row['file_path'];

// Hapus data dari database
$delete = $koneksi->query("DELETE FROM sk_kipk WHERE id = $id");

if($delete){
    // Hapus file fisik jika ada
    if(file_exists($file_path)){
        unlink($file_path);
    }
    echo "<script>alert('Data SK berhasil dihapus!'); window.location='lihat_data_sk.php';</script>";
}else{
    echo "<script>alert('Gagal menghapus data SK!'); window.location='lihat_data_sk.php';</script>";
}
?>
