<?php
session_start();
include "../koneksi.php";

// hanya level 12 dan 13 yang boleh
if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['12', '13'])) {
    die("Akses ditolak!");
}


// Ambil semua file untuk dihapus
$q = mysqli_query($koneksi, 
    "SELECT fe.file_eval, fe.file_revisi1, fe.file_revisi2
     FROM file_eval fe
     JOIN evaluasi e ON fe.id_mahasiswa_kip = e.id_mahasiswa_kip"
);


$basePath = $_SERVER['DOCUMENT_ROOT'] . "/KIPWEB/uploads/evaluasi/";

// hapus file satu-satu
while ($f = mysqli_fetch_assoc($q)) {
   $files = [
    $f['file_eval'],
    $f['file_revisi1'],
    $f['file_revisi2']
];

    foreach ($files as $file) {
        if (!empty($file)) {
            $fullPath = $basePath . $file;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}

// hapus semua data evaluasi
mysqli_query($koneksi, "DELETE FROM evaluasi");
mysqli_query($koneksi, "DELETE FROM file_eval");
mysqli_query($koneksi, "DELETE FROM keluarga");
mysqli_query($koneksi, "DELETE FROM transportasi");
header("Location: evaluasi_list.php?all_deleted=1");
exit;
?>
