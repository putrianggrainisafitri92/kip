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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Prestasi Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bs-primary: #6f42c1;
            --bs-primary-rgb: 111,66,193;
        }
        body {
            font-family: "Poppins", sans-serif;
            margin:0;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            color: #333;
        }
        .btn-primary { background-color: #6f42c1; border-color: #6f42c1; }
        .btn-primary:hover { background-color: #59359a; border-color: #59359a; }
        .text-primary { color: #6f42c1 !important; }
        .bg-primary { background-color: #6f42c1 !important; }

        .gallery-thumbnail {
            width: 60px; height: 60px; object-fit: cover; border-radius: 8px; cursor: pointer;
            transition: transform 0.2s;
        }
        .gallery-thumbnail:hover { transform: scale(1.1); }
        .carousel-img { height: 70vh; object-fit: contain; background: black; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content" style="margin-left: 260px; padding: 20px;">
    <div class="container-fluid">
        <!-- Judul -->
        <h2 class="mb-4 fw-bold text-white px-4 py-2 rounded" style="background-color: rgba(111,66,193,0.8); display: inline-block;">
            <i class="fas fa-trophy me-2"></i>Kelola Prestasi Mahasiswa
        </h2>

        <!-- Tombol Tambah Prestasi di bawah judul -->
            <div class="mb-4">
                <a href="prestasi_form.php" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Prestasi
                </a>
            </div>
        </div>

        <!-- Tabel prestasi -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Mahasiswa</th>
                                <th>Judul Prestasi</th>
                                <th>Status</th>
                                <th>Galeri</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = $koneksi->query("SELECT * FROM mahasiswa_prestasi ORDER BY id_prestasi DESC");
                            while ($row = $query->fetch_assoc()) {
                                $statusBadge = '';
                                if ($row['status'] == 'pending') $statusBadge = '<span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending</span>';
                                elseif ($row['status'] == 'approved') $statusBadge = '<span class="badge bg-success"><i class="fas fa-check"></i> Approved</span>';
                                elseif ($row['status'] == 'rejected') $statusBadge = '<span class="badge bg-danger"><i class="fas fa-times"></i> Rejected</span>';
                                
                                // Process Images
                                $imgRaw = $row['file_gambar'];
                                $imgArr = json_decode($imgRaw, true);
                                if(!is_array($imgArr)) $imgArr = !empty($imgRaw) ? [$imgRaw] : [];
                                $imgJson = htmlspecialchars(json_encode($imgArr), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($row['judul_prestasi']) ?></div>
                                    <small class="text-muted"><i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($row['tanggal_prestasi'])) ?></small>
                                </td>
                                <td>
                                    <?= $statusBadge ?>
                                    <?php if($row['status'] == 'rejected' && !empty($row['catatan_revisi'])): ?>
                                        <div class="text-danger small mt-1 fst-italic">
                                            revisi: <?= htmlspecialchars($row['catatan_revisi']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!empty($imgArr)): ?>
                                        <div class="position-relative d-inline-block" onclick='openGallery(<?= $imgJson ?>, "<?= htmlspecialchars($row["judul_prestasi"], ENT_QUOTES) ?>")'>
                                            <img src="../uploads/prestasi/<?= $imgArr[0] ?>" class="gallery-thumbnail border">
                                            <?php if(count($imgArr) > 1): ?>
                                                <span class="position-absolute bottom-0 end-0 badge bg-dark opacity-75" style="font-size: 0.6rem;">+<?= count($imgArr)-1 ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="prestasi_form.php?id=<?= $row['id_prestasi'] ?>" class="btn btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-info text-white" title="Lihat Full" onclick='openGallery(<?= $imgJson ?>, "<?= htmlspecialchars($row["judul_prestasi"], ENT_QUOTES) ?>")'>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="prestasi_list.php?hapus=<?= $row['id_prestasi'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Gallery Bootstrap -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-header border-0 p-0 mb-2">
                <h5 class="modal-title text-white" id="galleryTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner rounded" id="carouselInner"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openGallery(images, title) {
    const carouselInner = document.getElementById('carouselInner');
    carouselInner.innerHTML = '';
    document.getElementById('galleryTitle').innerText = title;
    
    if(images.length === 0) return;

    images.forEach((img, index) => {
        const div = document.createElement('div');
        div.className = `carousel-item ${index === 0 ? 'active' : ''}`;
        div.innerHTML = `<img src="../uploads/prestasi/${img}" class="d-block w-100 carousel-img" alt="Prestasi">`;
        carouselInner.appendChild(div);
    });

    const prev = document.querySelector('.carousel-control-prev');
    const next = document.querySelector('.carousel-control-next');
    if(images.length > 1) {
        prev.style.display = 'flex'; next.style.display = 'flex';
    } else {
        prev.style.display = 'none'; next.style.display = 'none';
    }

    const myModal = new bootstrap.Modal(document.getElementById('galleryModal'));
    myModal.show();
}
</script>
</body>
</html>
