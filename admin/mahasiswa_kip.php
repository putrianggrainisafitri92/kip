<?php 
include "../koneksi.php";
include "protect.php";
include "sidebar.php";

if (!empty($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $koneksi->prepare("DELETE FROM mahasiswa_kip WHERE id_mahasiswa_kip=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil dihapus'); window.location='mahasiswa_kip.php';</script>";
    exit;
}

// Hitung total mahasiswa
$totalResult = $koneksi->query("SELECT COUNT(*) as total FROM mahasiswa_kip");
$total = $totalResult ? $totalResult->fetch_assoc()['total'] : 0;

// ================= SEARCH + FILTER =================
$keyword = isset($_GET['keyword']) ? $koneksi->real_escape_string($_GET['keyword']) : '';
$status  = isset($_GET['status']) ? $koneksi->real_escape_string($_GET['status']) : '';

$query = "SELECT * FROM mahasiswa_kip WHERE 1";

// jika keyword ada
if ($keyword != '') {
    $query .= "
        AND (
            npm LIKE '%$keyword%' OR
            nama_mahasiswa LIKE '%$keyword%' OR
            program_studi LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'
        )
    ";
}

// jika filter status ada
if ($status != '') {
    $query .= " AND status = '$status' ";
}

$query .= " ORDER BY id_mahasiswa_kip DESC";

$q = $koneksi->query($query);
?>

<style>
body {
    background: #efeaff;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
}

.content-wrapper {
    margin-left: 260px;
    padding: 35px;
}

/* HEADER CARD */
.header-card {
    background: #ffffff;
    padding: 28px;
    border-radius: 18px;
    border-left: 10px solid #6a0dad;
    box-shadow: 0 6px 22px rgba(106,13,173,0.18);
    margin-bottom: 25px;
}

.header-card h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
    color: #4e0a8a;
}

.button-group {
    margin-top: 18px;
    display: flex;
    gap: 12px;
}

.btn-custom {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    color: white !important;
    text-decoration: none;
    transition: 0.25s ease-in-out;
    box-shadow: 0 3px 8px rgba(0,0,0,0.18);
}

.btn-add { background: #4CAF50; }
.btn-add:hover { background: #3d8b3f; }

.btn-update { background: #6a0dad; }
.btn-update:hover { background: #540a9d; }

.btn-delete { background: #d32f2f; }
.btn-delete:hover { background: #b71c1c; }

/* TABLE */
.table-card {
    background: white;
    padding: 25px;
    border-radius: 18px;
    margin-top: 25px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.table thead {
    background: #6a0dad;
    color: white;
}

.table tbody tr:hover {
    background: #f0e4ff !important;
    transform: scale(1.003);
}

/* SEARCH + FILTER */
.search-box {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}

.search-input {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #bda4d6;
    font-size: 14px;
}

.filter-select {
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #bda4d6;
    background: white;
    font-size: 14px;
}
</style>

<div class="content-wrapper">

    <div class="header-card">
        <h2>Data Mahasiswa Penerima KIP-K</h2>
        <p>Total Mahasiswa: <strong><?= $total; ?></strong></p>

        <div class="button-group">
            <a href="mahasiswa_kip_add.php" target="_blank" class="btn-custom btn-add">
                <i class="bi bi-plus-circle"></i> Tambah Mahasiswa
            </a>

            <a href="mahasiswa_kip_update.php" target="_blank" class="btn-custom btn-update">
                <i class="bi bi-arrow-repeat"></i> Update Mahasiswa
            </a>

            <a href="hapus_semua_mahasiswa.php" target="_blank" class="btn-custom btn-delete">
                <i class="bi bi-trash3"></i> Hapus Semua
            </a>
        </div>

        <!-- ========== SEARCH + FILTER ========== -->
        <form method="GET" class="search-box">

            <!-- input keyword -->
            <input 
                type="text" 
                name="keyword"
                class="search-input"
                placeholder="Cari NPM / Nama / Prodi / Jurusan..."
                value="<?= htmlspecialchars($keyword); ?>"
            >

            <!-- FILTER STATUS -->
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="pending"  <?= $status=='pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= $status=='approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= $status=='rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>

            <button class="btn-custom btn-update" style="border:none;">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
        <!-- ========== END SEARCH + FILTER ========== -->
    </div>

    <div class="table-card">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NPM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program Studi</th>
                    <th>Jurusan</th>
                    <th>Tahun</th>
                    <th>Skema</th>
                    <th>Status</th>
                    <th>Catatan Revisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;

            if ($q && $q->num_rows > 0) {
                while ($d = $q->fetch_assoc()) {

                    switch ($d['status']) {
                        case 'pending':  $badge = '<span class="badge badge-warning">Pending</span>'; break;
                        case 'approved': $badge = '<span class="badge badge-success">Approved</span>'; break;
                        case 'rejected': $badge = '<span class="badge badge-danger">Rejected</span>'; break;
                        default:         $badge = '<span class="badge bg-secondary">-</span>';
                    }

                    $catatan = !empty($d['catatan_revisi']) ? htmlspecialchars($d['catatan_revisi']) : '-';
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($d['npm']); ?></td>
                    <td><?= htmlspecialchars($d['nama_mahasiswa']); ?></td>
                    <td><?= htmlspecialchars($d['program_studi']); ?></td>
                    <td><?= htmlspecialchars($d['jurusan']); ?></td>
                    <td><?= htmlspecialchars($d['tahun']); ?></td>
                    <td><?= htmlspecialchars($d['skema']); ?></td>
                    <td><?= $badge ?></td>
                    <td><?= $catatan ?></td>
                    <td style="text-align:center;">
                        <a href="mahasiswa_kip_edit.php?id=<?= $d['id_mahasiswa_kip']; ?>" 
                           target="_blank" 
                           class="btn btn-sm btn-warning" 
                           style="border-radius:8px;">
                           <i class="bi bi-pencil-square"></i>
                        </a>

                        <a href="mahasiswa_kip.php?hapus=<?= $d['id_mahasiswa_kip']; ?>" 
                           onclick="return confirm('Yakin ingin hapus data ini?');" 
                           class="btn btn-sm btn-danger"
                           style="border-radius:8px;">
                           <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='10' class='text-center'>Data tidak ditemukan.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
