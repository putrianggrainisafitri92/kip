<?php
if (!isset($_SESSION)) {
    session_start();
}

function requireLogin() {
    if (!isset($_SESSION['id_admin'])) {
        header("Location: ../login.php");
        exit;
    }
}

function getAdmin() {
    return [
        'id_admin' => $_SESSION['id_admin'],
        'nama_lengkap' => $_SESSION['nama_lengkap'],
        'role' => $_SESSION['role']
    ];
}
