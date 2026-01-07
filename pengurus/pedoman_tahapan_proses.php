<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $kategori = $_POST['kategori'];
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $urutan = (int)$_POST['urutan'];

    if (!empty($id)) {
        // Update - set status to pending again if edited
        $sql = "UPDATE pedoman_tahapan SET judul='$judul', deskripsi='$deskripsi', urutan='$urutan', status='pending', catatan_revisi=NULL WHERE id='$id'";
    } else {
        // Insert - default status is pending
        $sql = "INSERT INTO pedoman_tahapan (kategori, judul, deskripsi, urutan, status, catatan_revisi) VALUES ('$kategori', '$judul', '$deskripsi', '$urutan', 'pending', NULL)";
    }

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data berhasil disimpan'); window.location='pedoman_tahapan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
