<?php
include '../protect.php';
check_level(13); // hanya admin3
include '../koneksi.php';

// Pastikan ada id
if (!isset($_GET['id'])) {
    echo "<script>alert('ID user tidak ditemukan'); location='crud_user.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Cek user ada
$stmt = $koneksi->prepare("SELECT * FROM admin WHERE id_admin = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "<script>alert('User tidak ditemukan'); location='crud_user.php';</script>";
    exit;
}

// Hapus user
$stmt = $koneksi->prepare("DELETE FROM admin WHERE id_admin = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "<script>alert('User berhasil dihapus'); location='crud_user.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus user'); location='crud_user.php';</script>";
}
$stmt->close();
