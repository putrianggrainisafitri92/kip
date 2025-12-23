<?php
include '../koneksi.php';
include '../protect.php';
check_level(13);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = strtolower($_POST['s']); // pastikan lowercase
    $catatan = isset($_POST['catatan_revisi']) ? trim($_POST['catatan_revisi']) : null;
    $admin_id = $_SESSION['admin_id']; // ambil id admin dari session

    // Validasi status
    $valid_status = ['approved', 'rejected'];
    if(!in_array($status, $valid_status)) {
        die("Status tidak valid.");
    }

    // Jika rejected, wajib ada catatan
    if($status === 'rejected' && empty($catatan)) {
        die("Catatan revisi harus diisi saat menolak pedoman.");
    }

    // Update status & catatan, set approved_by jika approve
    if($status === 'approved') {
        $stmt = $koneksi->prepare("UPDATE pedoman SET status=?, approved_by=?, catatan_revisi=NULL, updated_at=NOW() WHERE id_pedoman=?");
        $stmt->bind_param("sii", $status, $admin_id, $id); // "sii" -> string, int, int
    } else {
        $stmt = $koneksi->prepare("UPDATE pedoman SET status=?, catatan_revisi=?, updated_at=NOW() WHERE id_pedoman=?");
        $stmt->bind_param("ssi", $status, $catatan, $id); // "ssi" -> string, string, int
    }

    $stmt->execute();
    header("Location: validasi_pedoman.php");
    exit;
}
?>
