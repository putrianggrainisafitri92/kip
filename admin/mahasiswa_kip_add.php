<?php
include "../koneksi.php";          // koneksi DB admin2
include "protect.php";             // agar hanya admin2 yang bisa akses
include "sidebar.php";             // sidebar admin2

require '../composer-test/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// ================== MAPPING PRODI → JURUSAN ==================
$jurusanMap = [
    'D3 Hortikultura' => 'JURUSAN BUDIDAYA TANAMAN PANGAN',
    'D4 Teknologi Produksi Tanaman Pangan' => 'JURUSAN BUDIDAYA TANAMAN PANGAN',
    'D4 Teknologi Perbenihan' => 'JURUSAN BUDIDAYA TANAMAN PANGAN',
    'D4 Teknologi Produksi Tanaman Hortikultura' => 'JURUSAN BUDIDAYA TANAMAN PANGAN',
    'D3 Produksi Tanaman Perkebunan' => 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN',
    'D4 Produksi dan Manajemen Industri Perkebunan' => 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN',
    'D4 Pengelolaan Perkebunan Kopi' => 'JURUSAN BUDIDAYA TANAMAN PERKEBUNAN',
    'D2 Pengolahan Patiseri' => 'JURUSAN TEKNOLOGI PERTANIAN',
    'D3 Mekanisasi Pertanian' => 'JURUSAN TEKNOLOGI PERTANIAN',
    'D3 Teknologi Pangan' => 'JURUSAN TEKNOLOGI PERTANIAN',
    'D4 Pengembangan Produk Agroindustri' => 'JURUSAN TEKNOLOGI PERTANIAN',
    'D4 Kimia Terapan' => 'JURUSAN TEKNOLOGI PERTANIAN',
    'D4 Teknologi Produksi Ternak' => 'JURUSAN PETERNAKAN',
    'D4 Agribisnis Peternakan' => 'JURUSAN PETERNAKAN',
    'D4 Teknologi Pakan Ternak' => 'JURUSAN PETERNAKAN',
    'D3 Perjalanan Wisata' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Agribisnis Pangan' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Pengelolaan Agribisnis' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Akuntansi Perpajakan' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Akuntansi Bisnis Digital' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Pengelolaan Perhotelan' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Pengelolaan Konvensi dan Acara' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Produksi Media' => 'JURUSAN EKONOMI DAN BISNIS',
    'D4 Bahasa Inggris untuk Bisnis dan Profesional' => 'JURUSAN EKONOMI DAN BISNIS',
    'D3 Teknik Sumberdaya Lahan dan Lingkungan' => 'JURUSAN TEKNIK',
    'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan' => 'JURUSAN TEKNIK',
    'D4 Teknologi Rekayasa Kimia Industri' => 'JURUSAN TEKNIK',
    'D4 Teknologi Rekayasa Otomotif' => 'JURUSAN TEKNIK',
    'D3 Budidaya Perikanan' => 'JURUSAN PERIKANAN DAN KELAUTAN',
    'D3 Perikanan Tangkap' => 'JURUSAN PERIKANAN DAN KELAUTAN',
    'D4 Teknologi Pembenihan Ikan' => 'JURUSAN PERIKANAN DAN KELAUTAN',
    'D3 Manajemen Informatika' => 'JURUSAN TEKNOLOGI INFORMASI',
    'D4 Teknologi Rekayasa Internet' => 'JURUSAN TEKNOLOGI INFORMASI',
    'D4 Teknologi Rekayasa Elektronika' => 'JURUSAN TEKNOLOGI INFORMASI',
    'D4 Teknologi Rekayasa Perangkat Lunak' => 'JURUSAN TEKNOLOGI INFORMASI'
];

$logInsert = [];
$logDuplicate = [];
$insertCount = 0;
$duplicateCount = 0;

