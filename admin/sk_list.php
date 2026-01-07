<?php 
include "../koneksi.php";
include "protect.php";
include "sidebar.php";

if(isset($_GET['hapus'])){
    $id = intval($_GET['hapus']);
    $stmt = $koneksi->prepare("DELETE FROM sk_kipk WHERE id_sk_kipk=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>
            alert('Data berhasil dihapus');
            window.location='sk_list.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar SK KIP-K</title>
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
            animation: fadeInUp 0.8s ease-out; /* Animation Added */
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Search Box Style */
        .search-box {
            margin-bottom: 20px;
            position: relative;
            animation: fadeInUp 0.6s ease-out;
        }
        .search-input {
            width: 100%;
            padding: 15px 45px 15px 20px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            box-sizing: border-box;
        }
        .search-input:focus {
            border-color: #7b35d4;
            box-shadow: 0 8px 20px rgba(123, 53, 212, 0.1);
            outline: none;
        }
        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 18px;
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
        tr:hover td { background: #fbf9ff; }

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
        .rejected { background: #ffebee; color: #c62828; }

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
        <h2>Daftar SK KIP-K</h2>
        <a href="sk_add.php" class="btn-add-news">
            <i class="fas fa-plus"></i> Tambah SK
        </a>
    </div>



    <div class="search-box">
        <input type="text" id="searchInput" class="search-input" placeholder="Filter Cepat (Client Side)...">
        <i class="fas fa-search search-icon"></i>
    </div>

    <div class="table-responsive">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama SK</th>
                    <th>Tahun</th>
                    <th>Nomor SK</th>
                    <th>Status</th>
                    <th>Catatan Revisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = $koneksi->query("SELECT * FROM sk_kipk ORDER BY id_sk_kipk DESC");
                $no = 1;
                while($d = $q->fetch_assoc()):
                    $id = intval($d['id_sk_kipk']);
                    $status = strtolower(trim($d['status']));
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td style="font-weight: 600; color: #4e0a8a;"><?= htmlspecialchars($d['nama_sk']); ?></td>
                    <td><?= htmlspecialchars($d['tahun']); ?></td>
                    <td><?= htmlspecialchars($d['nomor_sk']); ?></td>
                    <td>
                        <span class="status-badge <?= $status ?>"><?= strtoupper($status) ?></span>
                    </td>
                    <td>
                        <?php if($status == 'rejected' && (!empty($d['catatan_revisi']))): ?>
                            <button class="btn btn-detail" onclick="openModal('modal-<?= $id ?>')">
                                <i class="fas fa-comment-dots"></i> Lihat
                            </button>

                            <div id="modal-<?= $id ?>" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal('modal-<?= $id ?>')">&times;</span>
                                    <h3 style="color:#4e0a8a; margin-top:0;">Catatan Revisi</h3>
                                    <div style="background:#f8f2ff; padding:15px; border-radius:12px; margin-top:15px; border-left:4px solid #7b35d4;">
                                        <?= nl2br(htmlspecialchars($d['catatan_revisi'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="sk_edit.php?id=<?= $id; ?>" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="sk_list.php?hapus=<?= $id; ?>" class="btn btn-hapus" onclick="return confirm('Hapus SK ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
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
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = "none";
    }
}
</script>

</div>

<script>
    // Live Search Script
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dataTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

</body>
</html>
