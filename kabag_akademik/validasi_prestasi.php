<?php
session_start();
include '../protect.php';
check_level(13); 
include '../koneksi.php';

// Logic APPROVE
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $koneksi->query("UPDATE mahasiswa_prestasi SET status='approved', catatan_revisi=NULL WHERE id_prestasi=$id");
    header("Location: validasi_prestasi.php?pesan=approved");
    exit;
}

// Logic REJECT
if (isset($_POST['reject'])) {
    $id = intval($_POST['id_prestasi']);
    $catatan = $koneksi->real_escape_string($_POST['catatan_revisi']);
    
    if(!empty($catatan)){
        $koneksi->query("UPDATE mahasiswa_prestasi SET status='rejected', catatan_revisi='$catatan' WHERE id_prestasi=$id");
    }
    header("Location: validasi_prestasi.php?pesan=rejected");
    exit;
}

include 'sidebar.php';

// Filter data
$filter_query = "";
if(isset($_GET['filter']) && $_GET['filter'] == 'pending') {
    $filter_query = "WHERE status='pending'";
}

$q = $koneksi->query("SELECT * FROM mahasiswa_prestasi $filter_query ORDER BY FIELD(status, 'pending', 'approved', 'rejected'), id_prestasi DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Validasi Prestasi - Kabag Akademik</title>
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

        .content {
            margin-left: 240px;
            padding: 40px;
            min-height: 100vh;
            transition: 0.3s ease;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-section h2 {
            color: #4e0a8a;
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            position: relative;
        }
        .header-section h2::after {
            content: '';
            position: absolute;
            left: 0; bottom: -5px;
            width: 50px; height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }
        .tab-link {
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            color: #7b35d4;
            background: #f0e6ff;
            transition: 0.3s;
            border: 1px solid transparent;
        }
        .tab-link.active {
            background: #7b35d4;
            color: white;
            box-shadow: 0 4px 12px rgba(123, 53, 212, 0.2);
        }
        .tab-link:hover:not(.active) {
            background: #e1d0ff;
        }

        .table-container {
            background: white;
            padding: 15px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow-x: auto;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th {
            background: #4e0a8a;
            color: white;
            padding: 18px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }

        th:first-child { border-radius: 12px 0 0 12px; }
        th:last-child { border-radius: 0 12px 12px 0; }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fbf9ff; }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
        }
        .pending { background: #fff8e1; color: #ffa000; border: 1px solid #ffe082; }
        .approved { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .rejected { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

        .btn {
            padding: 8px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-approve { background: #e8f5e9; color: #2e7d32; }
        .btn-approve:hover { background: #2e7d32; color: white; transform: translateY(-2px); }

        .btn-reject { background: #ffebee; color: #c62828; }
        .btn-reject:hover { background: #c62828; color: white; transform: translateY(-2px); }

        .btn-view { background: #f3e8ff; color: #7b35d4; }
        .btn-view:hover { background: #7b35d4; color: white; transform: translateY(-2px); }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10001;
            inset: 0;
            background: rgba(0,0,0,0.5);
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
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: modalScale 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalScale {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        .close {
            position: absolute;
            right: 25px; top: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #ccc;
        }

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
            margin: 20px 0;
        }

        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 85px 15px 40px 15px; }
            .header-section h2 { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Validasi Prestasi Mahasiswa</h2>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="validasi_prestasi.php" class="tab-link <?= !isset($_GET['filter']) ? 'active' : '' ?>">Semua Data</a>
        <a href="validasi_prestasi.php?filter=pending" class="tab-link <?= isset($_GET['filter']) && $_GET['filter'] == 'pending' ? 'active' : '' ?>">Perlu Validasi</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">No</th>
                    <th style="width: 250px;">Data Prestasi</th>
                    <th>Deskripsi</th>
                    <th style="text-align:center;">Bukti</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Catatan Revisi</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = $q->fetch_assoc()){
                    $status = strtolower($row['status']);
                    $catatan = !empty($row['catatan_revisi']) ? htmlspecialchars($row['catatan_revisi']) : "Belum ada catatan.";
                    $modalId = "notes-" . $row['id_prestasi'];
                ?>
                <tr>
                    <td style="text-align:center; color: #888; font-weight: 600;"><?= $no++ ?></td>
                    <td>
                        <div style="font-weight: 700; color: #4e0a8a; margin-bottom: 3px;">
                            <?= htmlspecialchars($row['judul_prestasi']) ?>
                        </div>
                        <div style="font-size: 0.85rem; color: #666; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-user-graduate" style="opacity: 0.5;"></i> <?= htmlspecialchars($row['nama_mahasiswa']) ?>
                        </div>
                        <div style="font-size: 0.75rem; color: #999; margin-top: 5px;">
                            <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($row['tanggal_prestasi'])) ?>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem; color: #666; max-height: 60px; overflow: hidden; line-height: 1.4;">
                            <?= nl2br(htmlspecialchars($row['deskripsi'])) ?>
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <?php 
                        $imgRaw = $row['file_gambar'];
                        $imgArr = json_decode($imgRaw, true);
                        if(!is_array($imgArr)) $imgArr = !empty($imgRaw) ? [$imgRaw] : [];
                        
                        if(!empty($imgArr) && !empty($imgArr[0])): 
                            $firstImg = $imgArr[0];
                        ?>
                            <a href="../uploads/prestasi/<?= $firstImg ?>" target="_blank" style="display:inline-block; position:relative;">
                                <img src="../uploads/prestasi/<?= $firstImg ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 2px solid white;">
                                <?php if(count($imgArr) > 1): ?>
                                    <span style="position:absolute; bottom:-5px; right:-5px; background: #7b35d4; color:white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: 700;">+<?= count($imgArr)-1 ?></span>
                                <?php endif; ?>
                            </a>
                        <?php else: ?>
                            <span style="color: #bbb;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <span class="badge <?= $status ?>"><?= strtoupper($status) ?></span>
                    </td>
                    <td style="text-align:center;">
                        <?php if($status == 'rejected' || $status == 'revisi'): ?>
                            <button class="btn btn-view" onclick="openModal('<?= $modalId ?>')">
                                <i class="fas fa-comment-dots"></i> Lihat
                            </button>

                            <!-- MODAL LIHAT CATATAN -->
                            <div id="<?= $modalId ?>" class="modal">
                                <div class="modal-content text-left" style="text-align: left;">
                                    <span class="close" onclick="closeModal('<?= $modalId ?>')">&times;</span>
                                    <h3 style="color: #4e0a8a; font-weight: 700; margin-top: 0;">Catatan Revisi</h3>
                                    <div style="background: #f8f2ff; padding: 20px; border-radius: 15px; margin-top: 20px; border-left: 5px solid #7b35d4; color: #444; font-size: 0.95rem; line-height: 1.6;">
                                        <?= nl2br($catatan) ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <span style="color: #bbb;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <div style="display: flex; flex-direction: column; gap: 6px; align-items: center;">
                            <?php if($status == 'pending' || $status == 'rejected'): ?>
                                <a href="validasi_prestasi.php?approve=<?= $row['id_prestasi'] ?>" class="btn btn-approve" style="width: 100%; justify-content: center;" onclick="return confirm('Setujui prestasi ini?')">
                                    <i class="fas fa-check"></i> Approve
                                </a>
                            <?php endif; ?>
                            
                            <?php if($status == 'pending' || $status == 'approved'): ?>
                                <button type="button" class="btn btn-reject" style="width: 100%; justify-content: center;" onclick="openRejectModal(<?= $row['id_prestasi'] ?>)">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if($q->num_rows == 0): ?>
                    <tr><td colspan="7" style="text-align:center; padding: 40px; color: #999; font-style: italic;">Belum ada data prestasi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRejectModal()">&times;</span>
        <h3 style="text-align:center; color:#4e0a8a; font-weight:800; margin-top:0;">Minta Revisi</h3>
        <form method="POST">
            <input type="hidden" name="id_prestasi" id="rejectId">
            <textarea name="catatan_revisi" required placeholder="Jelaskan alasan penolakan atau revisi yang diperlukan secara jelas..."></textarea>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <button type="button" class="btn" style="background:#f1f1f1; color:#666; justify-content:center;" onclick="closeRejectModal()">Batal</button>
                <button type="submit" name="reject" class="btn" style="background:#c62828; color:white; justify-content:center;">Kirim Revisi</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'block';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
function openRejectModal(id) {
    document.getElementById('rejectId').value = id;
    openModal('rejectModal');
}
function closeRejectModal() {
    closeModal('rejectModal');
}
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target == modal) modal.style.display = 'none';
    });
}
</script>

</body>
</html>
