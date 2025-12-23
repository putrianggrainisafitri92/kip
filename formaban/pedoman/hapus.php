<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();

// Load koneksi ($koneksi)
require_once __DIR__ . '/../../koneksi.php';

$admin = getAdmin();
$id = $_GET['id'] ?? 0;

// Ambil data pedoman
$stmt = $koneksi->prepare("SELECT * FROM pedoman WHERE id_pedoman=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Data tidak ditemukan!");
}

// Validasi siapa yang boleh hapus
if ($data['id_admin'] != $admin['id_admin'] && $admin['role'] !== 'superadmin') {
    die("Anda tidak boleh menghapus pedoman ini!");
}

// Hapus file fisik
$filePath = __DIR__ . '/../../' . $data['file_path'];
if (file_exists($filePath)) {
    unlink($filePath);
}

// Hapus dari database
$stmt = $koneksi->prepare("DELETE FROM pedoman WHERE id_pedoman=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: list.php?msg=deleted");
exit;
?>
