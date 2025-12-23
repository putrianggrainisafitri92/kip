<?php
session_start();
if($_SESSION['level'] != '11') die("Akses ditolak!");

include "../koneksi.php";

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil file_path dulu agar bisa dihapus dari server
    $stmt = $koneksi->prepare("SELECT file_path FROM pedoman WHERE id_pedoman=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if($result && !empty($result['file_path']) && file_exists("../".$result['file_path'])) {
        unlink("../".$result['file_path']); // hapus file fisik
    }

    // Hapus record dari database
    $stmt = $koneksi->prepare("DELETE FROM pedoman WHERE id_pedoman=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Pindahkan header di luar blok if agar selalu dijalankan
header("Location: pedoman_list.php");
exit;
?>
