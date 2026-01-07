<?php
session_start();
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

$q = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Validasi Berita - Kabag Akademik</title>
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
            min-width: 900px;
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

        .btn-view { background: #f3e8ff; color: #7b35d4; }
        .btn-view:hover { background: #7b35d4; color: white; transform: translateY(-2px); }

        .btn-detail { background: #e3f2fd; color: #1976d2; }
        .btn-detail:hover { background: #1976d2; color: white; transform: translateY(-2px); }

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
        }

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

        .search-box { margin-bottom: 20px; position: relative; animation: fadeInUp 0.6s ease-out; }
        .search-input { width: 100%; padding: 15px 45px 15px 20px; border-radius: 12px; border: 1px solid #e0e0e0; font-family: 'Poppins'; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.03); box-sizing: border-box; }
        .search-input:focus { border-color: #7b35d4; box-shadow: 0 8px 20px rgba(123, 53, 212, 0.1); outline: none; }
        .search-icon { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 18px; }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Validasi Berita</h2>
    </div>

    <div class="search-box">
        <input type="text" id="searchInput" class="search-input" placeholder="Cari Berita...">
        <i class="fas fa-search search-icon"></i>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Judul Berita</th>
                    <th>Tgl Kegiatan</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Catatan Revisi</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($d = mysqli_fetch_assoc($q)) { 
                    $statusLower = strtolower($d['status']);
                    $id = $d['id_berita'];
                    $catatan = !empty($d['catatan_revisi']) ? htmlspecialchars($d['catatan_revisi']) : "Belum ada catatan.";
                ?>
                <tr>
                    <td style="font-weight: 600; color: #4e0a8a;">
                        <i class="fas fa-newspaper mr-2" style="opacity: 0.6;"></i>
                        <?= htmlspecialchars($d['judul']) ?>
                    </td>
                    <td><?= !empty($d['tanggal_kegiatan']) ? date('d M Y', strtotime($d['tanggal_kegiatan'])) : "-" ?></td>
                    <td style="text-align:center;">
                        <span class="badge <?= $statusLower ?>">
                            <?= strtoupper(htmlspecialchars($d['status'])) ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <?php if($statusLower == 'rejected' || $statusLower == 'revisi'): ?>
                            <button class="btn btn-view" onclick="openModal('modal-<?= $id ?>')">
                                <i class="fas fa-comment-dots"></i> Lihat
                            </button>

                            <div id="modal-<?= $id ?>" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal('modal-<?= $id ?>')">&times;</span>
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
                        <a href="validasi_berita_detail.php?id=<?= $id ?>" class="btn btn-detail">
                            <i class="fas fa-eye"></i> Detail & Validasi
                        </a>
                    </td>
                </tr>
                <?php } ?>
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

</body>
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
