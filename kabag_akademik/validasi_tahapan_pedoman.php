<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['level']) || $_SESSION['level'] != '13') { // Level 13 is kabag
    die("Akses ditolak!");
}

include "../koneksi.php";
include "sidebar.php";

$q = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan ORDER BY status ASC, id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Validasi Tahapan & Jadwal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f2ff; margin: 0; color: #333; }
        .content { margin-left: 230px; padding: 40px; min-height: 100vh; transition: 0.3s ease; }
        .header-section { margin-bottom: 30px; }
        .header-section h2 { color: #4e0a8a; font-size: 28px; font-weight: 800; border-bottom: 4px solid #7b35d4; display: inline-block; padding-bottom: 5px; }

        .table-responsive { background: white; padding: 20px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { background: #4e0a8a; color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        
        .badge { padding: 5px 10px; border-radius: 15px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-pending { background: #fff8e1; color: #ffa000; }
        .badge-approved { background: #e8f5e9; color: #2e7d32; }
        .badge-rejected { background: #ffebee; color: #c62828; }

        .btn { padding: 8px 12px; border-radius: 8px; color: white; border: none; cursor: pointer; text-decoration: none; font-size: 12px; display: inline-flex; align-items: center; gap: 5px; }
        .btn-approve { background: #2e7d32; }
        .btn-reject { background: #c62828; }
        .btn:hover { opacity: 0.9; }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 9999; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(2px); }
        .modal-content { background: white; margin: 15vh auto; padding: 30px; border-radius: 15px; width: 90%; max-width: 500px; box-shadow: 0 20px 50px rgba(0,0,0,0.2); }
        .close { float: right; font-size: 24px; cursor: pointer; }

        /* ANIMATIONS */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-up {
            animation: fadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) { 
            .content { margin-left: 0; padding: 30px 20px; } 
        }
        @media (max-width: 768px) {
            .header-section h2 { font-size: 24px; }
            th, td { padding: 10px; font-size: 13px; }
            .btn { font-size: 11px; padding: 6px 10px; }
            .table-responsive { padding: 15px; }
        }

        .search-box { margin-bottom: 20px; position: relative; animation: fadeInUp 0.6s ease-out; }
        .search-input { width: 100%; padding: 15px 45px 15px 20px; border-radius: 12px; border: 1px solid #e0e0e0; font-family: 'Poppins'; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.03); box-sizing: border-box; }
        .search-input:focus { border-color: #7b35d4; box-shadow: 0 8px 20px rgba(123, 53, 212, 0.1); outline: none; }
        .search-icon { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 18px; }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section animate-up">
        <h2>Validasi Tahapan & Jadwal</h2>
    </div>

    <div class="search-box">
        <input type="text" id="searchInput" class="search-input" placeholder="Cari Tahapan...">
        <i class="fas fa-search search-icon"></i>
    </div>

    <div class="table-responsive animate-up" style="animation-delay: 0.1s;">
        <table>
            <thead>
                <tr>
                    <th>Judul Tahapan</th>
                    <th>Jadwal / Deskripsi</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td style="font-weight: 600; color:#4e0a8a;"><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td><?= ucwords(str_replace('_', ' ', $row['kategori'])) ?></td>
                    <td>
                        <span class="badge badge-<?= strtolower($row['status']) ?>">
                            <?= strtoupper($row['status']) ?>
                        </span>
                        <?php if(!empty($row['catatan_revisi'])): ?>
                            <?php $note = htmlspecialchars($row['catatan_revisi'], ENT_QUOTES); ?>
                            <br><button class="btn" style="background:#ffebee; color:#c62828; font-size:10px; padding:3px 8px; margin-top:5px; border-radius:10px; border:1px solid #ffcdd2;" onclick="showRevisi('<?= $note ?>')">
                                <i class="fas fa-eye"></i> Lihat Revisi
                            </button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['status'] == 'pending'): ?>
                            <div style="display:flex; gap:5px;">
                                <a href="validasi_tahapan_proses.php?act=approve&id=<?= $row['id'] ?>" class="btn btn-approve" onclick="return confirm('Setujui item ini?')">
                                    <i class="fas fa-check"></i> Acc
                                </a>
                                <button class="btn btn-reject" onclick="openRejectModal(<?= $row['id'] ?>)">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                        <?php else: ?>
                            <span class="text-muted" style="font-size:12px;">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal View Revisi -->
<div id="viewRevisiModal" class="modal" style="display:none; position:fixed; z-index:9999; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(2px);">
    <div class="modal-content" style="background:white; margin:20vh auto; padding:25px; border-radius:15px; width:90%; max-width:400px; box-shadow:0 10px 30px rgba(0,0,0,0.2);">
        <span onclick="closeRevisiModal()" style="float:right; font-size:24px; cursor:pointer; color:#aaa;">&times;</span>
        <h3 style="color:#c62828; margin-top:0; font-size:18px; border-bottom:1px solid #eee; padding-bottom:10px;">
            <i class="fas fa-exclamation-circle"></i> Catatan Revisi
        </h3>
        <div id="revisiContent" style="margin-top:15px; line-height:1.6; color:#555; background:#fff8e1; padding:15px; border-radius:8px; border-left:4px solid #ffa000; max-height: 60vh; overflow-y: auto; word-wrap: break-word; white-space: pre-wrap;"></div>
        <div style="text-align:right; margin-top:15px;">
            <button onclick="closeRevisiModal()" style="padding:8px 20px; background:#4e0a8a; color:white; border:none; border-radius:8px; cursor:pointer;">Tutup</button>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3 style="color:#c62828; margin-top:0;">Tolak & Revisi</h3>
        <form action="validasi_tahapan_proses.php" method="POST">
            <input type="hidden" name="act" value="reject">
            <input type="hidden" name="id" id="rejectId">
            <div style="margin-bottom:15px;">
                <label>Alasan Penolakan / Catatan Revisi:</label>
                <textarea name="catatan" required style="width:100%; height:100px; padding:10px; border:1px solid #ddd; border-radius:8px; margin-top:5px;"></textarea>
            </div>
            <button type="submit" class="btn btn-reject" style="width:100%; justify-content:center;">Kirim Penolakan</button>
        </form>
    </div>
</div>

<script>
function openRejectModal(id) {
    document.getElementById('rejectId').value = id;
    document.getElementById('rejectModal').style.display = 'block';
}
function closeModal() {
    document.getElementById('rejectModal').style.display = 'none';
}

function showRevisi(text) {
    document.getElementById('revisiContent').innerText = text;
    document.getElementById('viewRevisiModal').style.display = 'block';
}

function closeRevisiModal() {
    document.getElementById('viewRevisiModal').style.display = 'none';
}

window.onclick = function(e) {
    if(e.target == document.getElementById('rejectModal')) closeModal();
    if(e.target == document.getElementById('viewRevisiModal')) closeRevisiModal();
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