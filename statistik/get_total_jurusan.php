<?php
include('../koneksi.php');

$jurusan = $_GET['jurusan'] ?? '';
$status  = $_GET['status'] ?? 'approved';

if(!$jurusan){
    echo json_encode(['total' => 0]);
    exit;
}

$stmt = $koneksi->prepare("SELECT COUNT(*) AS total FROM mahasiswa_kip WHERE status=? AND jurusan=?");
$stmt->bind_param("ss", $status, $jurusan);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode(['total' => $result['total']]);
?>
