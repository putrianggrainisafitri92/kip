<?php
require_once __DIR__ . '/../config/auth.php';
requireLogin();
require_once __DIR__ . '/../../koneksi.php';

$admin = getAdmin();
$id = $_GET['id'] ?? 0;

// ambil berita
$stmt = $koneksi->prepare("SELECT * FROM berita WHERE id_berita=? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) die("Berita tidak ditemukan!");

// validasi hak akses
if ($data['id_admin'] != $admin['id_admin'] && $admin['role'] !== 'superadmin') {
    die("Anda tidak boleh menghapus berita ini.");
}

// hapus file gambar utama jika ada
if (!empty($data['gambar'])) {
    $file_path = __DIR__ . '/../../' . $data['gambar'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// hapus berita dari database
$stmt = $koneksi->prepare("DELETE FROM berita WHERE id_berita=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// redirect setelah sukses hapus
header("Location: list.php?msg=deleted");
exit;
