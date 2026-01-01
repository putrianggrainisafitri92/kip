<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['level'])) { // Sesuaikan level kabag
    header("Location: ../login.php");
    exit;
}

// Logic APPROVE
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $koneksi->query("UPDATE mahasiswa_prestasi SET status='approved', catatan_revisi=NULL WHERE id_prestasi=$id");
    header("Location: validasi_prestasi.php");
    exit;
}

// Logic REJECT
if (isset($_POST['reject'])) {
    $id = intval($_POST['id_prestasi']);
    $catatan = $koneksi->real_escape_string($_POST['catatan_revisi']);
    
    if(!empty($catatan)){
        $koneksi->query("UPDATE mahasiswa_prestasi SET status='rejected', catatan_revisi='$catatan' WHERE id_prestasi=$id");
    }
    header("Location: validasi_prestasi.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Validasi Prestasi Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bs-primary: #6f42c1; /* Purple */
            --bs-primary-rgb: 111, 66, 193;
        }
        .btn-primary { background-color: #6f42c1 !important; border-color: #6f42c1 !important; }
        .btn-primary:hover { background-color: #59359a !important; border-color: #59359a !important; }
        .text-primary { color: #6f42c1 !important; }
        .nav-tabs .nav-link.active { color: #6f42c1; border-bottom: 2px solid #6f42c1; }
        .nav-tabs .nav-link { color: #555; }
    </style>
</head>
<body class="bg-light">

    <?php include 'sidebar.php'; ?>

    <div class="main-content" style="margin-left: 260px; padding: 20px;">
        <div class="container-fluid">
            <h2 class="mb-4 text-primary fw-bold"><i class="fas fa-check-double me-2"></i>Validasi Prestasi</h2>

            <!-- TABS FILTER -->
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?= !isset($_GET['filter']) ? 'active' : '' ?>" href="validasi_prestasi.php">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isset($_GET['filter']) && $_GET['filter']=='pending' ? 'active' : '' ?>" href="validasi_prestasi.php?filter=pending">Perlu Validasi</a>
                </li>
            </ul>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Data Prestasi</th>
                                    <th width="30%">Deskripsi Singkat</th>
                                    <th>Bukti</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $filter = isset($_GET['filter']) && $_GET['filter']=='pending' ? "WHERE status='pending'" : "";
                                $q = $koneksi->query("SELECT * FROM mahasiswa_prestasi $filter ORDER BY FIELD(status, 'pending', 'approved', 'rejected'), id_prestasi DESC");
                                $no = 1;
                                while($row = $q->fetch_assoc()){
                                    $color = $row['status']=='pending'?'warning':($row['status']=='approved'?'success':'danger');
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($row['judul_prestasi']) ?></div>
                                        <div class="small text-muted mb-1"><i class="fas fa-user"></i> <?= htmlspecialchars($row['nama_mahasiswa']) ?></div>
                                        <div class="badge bg-light text-dark border">
                                            <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($row['tanggal_prestasi'])) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small" style="max-height: 80px; overflow-y: auto;">
                                            <?= htmlspecialchars(substr($row['deskripsi'], 0, 150)) . (strlen($row['deskripsi']) > 150 ? '...' : '') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        $imgRaw = $row['file_gambar'];
                                        $imgArr = json_decode($imgRaw, true);
                                        if(!is_array($imgArr)) $imgArr = !empty($imgRaw) ? [$imgRaw] : [];
                                        
                                        if(!empty($imgArr) && !empty($imgArr[0])): 
                                            $firstImg = $imgArr[0];
                                        ?>
                                            <a href="../uploads/prestasi/<?= $firstImg ?>" target="_blank" class="d-block text-decoration-none">
                                                <img src="../uploads/prestasi/<?= $firstImg ?>" height="60" class="rounded border mb-1">
                                                <?php if(count($imgArr) > 1): ?>
                                                    <span class="badge bg-secondary rounded-pill" style="font-size: 0.6rem;">+<?= count($imgArr)-1 ?> foto</span>
                                                <?php endif; ?>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $color ?> text-uppercase"><?= $row['status'] ?></span>
                                    </td>
                                    <td>
                                        <?php if($row['status'] == 'pending' || $row['status'] == 'rejected'): ?>
                                            <a href="validasi_prestasi.php?approve=<?= $row['id_prestasi'] ?>" class="btn btn-success btn-sm w-100 mb-1" onclick="return confirm('Setujui prestasi ini?')">
                                                <i class="fas fa-check"></i> Approve
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if($row['status'] == 'pending' || $row['status'] == 'approved'): ?>
                                            <button type="button" class="btn btn-danger btn-sm w-100" onclick="openRejectModal(<?= $row['id_prestasi'] ?>)">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        <?php endif; ?>
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

    <!-- Modal Reject -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Pengajuan & Revisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_prestasi" id="rejectId">
                        <div class="mb-3">
                            <label class="form-label">Catatan Revisi <span class="text-danger">*</span></label>
                            <textarea name="catatan_revisi" class="form-control" rows="4" required placeholder="Jelaskan alasan penolakan atau revisi yang diperlukan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="reject" class="btn btn-danger">Simpan Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function openRejectModal(id) {
        document.getElementById('rejectId').value = id;
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    }
    </script>
</body>
</html>
