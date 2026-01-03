<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['level'])) {
    header("Location: ../login.php");
    exit;
}

// Hapus Logic
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    
    // Ambil gambar lama untuk dihapus
    $q = $koneksi->query("SELECT file_gambar FROM mahasiswa_prestasi WHERE id_prestasi=$id");
    if($r = $q->fetch_assoc()){
        $files = json_decode($r['file_gambar'], true);
        if(!is_array($files)) $files = [$r['file_gambar']];
        foreach($files as $f){
            if(!empty($f) && file_exists("../uploads/prestasi/".$f)) unlink("../uploads/prestasi/".$f);
        }
    }
    
    $koneksi->query("DELETE FROM mahasiswa_prestasi WHERE id_prestasi=$id");
    header("Location: prestasi_list.php");
    exit;
}

include 'sidebar.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Prestasi Mahasiswa</title>
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

        .btn-view { background: #e1f5fe; color: #0288d1; }
        .btn-view:hover { background: #0288d1; color: white; }

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

        /* ===== Gallery Thumbnail ===== */
        .gallery-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .gallery-thumbnail:hover {transform: scale(1.1); box-shadow: 0 5px 15px rgba(0,0,0,0.2);}

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
            margin: 5vh auto;
            padding: 30px;
            border-radius: 24px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            animation: modalIn 0.3s ease-out;
            max-height: 90vh;
            overflow-y: auto;
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

        /* Carousel Custom */
        .carousel-view {
            position: relative;
            width: 100%;
            height: 350px;
            background: #f0f0f0;
            border-radius: 15px;
            overflow: hidden;
            margin-top: 20px;
        }
        .carousel-view img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Kelola Mahasiswa Berprestasi</h2>
        <a href="prestasi_form.php" class="btn-add-news">
            <i class="fas fa-plus"></i> Tambah Prestasi
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Mahasiswa</th>
                    <th>Judul Prestasi</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Catatan Revisi</th>
                    <th>Galeri</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = $koneksi->query("SELECT * FROM mahasiswa_prestasi ORDER BY id_prestasi DESC");
                while ($row = $query->fetch_assoc()) {
                    $statusClass = strtolower($row['status']);
                    $catatan = !empty($row['catatan_revisi']) ? htmlspecialchars($row['catatan_revisi']) : "-";
                    
                    // Process Images
                    $imgRaw = $row['file_gambar'];
                    $imgArr = json_decode($imgRaw, true);
                    if(!is_array($imgArr)) $imgArr = !empty($imgRaw) ? [$imgRaw] : [];
                    $imgJson = htmlspecialchars(json_encode($imgArr), ENT_QUOTES, 'UTF-8');
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td style="font-weight: 600; color: #4e0a8a;">
                        <i class="fas fa-user-graduate mr-2"></i>
                        <?= htmlspecialchars($row['nama_mahasiswa']) ?>
                    </td>
                    <td>
                        <div style="font-weight: 600;"><?= htmlspecialchars($row['judul_prestasi']) ?></div>
                        <small class="text-muted"><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($row['tanggal_prestasi'])) ?></small>
                    </td>
                    <td>
                        <?php if(!empty($row['deskripsi'])): ?>
                            <button class="btn btn-detail" onclick="showTextModal('Deskripsi Prestasi', <?= htmlspecialchars(json_encode($row['deskripsi']), ENT_QUOTES, 'UTF-8') ?>)">
                                <i class="fas fa-file-alt"></i> Detail
                            </button>
                        <?php else: ?>
                            <span class="text-muted small">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="status-badge <?= $statusClass ?>">
                            <?= strtoupper(htmlspecialchars($row['status'])) ?>
                        </span>
                    </td>
                    <td>
                        <?php if(!empty($row['catatan_revisi'])): ?>
                            <button class="btn btn-detail" style="color:#d32f2f; background:#fff0f0;" onclick="showTextModal('Catatan Revisi', <?= htmlspecialchars(json_encode($row['catatan_revisi']), ENT_QUOTES, 'UTF-8') ?>)">
                                <i class="fas fa-file-alt"></i> Lihat
                            </button>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($imgArr)): ?>
                            <div style="position:relative; display:inline-block;" onclick='openGallery(<?= $imgJson ?>, "<?= htmlspecialchars($row["judul_prestasi"], ENT_QUOTES) ?>")'>
                                <img src="../uploads/prestasi/<?= $imgArr[0] ?>" class="gallery-thumbnail">
                                <?php if(count($imgArr) > 1): ?>
                                    <span style="position:absolute; bottom:2px; right:2px; background:rgba(0,0,0,0.7); color:white; font-size:10px; padding:2px 5px; border-radius:4px;">+<?= count($imgArr)-1 ?></span>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a class="btn btn-edit" href="prestasi_form.php?id=<?= $row['id_prestasi'] ?>" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-hapus" href="prestasi_list.php?hapus=<?= $row['id_prestasi'] ?>" onclick="return confirm('Hapus prestasi ini?')" title="Hapus">
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

<!-- Modal Text -->
<div id="textModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('textModal')">&times;</span>
        <h3 id="textModalTitle" style="color:#4e0a8a; margin-top:0;">Detail</h3>
        <div id="textModalBody" style="background:#f8f2ff; padding:20px; border-radius:15px; margin-top:15px; border-left:4px solid #7b35d4; line-height:1.6; color:#444;">
        </div>
    </div>
</div>

<!-- Modal Gallery -->
<div id="galleryModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <span class="close" onclick="closeModal('galleryModal')">&times;</span>
        <h3 id="galleryTitle" style="color:#4e0a8a; margin-top:0;">Galeri Foto</h3>
        <div id="galleryContainer" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; justify-content: center;">
        </div>
    </div>
</div>

<script>
function showTextModal(title, content) {
    document.getElementById('textModalTitle').innerText = title;
    // Sangat agresif mengganti semua variasi line break
    let formattedContent = content
        .replace(/\\r\\n/g, '<br>')
        .replace(/\\n/g, '<br>')
        .replace(/\\r/g, '<br>')
        .replace(/\r\n/g, '<br>')
        .replace(/\n/g, '<br>')
        .replace(/\r/g, '<br>');
    document.getElementById('textModalBody').innerHTML = formattedContent;
    document.getElementById('textModal').style.display = "block";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

function openGallery(images, title) {
    document.getElementById('galleryTitle').innerText = title;
    const container = document.getElementById('galleryContainer');
    container.innerHTML = '';
    
    images.forEach(img => {
        const item = document.createElement('div');
        item.style.width = "calc(33.33% - 10px)";
        item.style.minWidth = "150px";
        item.innerHTML = `<img src="../uploads/prestasi/${img}" style="width:100%; height:150px; object-fit:cover; border-radius:10px; border:2px solid #eee;">`;
        container.appendChild(item);
    });
    
    document.getElementById('galleryModal').style.display = "block";
}

window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = "none";
    }
}
</script>

</body>
</html>
