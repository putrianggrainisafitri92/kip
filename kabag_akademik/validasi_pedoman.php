<?php
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

// Ambil semua pedoman terbaru
$q = mysqli_query($koneksi, "SELECT * FROM pedoman ORDER BY id_pedoman DESC");
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
.btn-info {
    background: #6a0dad;
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
}

.btn-detail {
    background: #0288D1;
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
}

.btn-approve {
    background: #2ecc71 !important;
}
.btn-reject {
    background: #e74c3c !important;
}

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
        <h2>📘 Validasi Pedoman</h2>
    </div>

    <div class="table-card">

        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Status</th>
                    <th>Catatan Revisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php while($d = mysqli_fetch_assoc($q)) { 
                $status = strtolower($d['status']);
                $id = $d['id_pedoman'];

                // BADGE
                if ($status == "approved") {
                    $badge = '<span class="badge success">APPROVED</span>';
                } elseif ($status == "pending") {
                    $badge = '<span class="badge pending">PENDING</span>';
                } else {
                    $badge = '<span class="badge danger">REJECTED / REVISI</span>';
                }
            ?>
            <tr>
                <td style="text-align:left;"><?= htmlspecialchars($d['nama_file']) ?></td>

                <td><?= $badge ?></td>

                <td>
                    <?php if (!empty($d['catatan_revisi'])) { ?>
                        <button class="btn-info" onclick="openModal('modal-note-<?= $id ?>')">Lihat</button>

                        <div id="modal-note-<?= $id ?>" class="modal-overlay">
                            <div class="modal-box">
                                <span class="close" onclick="closeModal('modal-note-<?= $id ?>')">&times;</span>
                                <h3>Catatan Revisi</h3>
                                <p><?= nl2br(htmlspecialchars($d['catatan_revisi'])) ?></p>
                            </div>
                        </div>
                    <?php } else { echo "-"; } ?>
                </td>

                <td>
                    <a class="btn-detail" href="validasi_pedoman_detail.php?id=<?= $id ?>">Detail</a>

                    <?php if($status != 'approved') { ?>
                        <!-- APPROVE -->
                        <form action="validasi_pedoman_proses.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="s" value="approved">
                            <button class="btn-detail btn-approve" type="submit">Approve</button>
                        </form>

                        <!-- REJECT BUTTON -->
                        <button class="btn-detail btn-reject" onclick="openModal('modal-reject-<?= $id ?>')">Reject</button>

                        <!-- MODAL REVISI -->
                        <div id="modal-reject-<?= $id ?>" class="modal-overlay">
                            <div class="modal-box">
                                <span class="close" onclick="closeModal('modal-reject-<?= $id ?>')">&times;</span>
                                <h3>Catatan Revisi</h3>

                                <form action="validasi_pedoman_proses.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="s" value="rejected">

                                    <textarea name="catatan_revisi" rows="5" style="width:100%; padding:10px;" required></textarea>
                                    <br><br>

                                    <button type="submit" class="btn-detail btn-reject" style="float:right;">Kirim</button>
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
    modals.forEach(m=>{
        if(event.target==m){ m.style.display="none"; }
    })
}
</script>
