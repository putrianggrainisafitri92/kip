<?php
session_start();
include "koneksi.php";

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");

if(mysqli_num_rows($query) === 1){

    $admin = mysqli_fetch_assoc($query);

    if($password === $admin['password']){

        $_SESSION['username'] = $admin['username'];
        $_SESSION['level']    = (int)$admin['level'];
        $_SESSION['login']    = true;

        if($_SESSION['level'] === 11){
            $_SESSION['role'] = "pengurus";
            header("Location: pengurus/index.php");
            exit;
        } elseif($_SESSION['level'] === 12){
            $_SESSION['role'] = "admin2";
            header("Location: admin/index.php");
            exit;
        } elseif($_SESSION['level'] === 13){
            $_SESSION['role'] = "kabag";
            header("Location: kabag_akademik/index.php");
            exit;
        } else {
            header("Location: index.php?error=akses");
            exit;
        }

    } else {
        // PASSWORD SALAH
        header("Location: index.php?error=pass");
        exit;
    }

} else {
    // USERNAME TIDAK ADA
    header("Location: index.php?error=user");
    exit;
}
?>
