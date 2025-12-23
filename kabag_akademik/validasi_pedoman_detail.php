<?php
include '../protect.php';
check_level(13); 
include '../koneksi.php';
include 'sidebar.php';

// Gunakan variabel koneksi yang benar
$db = isset($koneksi) ? $koneksi : $conn;

if(!isset($_GET['id'])) {
    die("ID pedoman tidak ditemukan.");
}

$id = intval($_GET['id']);
$q = mysqli_query($db, "SELECT * FROM pedoman WHERE id_pedoman = $id");
$d = mysqli_fetch_assoc($q);

if(!$d) {
    die("Pedoman tidak ditemukan.");
}
?>

<style>
body {
    background: #efeaff;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
}

/* WRAPPER */
.content-wrapper {
    margin-left: 260px;
    padding: 35px;
}

/* HEADER CARD */
.header-card {
    background: #ffffff;
    padding: 28px;
    border-radius: 18px;
    border-left: 10px solid #6a0dad;
    box-shadow: 0 6px 22px rgba(106, 13, 173, 0.15);
    margin-bottom: 25px;
}

.header-card h2 {
    margin: 0;
    font-size: 30px;
    font-weight: 800;
    color: #4e0a8a;
}

/* DETAIL CARD */
.detail-card {
    background: #ffffff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}

/* GRID RAPIH 2 KOLOM */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px 40px;
}

/* LABEL & VALUE */
.detail-item .label {
    font-weight: 700;
    color: #4e0a8a;
    font-size: 15px;
}

.detail-item .value {
    margin-top: 6px;
    font-size: 15px;
}

/* FULL WIDTH ITEM */
.full {
    grid-column: span 2;
}

/* BADGE STATUS */
.badge {
    padding: 7px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
}

.success { background: #2ecc71; }
.pending { background: #f1c40f; color: #4a3d00; }
.danger  { background: #e74c3c; }

/* BUTTON BACK */
.btn-back {
    padding: 12px 22px;
    background: #6a0dad;
    color: white;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: 0.2s;
}

.btn-back:hover {
    opacity: 0.85;
}
</style>

<div class="content-wrapper">

    <div class="header-card">
        <h2>📘 Detail Pedoman</h2>
    </div>

    <div class="detail-card">

        <div class="detail-grid">

            <div class="detail-item">
                <div class="label">Nama File</div>
                <div class="value"><?= htmlspecialchars($d['nama_file']); ?></div>
            </div>

            <div class="detail-item">
                <div class="label">Status</div>
                <div class="value">
                    <?php
                        $status = strtolower($d['status']);
                        $badgeClass = ($status == "approved") ? "success" :
                                      (($status == "pending") ? "pending" : "danger");
                    ?>
                    <span class="badge <?= $badgeClass; ?>"><?= strtoupper($d['status']); ?></span>
                </div>
            </div>

            <div class="detail-item">
                <div class="label">Tanggal Upload</div>
                <div class="value"><?= $d['tanggal_upload'] ?></div>
            </div>

            <div class="detail-item full">
                <div class="label">Catatan Revisi</div>
                <div class="value">
                    <?= !empty($d['catatan_revisi']) 
                        ? nl2br(htmlspecialchars($d['catatan_revisi'])) 
                        : "<span style='color:red;'>Belum ada catatan</span>"; ?>
                </div>
            </div>

            <div class="detail-item full">
                <div class="label">File</div>
                <div class="value">
                    <?php if(!empty($d['file_path'])): ?>
                        <a href="../<?= htmlspecialchars($d['file_path']); ?>" target="_blank" style="color:#6a0dad; font-weight:bold;">
                            Download / Lihat File
                        </a>
                    <?php else: ?>
                        Tidak ada file
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>

    <a href="validasi_pedoman.php" class="btn-back">Kembali</a>

</div>
