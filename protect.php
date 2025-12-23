<?php
// ===============================
// protect.php - Proteksi halaman
// ===============================

// Mulai session jika belum ada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../index.php");
    exit;
}

// Fungsi untuk mengecek level akses
function check_level($required_level)
{
    // Pastikan level user ada di session
    if (!isset($_SESSION['level'])) {
        header("Location: ../index.php");
        exit;
    }

    $user_level = $_SESSION['level'];

    // Jika level user tidak sesuai, redirect ke login / blokir akses
    if ($user_level !== $required_level) {
        header("Location: ../index.php");
        exit;
    }
}
?>
