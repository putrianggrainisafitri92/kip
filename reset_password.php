<?php
session_start();
include "koneksi.php";

$username = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');$new_pass = mysqli_real_escape_string($koneksi, $_POST['new_password'] ?? '');
$raw_pass = $_POST['new_password'] ?? '';
$hash_pass = password_hash($raw_pass, PASSWORD_DEFAULT);


if($username == '' || $new_pass == ''){
    header("Location: index.php?reset_error=empty");
    exit;
}

// CEK USER ADMIN
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");

if(mysqli_num_rows($query) !== 1){
    header("Location: index.php?reset_error=user");
    exit;
}

$admin = mysqli_fetch_assoc($query);

// UPDATE PASSWORD
mysqli_query($koneksi, "
    UPDATE admin 
    SET password='$hash_pass'
    WHERE username='$username'
");

// ==================================
// AUTO LOGIN (TIRU CEK_LOGIN.PHP)
// ==================================
$_SESSION['username'] = $admin['username'];
$_SESSION['level']    = (int)$admin['level'];
$_SESSION['login']    = true;

// SET ROLE & REDIRECT SESUAI LEVEL
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
