<?php
include('../koneksi.php');

$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 0;
if (!$tahun) {
    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}

$stmt = $koneksi->prepare("
    SELECT nama_sk, file_url
    FROM sk_kipk
    WHERE tahun = ?
      AND status = 'approved'
    ORDER BY id_sk_kipk ASC
");
$stmt->bind_param("i", $tahun);
$stmt->execute();
$result = $stmt->get_result();

$list = [];
while ($row = $result->fetch_assoc()) {
    $list[] = [
        'nama_sk'  => $row['nama_sk'],
        'file_url' => $row['file_url'] // ✅ AMBIL LANGSUNG DARI DB
    ];
}

header('Content-Type: application/json');
echo json_encode($list);
