<?php
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

<style>
.main-content { 
    margin-left:240px; 
    padding:40px 30px; 
    min-height:100vh; 
    background:#eef2f5; 
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.berita-box { 
    background:white; 
    padding:30px; 
    border-radius:16px; 
    max-width:900px;
    margin:auto;
    box-shadow:0 6px 18px rgba(0,0,0,0.12); 
}

.berita-title { font-size:26px; font-weight:700; color:#333; margin-bottom:10px; }

.berita-status {
    background:#1976D2;
    display:inline-block;
    padding:6px 14px;
    color:white;
    border-radius:20px;
    font-size:14px;
    margin-bottom:20px;
}

.berita-img {
    width: 100%;
    max-height:420px;
    object-fit:cover;
    border-radius:14px;
    margin-bottom:10px;
    box-shadow:0 3px 12px rgba(0,0,0,0.15);
}

.caption {
    font-size:15px;
    color:#555;
    margin-bottom:25px;
}
.btn { padding:10px 18px; border-radius:8px; color:white; text-decoration:none; display:inline-block; font-size:15px; margin-right:12px; font-weight:600; }
.btn-approve { background:#2E7D32; }
.btn-reject  { background:#C62828; }
.btn-back    { background:#555; }
</style>

<div class="main-content">
    <div class="berita-box">

        <h2 class="berita-title"><?= htmlspecialchars($d['judul']); ?></h2>

        <div class="berita-status">
            STATUS: <?= strtoupper(htmlspecialchars($d['status'])); ?>
        </div>

        <!-- TAMPILKAN SEMUA GAMBAR + CAPTION -->
        <?php while ($img = $gambarResult->fetch_assoc()): ?>

            <img class="berita-img"
                src="../uploads/berita/<?= htmlspecialchars($img['file']); ?>">

            <?php if (!empty($img['caption'])): ?>
                <div class="caption"><?= htmlspecialchars($img['caption']); ?></div>
            <?php endif; ?>

        <?php endwhile; ?>

        <br>

        <!-- BUTTON -->
        <a class="btn btn-back" href="validasi_berita.php">← Kembali</a>

        <a class="btn btn-approve"
            href="validasi_berita_proses.php?id=<?= $d['id_berita']; ?>&s=approved">
            ✔ Approve
        </a>

        <a class="btn btn-reject"
            href="validasi_berita_revisi.php?id=<?= $d['id_berita']; ?>">
            ✖ Reject
        </a>

    </div>
</div>
