<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Tentukan URL login secara otomatis
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script = '/KIPWEB/index.php'; // path lengkap dari root domain ke login.php

header("Location: $protocol$host$script");
exit();
?>
