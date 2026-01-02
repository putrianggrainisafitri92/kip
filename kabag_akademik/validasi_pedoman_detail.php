<?php
session_start();
include '../protect.php';
check_level(13); 
include '../koneksi.php';
include 'sidebar.php';

if(!isset($_GET['id'])) {
    die("ID pedoman tidak ditemukan.");
}

$id = intval($_GET['id']);
$q = mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id_pedoman = $id");
$d = mysqli_fetch_assoc($q);

if(!$d) {
    die("Pedoman tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pedoman - Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f2ff;
            margin: 0;
            color: #333;
        }

        .main-content { 
            margin-left: 240px; 
            padding: 40px 20px; 
            min-height: 100vh;
            transition: 0.3s ease;
        }

        .container {
            max-width: 800px;
            margin: auto;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .detail-card { 
            background: white; 
            padding: 40px; 
            border-radius: 28px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .header-meta {
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .title { 
            font-size: 1.8rem; 
            font-weight: 800; 
            color: #4e0a8a; 
            margin: 0;
            line-height: 1.2;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .status-pending { background: #fff8e1; color: #ff8f00; border: 1px solid #ffe082; }
        .status-approved { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .status-rejected { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
            background: #fbf9ff;
            padding: 25px;
            border-radius: 20px;
        }

        .info-item label {
            display: block;
            font-size: 0.8rem;
            color: #888;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .info-item span {
            font-weight: 600;
            color: #444;
            font-size: 1.05rem;
        }

        .file-box {
            background: #f0f7ff;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 35px;
            border: 1px solid #d0e4ff;
        }
        .file-icon {
            font-size: 2rem;
            color: #d32f2f;
        }
        .file-name {
            flex-grow: 1;
            font-weight: 600;
            color: #1976d2;
            word-break: break-all;
        }
        .btn-view-file {
            background: #1976d2;
            color: white;
            padding: 8px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .action-footer {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }

        .btn { 
            padding: 14px 28px; 
            border-radius: 14px; 
            text-decoration: none; 
            font-size: 15px; 
            font-weight: 700; 
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-approve { 
            background: linear-gradient(135deg, #2e7d32, #43a047); 
            color: white;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }
        .btn-approve:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(46, 125, 50, 0.4); }

        .btn-reject { 
            background: linear-gradient(135deg, #c62828, #e53935); 
            color: white;
            box-shadow: 0 4px 15px rgba(198, 40, 40, 0.3);
        }
        .btn-reject:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(198, 40, 40, 0.4); }

        .btn-back { background: #f1f1f1; color: #666; }
        .btn-back:hover { background: #e5e5e5; color: #333; }

        /* MODAL REVISI */
        .modal {
            display: none;
            position: fixed;
            z-index: 20000;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            padding: 20px;
        }

        .modal-content {
            background: white;
            margin: 15vh auto;
            padding: 35px;
            border-radius: 30px;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            animation: modalScale 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalScale {
            from { opacity: 0; transform: scale(0.8) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-header h3 { margin: 0 0 20px 0; color: #4e0a8a; font-weight: 800; text-align: center; }

        textarea {
            width: 100%;
            height: 150px;
            border-radius: 15px;
            border: 2px solid #e0d5f5;
            padding: 15px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            outline: none;
            resize: none;
            box-sizing: border-box;
            background: #fdfcff;
            margin-bottom: 25px;
        }
        textarea:focus { border-color: #7b35d4; }

        .modal-btns { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 85px 15px 40px 15px;
            }
            .detail-card { padding: 25px; }
            .info-grid { grid-template-columns: 1fr; gap: 15px; }
        }

        @media (max-width: 600px) {
            .action-footer { flex-direction: column; width: 100%; }
            .btn { width: 100%; justify-content: center; box-sizing: border-box; }
            .modal-btns { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container">
        <div class="detail-card">
            <div class="header-meta">
                <h2 class="title">Detail Pedoman</h2>
                <?php
                    $status_lower = strtolower($d['status']);
                    $statusClass = "status-" . $status_lower;
                ?>
                <span class="status-pill <?= $statusClass ?>">
                    <i class="fas fa-info-circle"></i> <?= strtoupper($d['status']); ?>
                </span>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <label>Nama File</label>
                    <span><?= htmlspecialchars($d['nama_file']); ?></span>
                </div>
                <div class="info-item">
                    <label>Tgl Upload</label>
                    <span><?= !empty($d['tanggal_upload']) ? date('d M Y', strtotime($d['tanggal_upload'])) : '-'; ?></span>
                </div>
            </div>

            <div class="file-box">
                <i class="far fa-file-pdf file-icon"></i>
                <div class="file-name"><?= basename($d['file_path'] ?? 'pedoman.pdf'); ?></div>
                <?php if(!empty($d['file_path'])): ?>
                    <a href="../<?= htmlspecialchars($d['file_path']); ?>" target="_blank" class="btn-view-file">
                        <i class="fas fa-external-link-alt"></i> Lihat
                    </a>
                <?php endif; ?>
            </div>

            <div class="action-footer">
                <a class="btn btn-back" href="validasi_pedoman.php">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <?php if($status_lower == 'pending'): ?>
                    <form action="validasi_pedoman_proses.php" method="post" id="formApprove" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="s" value="approved">
                        <button type="button" class="btn btn-approve" onclick="confirmApprove()">
                            <i class="fas fa-check"></i> Setujui Pedoman
                        </button>
                    </form>

                    <button type="button" class="btn btn-reject" onclick="openRejectModal()">
                        <i class="fas fa-times"></i> Minta Revisi
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REVISI -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Catatan Revisi</h3>
        </div>
        <form action="validasi_pedoman_proses.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="s" value="rejected">
            
            <textarea name="catatan_revisi" placeholder="Tulis alasan penolakan atau bagian yang perlu direvisi..." required></textarea>
            
            <div class="modal-btns">
                <button type="button" class="btn btn-back" onclick="closeRejectModal()">Batalkan</button>
                <button type="submit" class="btn btn-reject">Kirim Revisi</button>
            </div>
        </form>
    </div>
</div>

<script>
function confirmApprove() {
    if(confirm('Apakah Anda yakin ingin menyetujui pedoman ini?')) {
        document.getElementById('formApprove').submit();
    }
}

function openRejectModal() {
    document.getElementById('rejectModal').style.display = 'block';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('rejectModal');
    if (event.target == modal) {
        closeRejectModal();
    }
}
</script>

</body>
</html>
