<?php
session_start();
include "../koneksi.php";

// hanya level 12 dan 13
if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['12', '13'])) {
    die("Akses ditolak!");
}

// ambil semua file evaluasi
$q = mysqli_query($koneksi, 
    "SELECT fe.file_eval
     FROM file_eval fe
     JOIN evaluasi e ON fe.id_mahasiswa_kip = e.id_mahasiswa_kip"
);

$basePath = $_SERVER['DOCUMENT_ROOT'] . "/KIPWEB/uploads/evaluasi/";

// hapus file fisik
while ($f = mysqli_fetch_assoc($q)) {
    if (!empty($f['file_eval'])) {
        $fullPath = $basePath . $f['file_eval'];
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}

// hapus data database
mysqli_query($koneksi, "DELETE FROM evaluasi");
mysqli_query($koneksi, "DELETE FROM file_eval");
mysqli_query($koneksi, "DELETE FROM keluarga");
mysqli_query($koneksi, "DELETE FROM transportasi");

header("Location: lihat_evaluasi.php?all_deleted=1");
exit;
?>
