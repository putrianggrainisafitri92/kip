<?php
session_start();
if($_SESSION['level'] != '13') {
    die("Akses ditolak!");
}

include "../koneksi.php";

// Pastikan ada ID dan status
if(!isset($_POST['id'], $_POST['s'])) {
    die("Data tidak lengkap.");
}

$id = intval($_POST['id']);
$status = $_POST['s'];
$admin_id = $_SESSION['id_admin'] ?? 0; // sesuaikan dengan session admin

// Ambil data SK terlebih dahulu
$q = mysqli_query($koneksi, "SELECT * FROM sk_kipk WHERE id_sk_kipk = $id");
$d = mysqli_fetch_assoc($q);
if(!$d) die("SK tidak ditemukan.");

// Proses validasi
if($status === 'approved') {
    $update = mysqli_query($koneksi, "UPDATE sk_kipk SET status='approved', approved_by=$admin_id WHERE id_sk_kipk=$id");
    if($update) {
        header("Location: validasi_sk.php?pesan=approved");
        exit;
    } else {
        die("Gagal update status: " . mysqli_error($koneksi));
    }
} elseif($status === 'rejected') {
    $catatan = trim($_POST['catatan_revisi'] ?? '');
    if(empty($catatan)) {
        die("Catatan revisi wajib diisi jika menolak SK.");
    }
    $catatan_safe = mysqli_real_escape_string($koneksi, $catatan);
    $update = mysqli_query($koneksi, "UPDATE sk_kipk SET status='rejected', catatan_revisi='$catatan_safe', approved_by=$admin_id WHERE id_sk_kipk=$id");
    if($update) {
        header("Location: validasi_sk.php?pesan=rejected");
        exit;
    } else {
        die("Gagal update status: " . mysqli_error($koneksi));
    }
} else {
    die("Status tidak valid.");
}
?>
