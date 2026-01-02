<?php
include "../koneksi.php";          
include "protect.php";             
include "sidebar.php";             

require '../composer-test/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

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

$logUpdated = [];
$logNew = [];
$updateCount = 0;
$newCount = 0;
$msg = "";

if (isset($_POST['submit'])) {
    $file = $_FILES['excel']['tmp_name'];

    if (!file_exists($file)) {
        $msg = "<div class='alert alert-warning'>⚠️ File Excel tidak ditemukan.</div>";
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

            $cek = $koneksi->prepare("SELECT id_mahasiswa_kip FROM mahasiswa_kip WHERE npm = ?");
            $cek->bind_param("s", $npm);
            $cek->execute();
            $result = $cek->get_result();

            if ($result->num_rows > 0) {
                // UPDATE EXISTING
                $stmt = $koneksi->prepare("
                    UPDATE mahasiswa_kip 
                    SET nama_mahasiswa=?, program_studi=?, jurusan=?, tahun=?, skema=?, status='pending'
                    WHERE npm=?
                ");
                $stmt->bind_param("ssssss", $nama, $prodi, $jurusan, $tahun, $skema, $npm);
                $stmt->execute();
                $updateCount++;
                $logUpdated[] = "NPM $npm ($nama) diperbarui.";
            } else {
                // INSERT NEW
                $stmt = $koneksi->prepare("
                    INSERT INTO mahasiswa_kip
                    (npm, nama_mahasiswa, program_studi, jurusan, tahun, skema, id_admin, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')
                ");
                $stmt->bind_param("ssssssi", $npm, $nama, $prodi, $jurusan, $tahun, $skema, $_SESSION['id_admin']);
                $stmt->execute();
                $newCount++;
                $logNew[] = "NPM $npm ($nama) data baru ditambahkan.";
            }
            $stmt->close();
        }
        $msg = "<div class='alert alert-info'>✅ Proses selesai! • $updateCount data diperbarui • $newCount data baru ditambahkan.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Masal Mahasiswa KIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-purple: #6a11cb;
            --secondary-purple: #2575fc;
            --deep-purple: #4e0a8a;
            --glass-purple: rgba(78, 10, 138, 0.9);
        }

        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .content {
            margin-left: 230px;
            padding: 40px 20px;
            transition: all 0.3s ease;
        }

        .form-card {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 40px;
            border-radius: 24px;
            background: var(--glass-purple);
            backdrop-filter: blur(12px);
            color: white;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-info { background: rgba(37, 117, 252, 0.2); border: 1px solid #2575fc; color: #fff; }
        .alert-warning { background: rgba(255, 193, 7, 0.2); border: 1px solid #ffc107; color: #ffeb3b; }

        .upload-area {
            border: 2px dashed rgba(255,255,255,0.3);
            border-radius: 18px;
            padding: 30px;
            text-align: center;
            background: rgba(255,255,255,0.05);
            transition: 0.3s;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .upload-area:hover { background: rgba(255,255,255,0.1); border-color: #ba68ff; }
        .upload-area i { font-size: 40px; color: #ba68ff; margin-bottom: 15px; }

        .btn-upload {
            background: linear-gradient(135deg, #ba68ff, #7b35d4);
            color: white;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(123, 53, 212, 0.3);
            transition: 0.3s;
        }
        .btn-upload:hover { filter: brightness(1.1); transform: translateY(-2px); }

        .format-info {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 15px;
            margin-top: 30px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .format-info h4 { margin-top: 0; color: #ba68ff; }
        .format-info ul { padding-left: 20px; margin-bottom: 0; }

        .log-section {
            margin-top: 30px;
            max-height: 250px;
            overflow-y: auto;
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 12px;
            font-size: 13px;
        }
        .log-item { margin-bottom: 5px; display: flex; gap: 10px; }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-back:hover { background: rgba(255,255,255,0.15); transform: translateY(-2px); }

        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="form-card">
        <h2>Update Masal Mahasiswa KIP</h2>

        <?= $msg; ?>

        <form method="POST" enctype="multipart/form-data">
            <label class="upload-area" for="excelFile">
                <i class="fas fa-sync-alt"></i>
                <div style="font-weight:600;">Klik untuk pilih file Excel Update (.xlsx)</div>
                <div style="font-size:12px; opacity:0.7; margin-top:5px;">Sistem akan mencocokkan NPM dan memperbarui data</div>
                <input type="file" name="excel" id="excelFile" accept=".xlsx" style="display:none;" onchange="showFileName(this)">
                <div id="fileNameBox" style="margin-top:10px; font-weight:bold; color:#ba68ff; display:none;"></div>
            </label>

            <button type="submit" name="submit" class="btn-upload">
                <i class="fas fa-sync-alt"></i> Proses Update Sekarang
            </button>
        </form>

        <div class="format-info">
            <h4><i class="fas fa-info-circle"></i> Catatan Update</h4>
            <p style="font-size: 13px; opacity: 0.8;">Sistem akan mendeteksi data berdasarkan <b>NPM</b>:</p>
            <ul>
                <li>Jika NPM sudah ada: Data (Nama, Prodi, Thn, Skema) akan <b>diperbarui</b>.</li>
                <li>Jika NPM belum ada: Data akan dianggap sebagai <b>mahasiswa baru</b> dan ditambahkan.</li>
                <li>Status semua data yang masuk akan menjadi <b>Pending</b> menunggu verifikasi ulang.</li>
            </ul>
        </div>

        <?php if(!empty($logUpdated) || !empty($logNew)): ?>
        <div class="log-section">
            <h5 style="color:#ba68ff; margin-bottom:10px;">Riwayat Proses Terakhir:</h5>
            <?php foreach($logUpdated as $log): ?>
                <div class="log-item" style="color:#2ecc71;"><i class="fas fa-sync"></i> <?= $log ?></div>
            <?php endforeach; ?>
            <?php foreach($logNew as $log): ?>
                <div class="log-item" style="color:#fff;"><i class="fas fa-plus-circle"></i> <?= $log ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <a href="mahasiswa_kip.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Mahasiswa
        </a>
    </div>
</div>

<script>
function showFileName(input) {
    const fileName = input.files[0].name;
    const box = document.getElementById('fileNameBox');
    box.innerText = "Selesai: " + fileName;
    box.style.display = "block";
}
</script>

</body>
</html>
