<?php
include "../koneksi.php";

session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != '13') {
    die("Akses ditolak!");
}

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

if (empty($id)) {
    die("ID missing");
}

if ($act == 'approve') {
    $sql = "UPDATE pedoman_tahapan SET status='approved', catatan_revisi=NULL WHERE id='$id'";
    mysqli_query($koneksi, $sql);
    echo "<script>alert('Item disetujui!'); window.location='validasi_tahapan_pedoman.php';</script>";
} elseif ($act == 'reject') {
    $catatan = isset($_POST['catatan']) ? mysqli_real_escape_string($koneksi, $_POST['catatan']) : '';
    $sql = "UPDATE pedoman_tahapan SET status='rejected', catatan_revisi='$catatan' WHERE id='$id'";
    mysqli_query($koneksi, $sql);
    echo "<script>alert('Item ditolak dengan catatan!'); window.location='validasi_tahapan_pedoman.php';</script>";
}
?>
