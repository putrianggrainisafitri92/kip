<?php
include '../protect.php';
check_level(13);
include '../koneksi.php';

$id = intval($_POST['id'] ?? $_GET['id']);
$status = $_POST['status'] ?? $_GET['s'];
$catatan = $_POST['catatan'] ?? '';

if($status == "approved") {
    mysqli_query($koneksi,
        "UPDATE berita SET status='approved', catatan_revisi='' WHERE id_berita=$id"
    );
}

if($status == "rejected") {
    mysqli_query($koneksi,
        "UPDATE berita SET status='rejected', catatan_revisi='$catatan'
        WHERE id_berita=$id"
    );
}

echo "<script>alert('Status berhasil diperbarui'); window.location='validasi_berita.php';</script>";
