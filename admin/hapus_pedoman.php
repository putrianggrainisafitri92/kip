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
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id='$id'"));

if (file_exists($data['file_path'])) {
    unlink($data['file_path']);
}
mysqli_query($koneksi, "DELETE FROM pedoman WHERE id='$id'");

header("Location: pedoman_upload.php");
exit;
?>