// ================== UPLOAD FILE ==================
if (isset($_POST['submit'])) {

    $file = $_FILES['excel']['tmp_name'];

    if (!file_exists($file)) {
        $msg = "⚠️ File Excel tidak ditemukan.";
    } else {

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        for ($i = 1; $i < count($rows); $i++) {

            $npm   = trim($rows[$i][0]);
            $nama  = trim($rows[$i][1]);
            $prodi = trim($rows[$i][2]);
            $tahun = trim($rows[$i][3]);
            $skema = trim($rows[$i][4]);

            if (!$npm) continue;

            $jurusan = $jurusanMap[$prodi] ?? 'JURUSAN TIDAK DIKETAHUI';

            // CEK DUPLIKAT
            $cek = $koneksi->prepare("SELECT npm FROM mahasiswa_kip WHERE npm = ?");
            $cek->bind_param("s", $npm);
            $cek->execute();
            $result = $cek->get_result();

            if ($result->num_rows > 0) {
                $duplicateCount++;
                $logDuplicate[] = "NPM $npm ($nama) dilewati (sudah ada).";
                continue;
            }

            // INSERT BARU (STATUS = PENDING)
            $stmt = $koneksi->prepare("
                INSERT INTO mahasiswa_kip
                (npm, nama_mahasiswa, program_studi, jurusan, tahun, skema, id_admin, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')
            ");

            $stmt->bind_param(
                "ssssssi",
                $npm,
                $nama,
                $prodi,
                $jurusan,
                $tahun,
                $skema,
                $_SESSION['id_admin']
            );

            $stmt->execute();
            $stmt->close();

            $insertCount++;
            $logInsert[] = "NPM $npm ($nama) berhasil ditambahkan (menunggu verifikasi admin 3).";
        }

        $msg = "✅ Upload selesai!<br>• $insertCount data baru<br>• $duplicateCount data duplikat dilewati";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Upload Data Mahasiswa KIP</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    body {
        background: linear-gradient(to bottom right, #ede7ff, #f7f5ff);
        font-family: "Segoe UI", sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 40px;
    }

    /* CARD UTAMA */
    .main-card {
        width: 65%;
        background: #ffffff;
        border-radius: 18px;
        padding: 40px 45px;
        border-left: 10px solid #6a0dad;
        box-shadow: 0 10px 32px rgba(106, 13, 173, 0.18);
    }

    .main-card h2 {
        font-weight: 800;
        color: #4c0a88;
        margin-bottom: 15px;
    }

    /* UPLOAD BOX */
    .upload-box {
        border: 2px dashed #6a0dad;
        padding: 30px;
        border-radius: 14px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s;
        background: #faf5ff;
    }

    .upload-box:hover {
        background: #f3e7ff;
        transform: scale(1.02);
    }

    .upload-box i {
        font-size: 50px;
        color: #6a0dad;
        margin-bottom: 12px;
    }

    .btn-purple {
        background: #6a0dad;
        color: white;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-purple:hover {
        background: #580a9d;
        transform: translateY(-2px);
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        color: #4c0a88;
        margin-top: 25px;
        margin-bottom: 10px;
    }

    /* LOG BOX */
    .log-box {
        background: #fafafa;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e4d7ff;
    }

    .log-box ul {
        max-height: 200px;
        overflow-y: auto;
        padding-left: 25px;
    }

    .log-box ul li {
        margin-bottom: 7px;
        font-size: 15px;
    }
</style>
</head>


<body>

<div class="main-card">

    <h2>📤 Upload Data Mahasiswa KIP</h2>

    <?php if(isset($msg)): ?>
        <div class="alert alert-info shadow-sm"><?= $msg ?></div>
    <?php endif; ?>

    <!-- UPLOAD FORM -->
    <form method="post" enctype="multipart/form-data">

        <label class="form-label fw-bold">Pilih File Excel (.xlsx)</label>

        <label class="upload-box">
            <i class="bi bi-cloud-upload"></i><br>
            <span class="fw-semibold">Klik area ini untuk memilih file Excel</span>
            <input type="file" name="excel" accept=".xlsx" class="form-control mt-3" required>
        </label>

        <button type="submit" name="submit" class="btn btn-purple mt-3">
            Upload Sekarang
        </button>
    </form>

    <hr>

    <div class="section-title">📄 Format Excel</div>
    <p>Kolom harus berurutan:</p>
    <ul>
        <li>NPM</li>
        <li>Nama Mahasiswa</li>
        <li>Program Studi</li>
        <li>Tahun</li>
        <li>Skema</li>
    </ul>

    <p><b>Jurusan otomatis terisi</b> berdasarkan Program Studi.</p>

    <a href="mahasiswa_kip.php" class="btn btn-secondary btn-back mt-2">← Kembali</a>

    <!-- LOG INSERT -->
    <?php if(!empty($logInsert)): ?>
        <div class="section-title">✅ Data Ditambahkan</div>
        <div class="log-box">
            <ul>
                <?php foreach($logInsert as $l): ?>
                    <li><?= $l ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- LOG DUPLIKAT -->
    <?php if(!empty($logDuplicate)): ?>
        <div class="section-title">⚠️ Duplikat (Dilewati)</div>
        <div class="log-box">
            <ul>
                <?php foreach($logDuplicate as $l): ?>
                    <li><?= $l ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

</body>
</html>

