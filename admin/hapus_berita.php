<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include '../koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id'");
echo "<script>alert('Berita berhasil dihapus!'); window.location='manajemen_berita.php';</script>";
?>
