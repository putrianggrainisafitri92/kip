<?php
include('../koneksi.php');
header('Content-Type: application/json');

// --- Ambil parameter jurusan (opsional) ---
$jurusan = isset($_GET['jurusan']) && trim($_GET['jurusan']) !== '' ? trim($_GET['jurusan']) : null;

// --- Query jumlah mahasiswa per tahun (approved) ---
if ($jurusan) {
    $stmt = $koneksi->prepare("
        SELECT tahun, COUNT(*) AS jumlah
        FROM mahasiswa_kip
        WHERE status='approved' AND jurusan = ?
        GROUP BY tahun
        ORDER BY tahun ASC
    ");
    $stmt->bind_param("s", $jurusan);
} else {
    $stmt = $koneksi->prepare("
        SELECT tahun, COUNT(*) AS jumlah
        FROM mahasiswa_kip
        WHERE status='approved'
        GROUP BY tahun
        ORDER BY tahun ASC
    ");
}

$stmt->execute();
$result = $stmt->get_result();

// --- Range tahun tetap 2021–2025 ---
$tahun_range = range(2021, 2025);
$data_tahun = array_fill_keys($tahun_range, 0);
$total_mahasiswa = 0;

while ($row = $result->fetch_assoc()) {
    $thn = (int)$row['tahun'];
    if (isset($data_tahun[$thn])) {
        $data_tahun[$thn] = (int)$row['jumlah'];
        $total_mahasiswa += (int)$row['jumlah'];
    }
}

// --- Ambil daftar jurusan (approved) ---
$jurusan_list = [];
$jurusanQuery = $koneksi->query("SELECT DISTINCT jurusan FROM mahasiswa_kip WHERE status='approved' ORDER BY jurusan ASC");
if ($jurusanQuery && $jurusanQuery->num_rows > 0) {
    while ($r = $jurusanQuery->fetch_assoc()) {
        $jurusan_list[] = $r['jurusan'];
    }
}

// --- Ambil daftar prodi jika jurusan dipilih ---
$prodi_list = [];
if ($jurusan) {
    $prodiStmt = $koneksi->prepare("
        SELECT DISTINCT program_studi
        FROM mahasiswa_kip
        WHERE status='approved' AND jurusan = ?
        ORDER BY program_studi ASC
    ");
    $prodiStmt->bind_param("s", $jurusan);
    $prodiStmt->execute();
    $prodiRes = $prodiStmt->get_result();
    if ($prodiRes && $prodiRes->num_rows > 0) {
        while ($row = $prodiRes->fetch_assoc()) {
            $prodi_list[] = $row['program_studi'];
        }
    }
}

// --- Kirim JSON ---
echo json_encode([
    'error' => false,
    'message' => $jurusan
        ? "Data jurusan '$jurusan' berhasil diambil."
        : "Data seluruh jurusan berhasil diambil.",
    'labels' => array_keys($data_tahun),    // Tahun 2021–2025
    'data' => array_values($data_tahun),    // Jumlah per tahun
    'total' => $total_mahasiswa,            // Total mahasiswa keseluruhan
    'jurusan' => $jurusan_list,             // Dropdown jurusan
    'prodi' => $prodi_list                   // Dropdown prodi jika jurusan ada
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// --- Tutup statement & koneksi ---
$stmt->close();
if (isset($prodiStmt) && $prodiStmt instanceof mysqli_stmt) {
    $prodiStmt->close();
}
$koneksi->close();
?>
