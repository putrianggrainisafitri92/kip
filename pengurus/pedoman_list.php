<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['level']) || $_SESSION['level'] != '11') {
    die("Akses ditolak!");
}

include "../koneksi.php";
include "sidebar.php";

$q = mysqli_query($koneksi, "SELECT * FROM pedoman ORDER BY id_pedoman DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pedoman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f2ff;
            margin: 0;
            color: #333;
        }

        /* ===== Content Wrapper ===== */
        .content {
            margin-left: 230px;
            padding: 40px;
            min-height: 100vh;
            transition: 0.3s ease;
        }

        /* ===== Title ===== */
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
            left: 0;
            bottom: -5px;
            width: 50px;
            height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        /* Responsif Mobile */
        @media (max-width: 992px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
            .header-section h2 { font-size: 22px; }
        }

        /* ===== Table Container ===== */
        .table-responsive {
            background: white;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th {
            background: #4e0a8a;
            color: white;
            padding: 18px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
            border: none;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }

        tr:hover td {
            background: #fbf9ff;
        }

        /* ===== Badges ===== */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
        }
        .pending { background: #fff8e1; color: #ffa000; }
        .approved { background: #e8f5e9; color: #2e7d32; }
        .revisi, .rejected { background: #ffebee; color: #c62828; }

        /* ===== Buttons ===== */
        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-edit { background: #f3e8ff; color: #7b35d4; }
        .btn-edit:hover { background: #7b35d4; color: white; }

        .btn-hapus { background: #fff0f0; color: #d32f2f; }
        .btn-hapus:hover { background: #d32f2f; color: white; }

        .btn-detail { background: #e0f2f1; color: #00897b; }
        .btn-detail:hover { background: #00897b; color: white; }

        .btn-download { background: #e1f5fe; color: #0288d1; }
        .btn-download:hover { background: #0288d1; color: white; }

        .btn-add-news {
            background: #4e0a8a;
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(78, 10, 138, 0.2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }
        .btn-add-news:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(78, 10, 138, 0.3);
            color: white;
            background: #5a189a;
        }

        /* ===== Modal ===== */
        .modal {
            display:none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            padding: 20px;
        }

        .modal-content {
            background: white;
            margin: 10vh auto;
            padding: 30px;
            border-radius: 24px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            animation: modalIn 0.3s ease-out;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
            color: #aaa;
            line-height: 1;
        }
        .close:hover { color: #4e0a8a; }
    </style>
</head>

<body>

<div class="content">
    <div class="header-section">
        <h2>Kelola Pedoman</h2>
        <a href="pedoman_upload.php" class="btn-add-news">
            <i class="fas fa-plus"></i> Upload Pedoman
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama File Pedoman</th>
                    <th>Status</th>
                    <th>Catatan Revisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($q)) { 
                    $statusClass = strtolower($row['status']);
                    $catatan = !empty($row['catatan_revisi']) ? htmlspecialchars($row['catatan_revisi']) : "-";
                ?>
                <tr>
                    <td style="font-weight: 600; color: #4e0a8a;">
                        <i class="far fa-file-pdf mr-2" style="color: #d32f2f;"></i>
                        <?= htmlspecialchars($row['nama_file']) ?>
                    </td>
                    <td>
                        <span class="status-badge <?= $statusClass ?>">
                            <?= strtoupper(htmlspecialchars($row['status'])) ?>
                        </span>
                    </td>
                    <td>
                        <?php if(!empty($row['catatan_revisi'])): ?>
                            <button class="btn btn-detail" onclick="showModal('modal-<?= $row['id_pedoman'] ?>')">
                                <i class="fas fa-comment-dots"></i> Lihat
                            </button>

                            <!-- Modal -->
                            <div id="modal-<?= $row['id_pedoman'] ?>" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal('modal-<?= $row['id_pedoman'] ?>')">&times;</span>
                                    <h3 style="color:#4e0a8a; margin-top:0;">Catatan Revisi</h3>
                                    <div style="background:#f8f2ff; padding:15px; border-radius:12px; margin-top:15px; border-left:4px solid #7b35d4;">
                                        <?= nl2br($catatan) ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:8px; flex-wrap: wrap;">
                            <?php if(!empty($row['file_path'])) { ?>
                                <a class="btn btn-download" href="/KIPWEB/<?= htmlspecialchars($row['file_path']) ?>" target="_blank">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            <?php } ?>

                            <a class="btn btn-edit" href="edit_pedoman.php?id=<?= $row['id_pedoman'] ?>">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-hapus" href="javascript:void(0);" onclick="confirmDelete(<?= $row['id_pedoman'] ?>)">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function showModal(id){
    document.getElementById(id).style.display = "block";
}
function closeModal(id){
    document.getElementById(id).style.display = "none";
}
function confirmDelete(id){
    if(confirm("Hapus pedoman ini?")){
        window.location = "hapus_pedoman.php?id=" + id;
    }
}

// Close modal if click outside
window.onclick = function(event){
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal){
        if(event.target == modal){
            modal.style.display = "none";
        }
    });
}
</script>

</body>
</html>
