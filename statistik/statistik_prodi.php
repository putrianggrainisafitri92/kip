<?php
include('../koneksi.php');

$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 0;
if (!$tahun) {
    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}

$stmt = $koneksi->prepare("
    SELECT nama_sk, file_path
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

    // ✅ AMBIL NAMA FILE SAJA
    $namaFile = basename($row['file_path']);

    // 🔥 URL FINAL → uploads/sk
    $file_url = 'https://sisteminformasikipk.online/uploads/sk/' . $namaFile;

    $list[] = [
        'nama_sk'  => $row['nama_sk'],
        'file_url' => $file_url
    ];
}

header('Content-Type: application/json');
echo json_encode($list);
