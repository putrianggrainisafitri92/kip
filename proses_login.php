<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

// COCOKKAN DENGAN TABEL admin (BUKAN user)
$q = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    header("Location: login.php?error=wrong");
    exit;
}

// simpan session
$_SESSION['id_admin'] = $data['id_admin'];
$_SESSION['username'] = $data['username'];
$_SESSION['level']    = $data['level'];

// arahkan sesuai level
switch ($data['level']) {
    case 11:
        header("Location: admin/pengurus/");
        break;
    case 12:
        header("Location: admin/admin/");
        break;
    case 13:
        header("Location: admin/kabag_akademik/");
        break;
    default:
        header("Location: login.php?error=akses");
}
exit;
?>
