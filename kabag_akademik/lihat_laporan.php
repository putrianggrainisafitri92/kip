<?php  
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

// Ambil laporan berdasarkan status
$aktif   = $koneksi->query("SELECT * FROM laporan WHERE status_tindak!='selesai' OR status_tindak IS NULL ORDER BY created_at DESC");
$riwayat = $koneksi->query("SELECT * FROM laporan WHERE status_tindak='selesai' ORDER BY created_at DESC");
?>

<!-- ======================= MAIN WRAPPER ======================= -->
<div class="content-wrapper">

    <!-- ==== HEADER CARD ==== -->
    <div class="header-card">
        <h2>📑 Daftar Laporan Mahasiswa</h2>
    </div>


    <!-- =================  TABEL RIWAYAT LAPORAN  ================= -->
    <div class="table-card" style="margin-top:35px;">
      

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelapor</th>
                    <th>Terlapor</th>
                    <th>Jurusan / Prodi</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php while($d = $riwayat->fetch_assoc()): ?>
                <tr>
                    <td><?= $d['id_laporan'] ?></td>
                    <td><?= htmlspecialchars($d['nama_pelapor']) ?></td>

                    <td>
                        <?= htmlspecialchars($d['nama_terlapor']) ?>
                        <br><small style="color:gray">(<?= $d['npm_terlapor'] ?>)</small>
                    </td>

                    <td><?= htmlspecialchars($d['jurusan']) ?> / <?= htmlspecialchars($d['prodi']) ?></td>
                    <td><?= htmlspecialchars($d['alasan']) ?></td>

                    <td>
                        <span class='badge success'>Selesai</span>
                    </td>

                    <td>
                        <a href="detail_laporan.php?id=<?= $d['id_laporan'] ?>" class="btn-info">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>

        </table>
    </div>

</div>


<!-- ======================= STYLE ======================= -->
<style>
.content-wrapper {
    margin-left: 260px;
    padding: 35px;
    background: #efeaff;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

.header-card {
    background: white;
    padding: 28px;
    border-radius: 18px;
    border-left: 10px solid #6a0dad;
    margin-bottom: 25px;
    box-shadow: 0 6px 22px rgba(106, 13, 173, .18);
}

.header-card h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
    color: #4e0a8a;
}

.table-card {
    background: white;
    padding: 25px;
    border-radius: 18px;
    margin-top: 15px;
    box-shadow: 0 6px 20px rgba(0,0,0,.12);
}

.styled-table {
    width: 100%;
    border-collapse: collapse;
}

.styled-table thead tr {
    background: #6a0dad;
    color: white;
}

.styled-table th,
.styled-table td {
    padding: 14px 16px;
    font-size: 14px;
    text-align: center;
}

.styled-table tbody tr {
    background: #fbf7ff;
    border-bottom: 8px solid white;
    transition: 0.2s;
}

.styled-table tbody tr:hover {
    background: #f0e4ff;
    transform: scale(1.002);
}

.badge {
    padding: 7px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: white;
}

.success { background: #2ecc71; }
.info    { background: #3498db; }
.pending { background: #f1c40f; color: #4a3d00; }

.btn-info {
    background: #6a0dad;
    padding: 7px 12px;
    color: white;
    border-radius: 8px;
    text-decoration: none;
}
</style>
