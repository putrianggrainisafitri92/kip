<?php
include "../protect.php";
check_level(13); // HANYA ADMIN 3
include "../koneksi.php";
include "sidebar.php";

if (!isset($_GET['id'])) {
    echo "<script>alert('ID laporan tidak ditemukan'); location='lihat_laporan.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$stmt = $koneksi->prepare("SELECT * FROM laporan WHERE id_laporan=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$d = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$d) {
    echo "<script>alert('Data laporan tidak ditemukan'); location='lihat_laporan.php';</script>";
    exit;
}
?>

<!-- =======================================================================
    WRAPPER
======================================================================= -->
<div class="main-wrapper">

    <div class="page-header">
        <h2>📄 Detail Laporan</h2>
    </div>

    <div class="detail-card">

        <h3 class="section-title">Informasi Laporan</h3>

        <table class="detail-table">
            <tr>
                <th>Nama Pelapor</th>
                <td><?= htmlspecialchars($d['nama_pelapor']); ?></td>
            </tr>
            <tr>
                <th>Email Pelapor</th>
                <td><?= htmlspecialchars($d['email_pelapor']); ?></td>
            </tr>
            <tr>
                <th>Terlapor</th>
                <td><?= htmlspecialchars($d['nama_terlapor']); ?> (<?= htmlspecialchars($d['npm_terlapor']); ?>)</td>
            </tr>
            <tr>
                <th>Jurusan / Prodi</th>
                <td><?= htmlspecialchars($d['jurusan']); ?> / <?= htmlspecialchars($d['prodi']); ?></td>
            </tr>
            <tr>
                <th>Alasan</th>
                <td><?= nl2br(htmlspecialchars($d['alasan'])); ?></td>
            </tr>
            <tr>
                <th>Detail Laporan</th>
                <td><?= nl2br(htmlspecialchars($d['detail_laporan'])); ?></td>
            </tr>
            <tr>
                <th>Bukti</th>
                <td>
                    <?php 
                        $bukti = $d['bukti'];
                        $file_path = "../uploads/" . $bukti;

                        if (!empty($bukti)) {
                            if (file_exists($file_path)) {
                                echo '<a href="'.$file_path.'" target="_blank" class="btn-view">📎 Lihat File</a>';
                            } else {
                                echo '<span class="text-danger">⚠ File tidak ditemukan</span>';
                            }
                        } else {
                            echo '<i>Tidak ada bukti</i>';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Status Tindak Lanjut</th>
                <td>
                    <span class="badge 
                    <?= strtolower($d['status_tindak']) == 'pending' ? 'pending' :
                        (strtolower($d['status_tindak']) == 'diproses' ? 'info' : 'success'); ?>">
                        <?= htmlspecialchars($d['status_tindak']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th>Pernyataan</th>
                <td><?= nl2br(htmlspecialchars($d['pernyataan'])); ?></td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td><?= $d['created_at']; ?></td>
            </tr>
        </table>

        <!-- BUTTON KEMBALI SAJA -->
        <div class="action-buttons">
            <a href="lihat_laporan.php" class="btn-action btn-back">⬅ Kembali</a>
        </div>

    </div>

</div>

<!-- =======================================================================
    STYLE
======================================================================= -->
<style>
.main-wrapper {
    margin-left: 230px;
    padding: 40px;
    background: #faf7ff;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.page-header h2 {
    color: #4e0a8a;
    font-weight: bold;
    margin-bottom: 25px;
}

.detail-card {
    background: white;
    width: 85%;
    max-width: 900px;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
}

.section-title {
    color: #6f2dbd;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 18px;
}

.detail-table {
    width: 100%;
    border-collapse: collapse;
}

.detail-table th {
    width: 30%;
    text-align: left;
    background: #f2e9ff;
    padding: 12px;
    font-weight: 600;
    border-radius: 10px 0 0 10px;
}

.detail-table td {
    padding: 12px;
    background: #fbf7ff;
    border-radius: 0 10px 10px 0;
}

.badge {
    padding: 6px 14px;
    border-radius: 20px;
    color: white;
    font-size: 13px;
}
.success { background:#2ecc71; }
.info { background:#3498db; }
.pending { background:#f1c40f; color:black; }

.action-buttons {
    margin-top: 25px;
    text-align: center;
}

.btn-action {
    padding: 10px 22px;
    margin: 5px;
    text-decoration: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
}

.btn-back { background:#6f2dbd; }

.btn-view { color:#6f2dbd; font-weight:bold; }
</style>
