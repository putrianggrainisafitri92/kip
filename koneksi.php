<?php
$host = "localhost";
$user = "root";      // ganti kalau MySQL kamu ada username lain
$pass = "";          // ganti kalau ada password
$db   = "kipweb";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
