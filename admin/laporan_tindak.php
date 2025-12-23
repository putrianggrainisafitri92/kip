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

<!-- =======================================================================
    WRAPPER
======================================================================= -->
<div class="main-wrapper">

    <div class="page-header">
        <h2>📝 Detail & Tindak Lanjut Laporan</h2>
    </div>

    <div class="detail-card">

        <!-- Judul -->
        <h3 class="section-title">Informasi Laporan</h3>

        <!-- DETAIL TABLE -->
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
           <tr>
    <th>Bukti</th>
    <td>
        <?php 
        $bukti = $d['bukti']; // misal "file1.jpg,file2.mp4,file3.pdf"

        if (!empty($bukti)) {
            $files = explode(',', $bukti); // pisah menjadi array
            foreach ($files as $file) {
                $file = trim($file); // hilangkan spasi
                $file_path = "../uploads/" . $file;
                $file_url  = "../uploads/" . $file;

                if (file_exists($file_path)) {
                    // Pilih ikon berdasarkan tipe file
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg','jpeg','png','webp'])) {
                        $icon = '🖼️';
                    } elseif (in_array($ext, ['mp4','mov','mkv'])) {
                        $icon = '🎥';
                    } else {
                        $icon = '📄';
                    }

                    echo '<a href="'.$file_url.'" target="_blank" class="btn-view">'.$icon.' '.htmlspecialchars($file).'</a><br>';
                } else {
                    echo '<span class="text-danger">⚠ '.htmlspecialchars($file).' tidak ditemukan</span><br>';
                }
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

        <!-- ACTION BUTTONS -->
        <div class="action-buttons">
            <a href="?id=<?= $id ?>&proses=1" class="btn-action btn-warning">Tandai Diproses</a>
            <a href="?id=<?= $id ?>&selesai=1" class="btn-action btn-success">Tandai Selesai</a>
            <a href="laporan_list.php" class="btn-action btn-back">Kembali</a>
        </div>

    </div>

</div>

<!-- =======================================================================
    STYLE (GAYA SAMA DENGAN SK KIP)
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
    align-items: center; /* RATa tengah */
}

/* HEADER */
.page-header h2 {
    color: #4e0a8a;
    font-weight: bold;
    margin-bottom: 25px;
    text-align: center;
}

/* DETAIL CARD */
.detail-card {
    background: white;
    width: 85%;
    max-width: 900px;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
    animation: fadeIn 0.4s ease;
}

.section-title {
    color: #6f2dbd;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 18px;
}

/* DETAIL TABLE */
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

/* BADGE */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    color: white;
    font-size: 13px;
}
.success { background:#2ecc71; }
.info { background:#3498db; }
.pending { background:#f1c40f; color:black; }

/* TOMBOL */
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
    transition: .2s;
}

.btn-warning { background:#ff9f1c; }
.btn-success { background:#2ecc71; }
.btn-back    { background:#6f2dbd; }
.btn-view    { color:#6f2dbd; font-weight:bold; }

.btn-action:hover {
    opacity: .8;
}

/* Animasi */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>
