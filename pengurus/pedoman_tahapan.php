<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['level']) || $_SESSION['level'] != '11') {
    die("Akses ditolak!");
}

include "../koneksi.php";
include "sidebar.php";

// Fetch data grouped
$categories = ['tahapan_umum', 'snbp', 'utbk', 'kip', 'biaya_hidup'];
$labels = [
    'tahapan_umum' => 'Tahapan Umum 2026',
    'snbp' => 'Proses Seleksi SNBP',
    'utbk' => 'Proses Seleksi UTBK-SNBT',
    'kip' => 'Proses KIP Kuliah',
    'biaya_hidup' => 'Bantuan Biaya Hidup Mahasiswa'
];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tahapan & Jadwal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f2ff; margin: 0; color: #333; }
        .content { margin-left: 230px; padding: 40px; min-height: 100vh; transition: 0.3s ease; }
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header-section h2 { color: #4e0a8a; font-size: 28px; font-weight: 800; position: relative; }
        .header-section h2::after { content: ''; position: absolute; left: 0; bottom: -5px; width: 50px; height: 4px; background: #7b35d4; border-radius: 2px; }
        
        .card { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f3e8ff; padding-bottom: 15px; }
        .card-title { font-size: 20px; font-weight: 700; color: #4e0a8a; display: flex; align-items: center; gap: 10px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f2ff; color: #4e0a8a; padding: 12px; text-align: left; font-weight: 600; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        tr:last-child td { border-bottom: none; }
        
        .btn { padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; transition: 0.3s; cursor: pointer; border: none; }
        .btn-add { background: #4e0a8a; color: white; }
        .btn-add:hover { background: #6a1b9a; }
        .btn-edit { background: #e3f2fd; color: #1565c0; }
        .btn-edit:hover { background: #1565c0; color: white; }
        .btn-hapus { background: #ffebee; color: #c62828; }
        .btn-hapus:hover { background: #c62828; color: white; }

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
            .content { margin-left: 0; padding: 80px 20px; } 
        }
        @media (max-width: 768px) {
            .header-section { flex-direction: column; align-items: flex-start; gap: 10px; }
            .header-section h2 { font-size: 22px; }
            .card { padding: 15px; }
            th, td { padding: 10px; font-size: 13px; }
            .btn { padding: 6px 10px; font-size: 11px; }
            .card-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .btn-add { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section animate-up">
        <h2>Kelola Tahapan & Jadwal</h2>
    </div>

    <?php 
    $delay = 1; 
    foreach ($categories as $cat): 
        $delayTime = $delay * 0.1;
    ?>
        <div class="card animate-up" style="animation-delay: <?= $delayTime ?>s;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-calendar-alt"></i> <?= $labels[$cat] ?>
                </div>
                <a href="pedoman_tahapan_form.php?kategori=<?= $cat ?>" class="btn btn-add">
                    <i class="fas fa-plus"></i> Tambah Item
                </a>
            </div>
            
            <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="35%">Judul</th>
                        <th width="30%">Jadwal / Deskripsi</th>
                        <th width="10%">Urutan</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan WHERE kategori='$cat' ORDER BY urutan ASC");
                    $no = 1;
                    if(mysqli_num_rows($q) > 0) {
                        while ($row = mysqli_fetch_assoc($q)) {
                            // Badge color
                            $badges = [
                                'pending' => 'background:#fff8e1; color:#ffa000',
                                'approved' => 'background:#e8f5e9; color:#2e7d32',
                                'rejected' => 'background:#ffebee; color:#c62828'
                            ];
                            $style = isset($badges[$row['status']]) ? $badges[$row['status']] : '';
                            
                            echo "<tr>
                                <td>{$no}</td>
                                <td>
                                    <div style='font-weight:600; color:#555;'>".htmlspecialchars($row['judul'])."</div>
                                </td>
                                <td>".htmlspecialchars($row['deskripsi'])."</td>
                                <td>{$row['urutan']}</td>
                                <td>
                                    <span style='display:inline-block; padding:4px 8px; border-radius:10px; font-size:11px; font-weight:700; text-transform:uppercase; $style'>
                                        {$row['status']}
                                    </span>";
                                    
                            if($row['status'] == 'rejected' && !empty($row['catatan_revisi'])) {
                                $note = htmlspecialchars($row['catatan_revisi'], ENT_QUOTES);
                                echo "<br><button class='btn' style='background:#ffebee; color:#c62828; font-size:10px; padding:3px 8px; margin-top:5px; border-radius:10px; border:1px solid #ffcdd2;' onclick='showRevisi(\"$note\")'>
                                    <i class='fas fa-eye'></i> Lihat Revisi
                                </button>";
                            }

                            echo "</td>
                                <td>
                                    <div style='display:flex; gap:5px;'>
                                        <a href='pedoman_tahapan_form.php?id={$row['id']}' class='btn btn-edit'><i class='fas fa-edit'></i></a>
                                        <a href='javascript:void(0)' onclick='confirmDelete({$row['id']})' class='btn btn-hapus'><i class='fas fa-trash'></i></a>
                                    </div>
                                </td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center' style='padding:20px; text-align:center; color:#888;'>Belum ada data.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    <?php 
        $delay++;
    endforeach; ?>

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

<script>
function confirmDelete(id) {
    if(confirm('Yakin ingin menghapus item ini?')) {
        window.location = 'pedoman_tahapan_hapus.php?id=' + id;
    }
}

function showRevisi(text) {
    document.getElementById('revisiContent').innerText = text;
    document.getElementById('viewRevisiModal').style.display = 'block';
}

function closeRevisiModal() {
    document.getElementById('viewRevisiModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    var modal = document.getElementById('viewRevisiModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
