<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'formaban') {
    header("Location: ../login.php");
    exit;
}
?>
