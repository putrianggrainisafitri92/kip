<?php
require __DIR__ . '/../../composer-test/vendor/autoload.php';
include __DIR__ . '/../../koneksi.php';
include __DIR__ . '/../sidebar.php';

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

// ================== LOG ==================
$logInsert = [];
$logDuplicate = [];
$insertCount = 0;
$duplicateCount = 0;

// ================== UPLOAD FILE ==================
if (isset($_POST['submit'])) {

    $file = $_FILES['excel']['tmp_name'];

    if (!file_exists($file) || empty($file)) {
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

            // AUTOMATIS MAPPING JURUSAN DARI PRODI
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

            // INSERT BARU
            $stmt = $koneksi->prepare("
                INSERT INTO mahasiswa_kip
                (npm, nama_mahasiswa, program_studi, jurusan, tahun, skema)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param("ssssss", $npm, $nama, $prodi, $jurusan, $tahun, $skema);
            $stmt->execute();
            $stmt->close();

            $insertCount++;
            $logInsert[] = "NPM $npm ($nama) berhasil ditambahkan.";
        }

        $msg = "✅ Upload selesai! <br>• $insertCount data baru <br>• $duplicateCount data duplikat dilewati";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f2f2; /* background halaman abu-abu muda */
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            padding: 20px;
        }
        .main-content {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }
        .container-box {
            background: #ffffff; /* kotak utama putih */
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }
        .container-box h2 {
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 20px;
            border-bottom: 2px solid #2a5298;
            padding-bottom: 10px;
        }
        .note-box {
            background: #e9ecef;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
        .note-box h5 {
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .form-label {
            color: #1e3c72;
            font-weight: 600;
        }
        .btn-primary {
            background: #1e3c72;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 6px;
        }
        .btn-primary:hover {
            background: #2a5298;
        }
        .btn-secondary {
            background: #7e8ba3;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 6px;
        }
        .btn-secondary:hover {
            background: #5a6c7d;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
        }
        .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 0 0.15rem rgba(42,82,152,0.2);
        }
        .table {
            border-radius: 6px;
            overflow: hidden;
            margin-top: 10px;
        }
        .table thead {
            background: #1e3c72;
            color: white;
        }
        .table th, .table td {
            padding: 8px;
            font-size: 14px;
        }
        .alert-info {
            background: #e9ecef;
            border: 1px solid #ddd;
            color: #1e3c72;
            border-radius: 6px;
            font-weight: 500;
        }
        .mt-4 h4 {
            color: #1e3c72;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .mt-4 ul {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 3px solid #2a5298;
            list-style: none;
        }
        .mt-4 ul li {
            color: #1e3c72;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container-box">
            <h2>Upload Mahasiswa KIP</h2>

            <?php if(isset($msg) && $msg != ''): ?>
                <div class="alert alert-info"><?= $msg ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data" class="mb-3">
                <label class="form-label fw-bold">Upload File Excel (.xlsx)</label>
                <input type="file" name="excel" accept=".xlsx" class="form-control mb-3" required>
                <button type="submit" name="submit" class="btn btn-primary">Upload</button>
            </form>

            <div class="note-box">
                <h5>📌 Note Format Excel</h5>
                <ul>
                    <li>Kolom harus berurutan: <b>npm, nama_mahasiswa, program_studi, tahun, skema</b></li>
                    <li>Kolom <b>npm</b> harus unik. Jika sudah ada, data tidak akan tersimpan.</li>
                    <li>Kolom <b>jurusan</b> tidak perlu diisi. Sistem akan otomatis menentukan jurusan berdasarkan <b>program_studi</b>.</li>
                    <li>Contoh data:</li>
                </ul>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>npm</th>
                            <th>nama_mahasiswa</th>
                            <th>program_studi</th>
                            <th>tahun</th>
                            <th>skema</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1234567890</td>
                            <td>Putri Anggaraini</td>
                            <td>D3 Manajemen Informatika</td>
                            <td>2023</td>
                            <td>skema 1</td>
                        </tr>
                        <tr>
                            <td>1234567891</td>
                            <td>Cindy Naysila</td>
                            <td>D3 Manajemen Informatika</td>
                            <td>2023</td>
                            <td>skema 2</td>
                        </tr>
                        <tr>
                            <td>12345678912</td>
                            <td>Vina Sahara</td>
                            <td>D3 Manajemen Informatika</td>
                            <td>2023</td>
                            <td>skema 1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a href="index.php" class="btn btn-secondary mt-3">← Kembali ke Data Mahasiswa</a>

            <?php if(isset($logInsert) && !empty($logInsert)): ?>
                <div class="mt-4">
                    <h4>✅ Data Ditambahkan</h4>
                    <ul>
                        <?php foreach ($logInsert as $l): ?>
                            <li><?= $l ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(isset($logDuplicate) && !empty($logDuplicate)): ?>
                <div class="mt-4">
                    <h4>⚠️ Data Duplikat (Dilewati)</h4>
                    <ul>
                        <?php foreach ($logDuplicate as $d): ?>
                            <li><?= $d ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
