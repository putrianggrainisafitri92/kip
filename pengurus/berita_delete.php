<?php
session_start();
if($_SESSION['level'] != '11') die("Akses ditolak!");
include "../koneksi.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM berita WHERE id=$id");

header("location:berita_list.php");
