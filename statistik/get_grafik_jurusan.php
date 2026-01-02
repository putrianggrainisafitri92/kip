<?php
include('../koneksi.php');
header('Content-Type: application/json');

$jurusan = isset($_GET['jurusan']) ? trim($_GET['jurusan']) : '';
$status  = $_GET['status'] ?? 'approved';

// Tahun range tetap 2021–2025
$tahun_range = range(2021, 2025);
$data_tahun  = array_fill_keys($tahun_range, 0);

if($jurusan){
    $stmt = $koneksi->prepare("
        SELECT tahun, COUNT(*) AS jumlah
        FROM mahasiswa_kip
        WHERE status = ? 
          AND UPPER(jurusan) LIKE CONCAT('%', UPPER(?), '%')
        GROUP BY tahun
        ORDER BY tahun ASC
    ");
    $stmt->bind_param("ss", $status, $jurusan);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $thn = (int)$row['tahun'];
        if(isset($data_tahun[$thn])) {
            $data_tahun[$thn] = (int)$row['jumlah'];
        }
    }
    $stmt->close();
}

echo json_encode([
    "error"   => false,
    "jurusan" => $jurusan,
    "tahun"   => array_map('strval', array_keys($data_tahun)),
    "jumlah"  => array_values($data_tahun)
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$koneksi->close();
