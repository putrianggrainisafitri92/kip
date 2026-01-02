<?php
include "../protect.php";
check_level(12);
include "../koneksi.php";
include "sidebar.php";

if (!isset($_GET['id'])) {
    echo "<script>alert('ID laporan tidak ditemukan'); location='laporan_list.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$stmt = $koneksi->prepare("SELECT * FROM laporan WHERE id_laporan=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$d = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$d) {
    echo "<script>alert('Data laporan tidak ditemukan'); location='laporan_list.php';</script>";
    exit;
}

// Update Status
if (isset($_GET['proses']) || isset($_GET['selesai'])) {
    $statusBaru = isset($_GET['proses']) ? 'Diproses' : 'Selesai';
    $stmt = $koneksi->prepare("UPDATE laporan SET status_tindak=?, id_admin=? WHERE id_laporan=?");
    $stmt->bind_param("sii", $statusBaru, $_SESSION['id_admin'], $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Status diperbarui menjadi $statusBaru'); location='laporan_tindak.php?id=$id';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Laporan Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-purple: #6a11cb;
            --secondary-purple: #2575fc;
            --deep-purple: #4e0a8a;
            --glass-purple: rgba(78, 10, 138, 0.95);
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

        .detail-card {
            width: 100%;
            max-width: 900px;
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
            font-size: 26px;
            font-weight: 800;
            text-transform: uppercase;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Information Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            background: rgba(255,255,255,0.05);
            padding: 15px;
            border-radius: 12px;
            border-left: 4px solid #ba68ff;
        }

        .info-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ba68ff;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .info-value {
            font-size: 15px;
            font-weight: 500;
        }

        .full-width { grid-column: span 2; }

        /* Status Badge */
        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            display: inline-block;
        }
        .pending { background: #ffa000; color: #fff; }
        .diproses { background: #2196f3; color: #fff; }
        .selesai { background: #4caf50; color: #fff; }

        /* Evidence Section */
        .evidence-box {
            background: rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 15px;
            margin-top: 15px;
        }

        .btn-file {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            font-size: 13px;
            transition: 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-file:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); border-color: #ba68ff; }

        /* Action Footer */
        .action-footer {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 12px 25px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-proses { background: #ffa000; }
        .btn-selesai { background: #4caf50; }
        .btn-back { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); }

        .btn-action:hover { filter: brightness(1.1); transform: translateY(-3px); }

        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
            .info-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="detail-card">
        <h2>Detail Laporan Mahasiswa</h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nama Pelapor</div>
                <div class="info-value"><?= htmlspecialchars($d['nama_pelapor']); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Email Pelapor</div>
                <div class="info-value"><?= htmlspecialchars($d['email_pelapor']); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Mahasiswa Terlapor</div>
                <div class="info-value"><?= htmlspecialchars($d['nama_terlapor']); ?> <br><small style="opacity:0.7;"><?= $d['npm_terlapor'] ?></small></div>
            </div>
            <div class="info-item">
                <div class="info-label">Jurusan / Prodi</div>
                <div class="info-value"><?= htmlspecialchars($d['jurusan']); ?> / <?= htmlspecialchars($d['prodi']); ?></div>
            </div>
            <div class="info-item full-width">
                <div class="info-label">Alasan Pelaporan</div>
                <div class="info-value"><?= htmlspecialchars($d['alasan']); ?></div>
            </div>
            <div class="info-item full-width">
                <div class="info-label">Detail Laporan</div>
                <div class="info-value" style="background: rgba(0,0,0,0.2); padding: 15px; border-radius: 8px; margin-top: 5px; line-height: 1.6;">
                    <?= nl2br(htmlspecialchars($d['detail_laporan'])); ?>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Status Saat Ini</div>
                <div class="info-value">
                    <?php 
                    $st = strtolower($d['status_tindak']);
                    $st_label = ($st=='' || $st=='pending') ? 'PENDING' : strtoupper($st);
                    $st_class = ($st=='' || $st=='pending') ? 'pending' : ($st=='diproses' ? 'diproses' : 'selesai');
                    ?>
                    <span class="status-badge <?= $st_class ?>"><?= $st_label ?></span>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Masuk</div>
                <div class="info-value"><?= date('d M Y, H:i', strtotime($d['created_at'])) ?> WIB</div>
            </div>
        </div>

        <div class="evidence-box">
            <h4 style="margin-top:0; border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:10px;">
                <i class="fas fa-paperclip"></i> Bukti Lampiran
            </h4>
            <div style="margin-top:15px;">
                <?php 
                $bukti = $d['bukti'];
                if (!empty($bukti)) {
                    $files = explode(',', $bukti);
                    foreach ($files as $file) {
                        $file = trim($file);
                        $file_path = "../uploads/" . $file;
                        if (file_exists($file_path)) {
                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $icon = 'fas fa-file-alt';
                            if (in_array($ext, ['jpg','jpeg','png','webp'])) $icon = 'fas fa-image';
                            elseif (in_array($ext, ['mp4','mov','mkv'])) $icon = 'fas fa-video';
                            elseif ($ext == 'pdf') $icon = 'fas fa-file-pdf';

                            echo '<a href="../uploads/'.$file.'" target="_blank" class="btn-file"><i class="'.$icon.'"></i> '.htmlspecialchars($file).'</a>';
                        } else {
                            echo '<span style="color:#ff4d4d; font-size:12px; margin-right:15px;"><i class="fas fa-exclamation-triangle"></i> '.htmlspecialchars($file).' Hilang</span>';
                        }
                    }
                } else {
                    echo '<em style="opacity:0.6;">Tidak ada lampiran bukti.</em>';
                }
                ?>
            </div>
        </div>

        <div class="action-footer">
            <a href="laporan_list.php" class="btn-action btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            
            <?php if($st != 'diproses' && $st != 'selesai'): ?>
            <a href="?id=<?= $id ?>&proses=1" class="btn-action btn-proses" onclick="return confirm('Tandai laporan ini mulai diproses?')">
                <i class="fas fa-clock"></i> Mulai Proses
            </a>
            <?php endif; ?>

            <?php if($st != 'selesai'): ?>
            <a href="?id=<?= $id ?>&selesai=1" class="btn-action btn-selesai" onclick="return confirm('Tandai laporan ini sudah selesai ditangani?')">
                <i class="fas fa-check-circle"></i> Selesaikan Laporan
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
