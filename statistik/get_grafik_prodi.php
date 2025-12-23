<?php
include('../koneksi.php');

if(!isset($_GET['prodi']) || empty(trim($_GET['prodi']))) {
    echo json_encode([
        "labels" => [],
        "data" => [],
        "prodi" => ""
    ]);
    exit;
}

$prodi = trim($_GET['prodi']);
$status = $_GET['status'] ?? 'approved'; // default approved

// Prepared statement untuk keamanan
$stmt = $koneksi->prepare("
    SELECT tahun, COUNT(*) AS jumlah
    FROM mahasiswa_kip
    WHERE status = ? AND UPPER(program_studi) = UPPER(?)
    GROUP BY tahun
    ORDER BY tahun ASC
");
$stmt->bind_param("ss", $status, $prodi);
$stmt->execute();
$result = $stmt->get_result();

$tahun = [];
$jumlah = [];
while($row = $result->fetch_assoc()){
    $tahun[] = $row['tahun'];
    $jumlah[] = (int)$row['jumlah'];
}

$stmt->close();

echo json_encode([
    "labels" => $tahun,
    "data" => $jumlah,
    "prodi" => $prodi
]);
?>
