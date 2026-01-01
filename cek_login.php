<?php
session_start();
include "koneksi.php";

$username = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if($username === '' || $password === ''){
    header("Location: index.php?error=empty");
    exit;
}

$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
if(mysqli_num_rows($query) !== 1){
    header("Location: index.php?error=user");
    exit;
}

$admin = mysqli_fetch_assoc($query);

// 🔐 INI KUNCI UTAMANYA
if(password_verify($password, $admin['password'])){

    $_SESSION['username'] = $admin['username'];
    $_SESSION['level']    = (int)$admin['level'];
    $_SESSION['login']    = true;

    if($_SESSION['level'] === 11){
        $_SESSION['role'] = "pengurus";
        header("Location: pengurus/index.php");
    } elseif($_SESSION['level'] === 12){
        $_SESSION['role'] = "admin2";
        header("Location: admin/index.php");
    } elseif($_SESSION['level'] === 13){
        $_SESSION['role'] = "kabag";
        header("Location: kabag_akademik/index.php");
    } else {
        header("Location: index.php?error=akses");
    }
    exit;

} else {
    header("Location: index.php?error=pass");
    exit;
}
