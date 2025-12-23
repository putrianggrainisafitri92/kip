<?php
include('../koneksi.php'); // pastikan $koneksi tersedia
header('Content-Type: application/json');

// Ambil parameter
$jurusan = isset($_GET['jurusan']) && trim($_GET['jurusan']) !== '' ? trim($_GET['jurusan']) : null;
$prodi   = isset($_GET['prodi']) && trim($_GET['prodi']) !== '' ? trim($_GET['prodi']) : null;

// --- Query jumlah mahasiswa per tahun (approved) ---
if ($prodi) {
    $stmt = $koneksi->prepare("
        SELECT tahun, COUNT(*) AS jumlah
        FROM mahasiswa_kip
        WHERE status='approved' AND UPPER(program_studi) = UPPER(?)
        GROUP BY tahun
        ORDER BY tahun ASC
    ");
    $stmt->bind_param("s", $prodi);
} elseif ($jurusan) {
    $stmt = $koneksi->prepare("
        SELECT tahun, COUNT(*) AS jumlah
        FROM mahasiswa_kip
        WHERE status='approved' AND UPPER(jurusan) = UPPER(?)
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

while ($row = $result->fetch_assoc()) {
    $thn = (int)$row['tahun'];
    if (isset($data_tahun[$thn])) {
        $data_tahun[$thn] = (int)$row['jumlah'];
    }
}

// --- Ambil daftar Prodi sesuai Jurusan (untuk dropdown) ---
$prodi_list = [];
if ($jurusan) {
    $prodiStmt = $koneksi->prepare("
        SELECT DISTINCT program_studi 
        FROM mahasiswa_kip 
        WHERE status='approved' AND UPPER(jurusan) = UPPER(?)
        ORDER BY program_studi ASC
    ");
    $prodiStmt->bind_param("s", $jurusan);
    $prodiStmt->execute();
    $res = $prodiStmt->get_result();
    while ($r = $res->fetch_assoc()) {
        $prodi_list[] = $r['program_studi'];
    }
    $prodiStmt->close();
} else {
    // Semua Prodi
    $res = $koneksi->query("SELECT DISTINCT program_studi FROM mahasiswa_kip WHERE status='approved' ORDER BY program_studi ASC");
    while ($r = $res->fetch_assoc()) {
        $prodi_list[] = $r['program_studi'];
    }
}

// --- Output JSON ---
echo json_encode([
    'error' => false,
    'message' => $prodi
        ? "Data Prodi '$prodi' berhasil diambil."
        : ($jurusan ? "Data Jurusan '$jurusan' berhasil diambil." : "Data seluruh mahasiswa berhasil diambil."),
    'labels' => array_keys($data_tahun),   // Tahun
    'data' => array_values($data_tahun),   // Jumlah per tahun
    'prodi' => $prodi_list                  // Dropdown Prodi
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Tutup statement & koneksi
$stmt->close();
$koneksi->close();
?>
