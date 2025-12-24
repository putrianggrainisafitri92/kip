<?php
include 'koneksi.php';

$username     = $_POST['username'] ?? '';
$new_password = $_POST['new_password'] ?? '';

if($username=='' || $new_password==''){
    header("Location: index.php?reset_error=empty");
    exit;
}

// cek username admin
$q = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
if(mysqli_num_rows($q)==0){
    header("Location: index.php?reset_error=user");
    exit;
}

// update password (TANPA HASH sesuai permintaan)
mysqli_query($koneksi, "
  UPDATE admin 
  SET password='$new_password' 
  WHERE username='$username'
");

header("Location: index.php?reset_success=1");
exit;
