<?php
include "../koneksi.php";

$id = $_GET['id'];
if ($id) {
    mysqli_query($koneksi, "DELETE FROM pedoman_tahapan WHERE id='$id'");
}

header("Location: pedoman_tahapan.php");
?>
