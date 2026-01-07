<?php
session_start();
include '../protect.php';
check_level(13); // Kabag Akademik
include '../koneksi.php';
include 'sidebar.php';

// Ambil semua batch file (grouping berdasarkan skema + tahun)
// Mengambil catatan_revisi juga
$q = mysqli_query($koneksi, "
    SELECT skema, tahun, id_admin, COUNT(*) AS total,
           MAX(status) AS status_batch,
           MAX(catatan_revisi) AS catatan_batch
    FROM mahasiswa_kip
    GROUP BY skema, tahun, id_admin
    ORDER BY tahun DESC, skema
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Validasi Jumlah KIP - Kabag Akademik</title>
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

        /* ===== Content Wrapper ===== */
        .content {
            margin-left: 240px;
            padding: 40px;
            min-height: 100vh;
            transition: 0.3s ease;
        }

        /* ===== Title ===== */
        .header-section {
            margin-bottom: 30px;
        }

        .header-section h2 {
            color: #4e0a8a;
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            position: relative;
            display: inline-block;
        }
        .header-section h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 50px;
            height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        /* Responsif Mobile */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 85px 15px 40px 15px;
            }
            .header-section h2 { font-size: 22px; }
        }

        /* ===== Table Container ===== */
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

        /* ===== Badges ===== */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pending { background: #fff8e1; color: #ffa000; border: 1px solid #ffe082; }
        .approved { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .rejected, .revisi { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

        /* ===== Buttons ===== */
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

        .btn-detail { background: #e3f2fd; color: #1976d2; }
        .btn-detail:hover { background: #1976d2; color: white; transform: translateY(-2px); }

        .btn-approve { background: #e8f5e9; color: #2e7d32; }
        .btn-approve:hover { background: #2e7d32; color: white; transform: translateY(-2px); }

        .btn-reject { background: #ffebee; color: #c62828; }
        .btn-reject:hover { background: #c62828; color: white; transform: translateY(-2px); }

        .btn-view { background: #f3e8ff; color: #7b35d4; }
        .btn-view:hover { background: #7b35d4; color: white; transform: translateY(-2px); }

        /* ===== Modal ===== */
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
            right: 25px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #ccc;
            transition: 0.3s;
        }
        .close:hover { color: #4e0a8a; }

        .modal-header h3 {
            margin: 0;
            color: #4e0a8a;
            font-weight: 700;
            text-align: center;
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
        textarea:focus { border-color: #7b35d4; }

        .catatan-box {
            background: #f8f2ff;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
            border-left: 5px solid #7b35d4;
            color: #444;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .modal-btns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-send {
            background: #c62828;
            color: white;
            justify-content: center;
        }

        /* SEARCH & ANIMATION */
        .table-container { animation: fadeInUp 0.8s ease-out; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .search-box { margin-bottom: 20px; position: relative; animation: fadeInUp 0.6s ease-out; }
        .search-input { width: 100%; padding: 15px 45px 15px 20px; border-radius: 12px; border: 1px solid #e0e0e0; font-family: 'Poppins', sans-serif; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.03); box-sizing: border-box; }
        .search-input:focus { border-color: #7b35d4; box-shadow: 0 8px 20px rgba(123, 53, 212, 0.1); outline: none; }
        .search-icon { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 18px; }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Validasi Jumlah KIP</h2>
    </div>

    <div class="table-container">
        <div class="search-box">
            <input type="text" id="searchInput" class="search-input" placeholder="Cari Skema, Tahun, atau Pengunggah...">
            <i class="fas fa-search search-icon"></i>
        </div>
        
        <table id="dataTable">
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">No</th>
                    <th>Skema / Tahun</th>
                    <th>Pengunggah</th>
                    <th style="text-align:center;">Total Mhs</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Catatan Revisi</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($batch = mysqli_fetch_array($q)) { 
                    $admin_username = 'Admin / Import'; // Default fallback if id_admin is missing
                    if(!empty($batch['id_admin'])){
                        $st = $koneksi->prepare("SELECT username FROM admin WHERE id_admin = ?");
                        $st->bind_param("i", $batch['id_admin']);
                        $st->execute();
                        $res = $st->get_result();
                        $admin = $res->fetch_assoc();
                        if($admin) $admin_username = $admin['username'];
                    }

                    $statusLower = strtolower($batch['status_batch'] ?? 'pending');
                    $skema = $batch['skema'];
                    $tahun = $batch['tahun'];
                    $catatan = !empty($batch['catatan_batch']) ? htmlspecialchars($batch['catatan_batch']) : "Belum ada catatan.";
                    $batchId = "batch-" . $no;
                ?>
                <tr>
                    <td style="text-align:center; font-weight: 600; color: #888;"><?= $no; ?></td>
                    <td style="font-weight: 600; color: #4e0a8a;">
                        <i class="fas fa-folder-open mr-2" style="opacity: 0.5;"></i>
                        <?= htmlspecialchars($skema) ?> / <?= $tahun ?>
                    </td>
                    <td>
                        <i class="fas fa-user-circle mr-1" style="opacity: 0.5;"></i>
                        <?= htmlspecialchars($admin_username) ?>
                    </td>
                    <td style="text-align:center; font-weight: 700; color: #4e0a8a;">
                        <?= $batch['total'] ?>
                    </td>
                    <td style="text-align:center;">
                        <span class="badge <?= $statusLower ?>">
                            <?= strtoupper($statusLower) ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <?php if($statusLower == 'rejected' || $statusLower == 'revisi'): ?>
                            <button class="btn btn-view" onclick="openModal('notes-<?= $batchId ?>')">
                                <i class="fas fa-comment-dots"></i> Lihat
                            </button>

                            <!-- MODAL LIHAT CATATAN -->
                            <div id="notes-<?= $batchId ?>" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal('notes-<?= $batchId ?>')">&times;</span>
                                    <div class="modal-header">
                                        <h3>Catatan Revisi</h3>
                                    </div>
                                    <div class="catatan-box">
                                        <?= nl2br($catatan) ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <span style="color: #bbb;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="validasi_kip_detail.php?skema=<?= urlencode($skema); ?>&tahun=<?= $tahun; ?>" class="btn btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                            <?php if($statusLower != 'approved'): ?>
                                <a href="validasi_kip_proses.php?skema=<?= urlencode($skema); ?>&tahun=<?= $tahun; ?>&status=approved" 
                                   class="btn btn-approve" onclick="return confirm('Setujui semua mahasiswa pada batch ini?')">
                                    <i class="fas fa-check"></i> Approve
                                </a>

                                <button class="btn btn-reject" onclick="openModal('reject-<?= $batchId ?>')">
                                    <i class="fas fa-times"></i> Reject
                                </button>

                                <!-- MODAL REJECT (INPUT CATATAN) -->
                                <div id="reject-<?= $batchId ?>" class="modal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Catatan Revisi</h3>
                                        </div>
                                        <form action="validasi_kip_proses.php" method="GET">
                                            <input type="hidden" name="skema" value="<?= $skema ?>">
                                            <input type="hidden" name="tahun" value="<?= $tahun ?>">
                                            <input type="hidden" name="status" value="rejected">

                                            <textarea name="catatan" placeholder="Tulis alasan penolakan atau bagian yang perlu diperbaiki..." required></textarea>
                                            
                                            <div class="modal-btns">
                                                <button type="button" class="btn" style="background:#f1f1f1; color:#666; justify-content:center;" onclick="closeModal('reject-<?= $batchId ?>')">Batal</button>
                                                <button type="submit" class="btn btn-send">Kirim Revisi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php $no++; } ?>
                <?php if(mysqli_num_rows($q) == 0): ?>
                    <tr><td colspan="7" style="text-align:center; padding: 40px; color: #999; font-style: italic;">Belum ada data KIP.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function openModal(id){
    document.getElementById(id).style.display = "block";
}
function closeModal(id){
    document.getElementById(id).style.display = "none";
}

window.onclick = function(event){
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if(event.target == modal){
            modal.style.display = "none";
        }
    });
}
</script>

<script>
    // Live Search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

</body>
</html>
