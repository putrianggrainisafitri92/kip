<?php
session_start();
include '../protect.php';
check_level(13); 
include '../koneksi.php';
include 'sidebar.php';

if(!isset($_GET['skema']) || !isset($_GET['tahun'])){
    echo "Batch tidak ditemukan.";
    exit;
}

$skema = $_GET['skema'];
$tahun = intval($_GET['tahun']);

// Ambil semua mahasiswa di batch ini
$stmt = $koneksi->prepare("SELECT * FROM mahasiswa_kip WHERE TRIM(skema)=? AND tahun=? ORDER BY nama_mahasiswa ASC");
$stmt->bind_param("si", $skema, $tahun);
$stmt->execute();
$res = $stmt->get_result();

// Cek status batch (diambil dari salah satu mahasiswa saja karena batch di-update kolektif)
$stmt_status = $koneksi->prepare("SELECT status FROM mahasiswa_kip WHERE TRIM(skema)=? AND tahun=? LIMIT 1");
$stmt_status->bind_param("si", $skema, $tahun);
$stmt_status->execute();
$current_status = $stmt_status->get_result()->fetch_assoc()['status'] ?? 'pending';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Batch KIP - Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            background: #fff;
            margin: 0;
            color: #000;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px;
            transition: 0.3s ease;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            background: #fff;
            position: relative;
        }

        .header-print {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
        }

        .header-print h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }

        .header-print p {
            margin: 5px 0;
            font-size: 11pt;
        }

        .table-formal {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-formal th, .table-formal td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
            vertical-align: middle;
        }

        .table-formal th {
            background: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .status-badge {
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 10pt;
        }
        .approved { color: #2e7d32; }
        .pending { color: #f9a825; }
        .rejected { color: #c62828; }

        .action-buttons {
            margin-top: 40px;
            text-align: right;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }
        
        @media print {
            .sidebar, .action-buttons, .btn-float-back { display: none !important; }
            .main-content { margin-left: 0; padding: 0; }
            .container { border: none; box-shadow: none; padding: 0; }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            transition: 0.3s;
            cursor: pointer;
            border: none;
        }
        .btn-back { background: #f1f1f1; color: #666; }
        .btn-approve { background: #2e7d32; color: white; margin-left: 10px; }
        .btn-reject { background: #c62828; color: white; margin-left: 10px; }
        .btn:hover { opacity: 0.8; }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; padding: 85px 15px 40px 15px; }
            .container { padding: 25px; }
            .table-responsive { overflow-x: auto; }
            body { font-size: 11pt; }
        }

        @media (max-width: 600px) {
            .header-print h2 { font-size: 14pt; }
            .action-buttons { display: flex; flex-direction: column; gap: 10px; text-align: center; }
            .btn { width: 100%; justify-content: center; margin: 0 !important; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container">
        
        <div class="header-print">
            <h2>Daftar Penerima KIP-Kuliah</h2>
            <h2>Politeknik Negeri Lampung</h2>
            <p>Skema: <?= htmlspecialchars($skema); ?> | Tahun Angkatan: <?= $tahun; ?></p>
        </div>

        <div class="table-responsive">
            <table class="table-formal">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>NPM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; while($d = $res->fetch_assoc()){ ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++; ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($d['npm']); ?></td>
                        <td><?= htmlspecialchars($d['nama_mahasiswa']); ?></td>
                        <td><?= htmlspecialchars($d['program_studi']); ?></td>
                        <td><?= htmlspecialchars($d['jurusan']); ?></td>
                        <td style="text-align:center;">
                            <span class="status-badge <?= strtolower($d['status']); ?>">
                                <?= strtoupper($d['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($no == 1): ?>
                    <tr><td colspan="6" style="text-align:center; padding: 20px;">Data tidak ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="action-buttons">
            <a href="validasi_kip.php" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <?php if(strtolower($current_status) != 'approved'): ?>
                <a href="validasi_kip_proses.php?skema=<?= urlencode($skema); ?>&tahun=<?= $tahun; ?>&status=approved" 
                   class="btn btn-approve" onclick="return confirm('Persetujuan kolektif untuk batch ini?')">
                    <i class="fas fa-check"></i> Approve Batch
                </a>

                <button type="button" class="btn btn-reject" onclick="triggerReject()">
                    <i class="fas fa-times"></i> Minta Revisi
                </button>

                <script>
                function triggerReject() {
                    let cat = prompt('Masukkan catatan revisi / alasan penolakan untuk batch ini:');
                    if(cat != null && cat.trim() !== "") {
                        window.location.href = 'validasi_kip_proses.php?skema=<?= urlencode($skema); ?>&tahun=<?= $tahun; ?>&status=rejected&catatan=' + encodeURIComponent(cat);
                    } else if(cat != null) {
                        alert('Catatan tidak boleh kosong untuk penolakan.');
                    }
                }
                </script>
            <?php endif; ?>
            
            <button onclick="window.print()" class="btn" style="background:#555; color:white; margin-left: 10px;">
                <i class="fas fa-print"></i> Cetak Formal
            </button>
        </div>

    </div>
</div>

</body>
</html>
