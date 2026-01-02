<?php
session_start();
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

// Ambil ID berita
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    die("ID berita tidak valid.");
}

// Ambil data berita
$stmt = $koneksi->prepare("SELECT * FROM berita WHERE id_berita = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$d = $result->fetch_assoc();

if (!$d) {
    die("Berita tidak ditemukan");
}

// Ambil semua gambar berita
$g = $koneksi->prepare("SELECT * FROM berita_gambar WHERE id_berita = ? ORDER BY sortorder ASC");
$g->bind_param("i", $id);
$g->execute();
$gambarResult = $g->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Berita - Kabag Akademik</title>
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
            max-width: 1000px;
            margin: auto;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .berita-card { 
            background: white; 
            padding: 40px; 
            border-radius: 28px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .header-meta {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .berita-title { 
            font-size: 2.2rem; 
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

        .image-gallery {
            margin: 30px 0;
            display: grid;
            gap: 25px;
        }

        .img-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .berita-img {
            width: 100%;
            display: block;
            transition: 0.5s;
        }
        .img-item:hover .berita-img { transform: scale(1.03); }

        .caption-overlay {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px 25px;
            border-top: 1px solid rgba(0,0,0,0.05);
            color: #555;
            font-size: 0.95rem;
            font-style: italic;
        }

        .action-footer {
            margin-top: 40px;
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

        .btn-back { 
            background: #f1f1f1; 
            color: #666; 
        }
        .btn-back:hover { background: #e5e5e5; color: #333; }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 85px 15px 40px 15px;
            }
            .berita-card { padding: 25px; }
            .berita-title { font-size: 1.6rem; }
        }

        @media (max-width: 600px) {
            .action-footer { flex-direction: column; width: 100%; }
            .btn { width: 100%; justify-content: center; box-sizing: border-box; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container">
        
        <div class="berita-card">
            <div class="header-meta">
                <h1 class="berita-title"><?= htmlspecialchars($d['judul']); ?></h1>
                <?php
                    $statusClass = "status-" . strtolower($d['status']);
                    $icon = ($d['status'] == 'approved') ? 'check-circle' : (($d['status'] == 'pending') ? 'clock' : 'exclamation-circle');
                ?>
                <span class="status-pill <?= $statusClass ?>">
                    <i class="fas fa-<?= $icon ?>"></i> <?= strtoupper(htmlspecialchars($d['status'])); ?>
                </span>
            </div>

            <div style="font-size: 0.9rem; color: #888; margin-top: -15px; margin-bottom: 25px;">
                <i class="far fa-calendar-alt mr-1"></i> <?= date('d F Y', strtotime($d['created_at'])) ?>
                <?php if(!empty($d['tanggal_kegiatan'])): ?>
                   | <i class="fas fa-briefcase mr-1"></i> Kegiatan: <?= date('d M Y', strtotime($d['tanggal_kegiatan'])) ?>
                <?php endif; ?>
            </div>

            <!-- TAMPILKAN SEMUA GAMBAR + CAPTION -->
            <div class="image-gallery">
                <?php while ($img = $gambarResult->fetch_assoc()): ?>
                    <div class="img-item">
                        <img class="berita-img" src="../uploads/berita/<?= htmlspecialchars($img['file']); ?>" alt="Berita Image">
                        <?php if (!empty($img['caption'])): ?>
                            <div class="caption-overlay">
                                <i class="fas fa-info-circle mr-2" style="opacity: 0.5;"></i> <?= htmlspecialchars($img['caption']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="action-footer">
                <a class="btn btn-back" href="validasi_berita.php">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <?php if($d['status'] == 'pending'): ?>
                    <a class="btn btn-approve" href="validasi_berita_proses.php?id=<?= $d['id_berita']; ?>&s=approved" onclick="return confirm('Setujui berita ini untuk dipublikasikan?');">
                        <i class="fas fa-check"></i> Validasi Sekarang
                    </a>

                    <a class="btn btn-reject" href="validasi_berita_revisi.php?id=<?= $d['id_berita']; ?>">
                        <i class="fas fa-times"></i> Minta Revisi
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

</body>
</html>
