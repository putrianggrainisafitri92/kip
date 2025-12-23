<?php
include '../protect.php';
check_level(13); // Admin3
include '../koneksi.php';

if(isset($_GET['skema'], $_GET['tahun'], $_GET['status'])){
    $skema = trim($_GET['skema']);
    $tahun = intval($_GET['tahun']);
    $status = $_GET['status'];
    $approved_by = $_SESSION['id_admin'];

    // Ambil catatan revisi jika ada
    $catatan = isset($_GET['catatan']) ? trim($_GET['catatan']) : null;

    if(in_array($status, ['approved','rejected'])){

        if($status == 'rejected'){
            // UPDATE REJECT *TANPA BATAS STATUS*
            $stmt = $koneksi->prepare("
                UPDATE mahasiswa_kip 
                SET status=?, id_admin=?, catatan_revisi=?
                WHERE TRIM(skema)=? AND tahun=?
            ");
            $stmt->bind_param("sissi", $status, $approved_by, $catatan, $skema, $tahun);

        } else {
            // UPDATE APPROVED *TANPA BATAS STATUS*
            $stmt = $koneksi->prepare("
                UPDATE mahasiswa_kip 
                SET status=?, id_admin=?, catatan_revisi=NULL
                WHERE TRIM(skema)=? AND tahun=?
            ");
            $stmt->bind_param("sisi", $status, $approved_by, $skema, $tahun);
        }

        $stmt->execute();
    }
}

header("Location: validasi_kip.php");
exit;
