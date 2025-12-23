<?php
include '../protect.php';
check_level(13); // Admin3
include '../koneksi.php';
include 'sidebar.php';

// Ambil semua batch file (grouping berdasarkan skema + tahun + id_admin)
$q = mysqli_query($koneksi, "
    SELECT skema, tahun, id_admin, COUNT(*) AS total,
           MAX(status) AS status_batch
    FROM mahasiswa_kip
    GROUP BY skema, tahun, id_admin
    ORDER BY tahun DESC, skema
");
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
    box-shadow: 0 6px 22px rgba(106, 13, 173, 0.18);
    margin-bottom: 25px;
}

.header-card h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
    color: #4e0a8a;
}

/* TABLE CARD */
.table-card {
    background: white;
    padding: 25px;
    border-radius: 18px;
    margin-top: 25px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* TABLE */
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
    text-align: center;
    font-size: 14px;
}

.styled-table tbody tr {
    background: #fbf7ff;
    border-bottom: 8px solid #ffffff;
    transition: 0.2s;
}

.styled-table tbody tr:hover {
    background: #f0e4ff;
    transform: scale(1.002);
}

/* STATUS BADGES */
.badge {
    padding: 7px 12px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: white;
}
.success { background: #2ecc71; }
.danger  { background: #e74c3c; }
.pending { background: #f1c40f; color: #4a3d00; }

/* BUTTON */
.btn {
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
}

.btn-detail { background: #0288D1; }
.btn-approve { background: #2ecc71; }
.btn-reject { background: #e74c3c; }

/* MODAL */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 999;
}

.modal-box {
    background: white;
    width: 40%;
    margin: 8% auto;
    padding: 25px;
    border-radius: 18px;
    border-top: 6px solid #6a0dad;
    position: relative;
    animation: fadeIn 0.25s ease;
}

.close {
    position: absolute;
    right: 18px;
    top: 10px;
    font-size: 22px;
    cursor: pointer;
    color: #6a0dad;
}

/* ANIMATION */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<div class="content-wrapper">

    <div class="header-card">
        <h2>📁 Validasi KIP — Batch File</h2>
    </div>

    <div class="table-card">

        <table class="styled-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File / Tahun</th>
                    <th>Diunggah Oleh</th>
                    <th>Total Mhs</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php 
            $no = 1;
            while($batch = mysqli_fetch_array($q)) { 
                
                // Ambil username admin1
                $admin_username = 'Unknown';
                if(!empty($batch['id_admin'])){
                    $stmt = $koneksi->prepare("SELECT username FROM admin WHERE id_admin = ?");
                    $stmt->bind_param("i", $batch['id_admin']);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $admin = $res->fetch_assoc();
                    if($admin) $admin_username = $admin['username'];
                }

                // Badge status
                $status = strtolower($batch['status_batch']);
                if($status == "approved"){
                    $badge = '<span class="badge success">APPROVED</span>';
                } elseif($status == "pending" || empty($status)){
                    $badge = '<span class="badge pending">PENDING</span>';
                } else {
                    $badge = '<span class="badge danger">REJECTED</span>';
                }
            ?>
            <tr>
                <td><?= $no++; ?></td>

                <td style="text-align:left;">
                    <?= htmlspecialchars($batch['skema']) ?> / <?= $batch['tahun'] ?>
                </td>

                <td><?= htmlspecialchars($admin_username) ?></td>

                <td><?= $batch['total'] ?></td>

                <td><?= $badge ?></td>

                <td>

                    <a class="btn btn-detail" 
                       href="validasi_kip_detail.php?skema=<?= urlencode($batch['skema']); ?>&tahun=<?= $batch['tahun']; ?>" 
                       target="_blank">Detail</a>

                    <?php if($status != 'approved'){ ?>


                        <a class="btn btn-approve" 
                           href="validasi_kip_proses.php?skema=<?= urlencode($batch['skema']); ?>&tahun=<?= $batch['tahun']; ?>&status=approved"
                           onclick="return confirm('Setujui semua mahasiswa pada batch ini?')">
                            Approve
                        </a>

                        <button class="btn btn-reject" onclick="openModal('modal-reject-<?= $no ?>')">
                            Reject
                        </button>

                        <!-- MODAL REJECT -->
                        <div id="modal-reject-<?= $no ?>" class="modal-overlay">
                            <div class="modal-box">
                                <span class="close" onclick="closeModal('modal-reject-<?= $no ?>')">&times;</span>
                                <h3>Catatan Revisi</h3>

                                <form action="validasi_kip_proses.php" method="GET">
                                    <input type="hidden" name="skema" value="<?= $batch['skema'] ?>">
                                    <input type="hidden" name="tahun" value="<?= $batch['tahun'] ?>">
                                    <input type="hidden" name="status" value="rejected">

                                    <textarea name="catatan" rows="5" style="width:100%; padding:10px;" required></textarea>
                                    <br><br>

                                    <button type="submit" class="btn btn-reject" style="float:right;">Kirim</button>
                                </form>
                            </div>
                        </div>

                    <?php } ?>

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
    const modals = document.querySelectorAll('.modal-overlay');
    modals.forEach(m => {
        if(event.target==m){ m.style.display="none"; }
    });
}
</script>
