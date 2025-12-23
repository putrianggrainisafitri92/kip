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

/* BUTTON */
.btn-add {
    background: #4CAF50;
    padding: 12px 20px;
    border-radius: 12px;
    color: white !important;
    font-weight: 600;
    text-decoration: none;
    transition: 0.25s;
}
.btn-add:hover { background: #3e8e41; }

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

/* BADGES */
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

.btn-warning {
    background: #ff9f1c;
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: #e63946;
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
}

.btn-warning:hover { background: #ffb347; }
.btn-delete:hover { background: #ff6b6b; }
.aksi-btn {
    display: flex;
    gap: 8px;
    justify-content: center; /* opsional */
}

.btn-info {
    background: #6a0dad;
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
}
</style>

<div class="content-wrapper">

    <div class="header-card">
        <h2>📄 Daftar SK KIP-K</h2>
        <a href="sk_add.php" class="btn-add" style="margin-top:15px; display:inline-block;">
            + Tambah SK
        </a>
    </div>

    <div class="table-card">

        <table class="styled-table">
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

    switch($status){
        case 'approved':
            $badge = '<span class="badge success">Approved</span>';
            $catatan_text = '-';
            break;
        case 'rejected':
            $badge = '<span class="badge danger">Rejected</span>';
            $catatan_text = !empty($d['catatan_revisi']) ? htmlspecialchars($d['catatan_revisi']) : 'Belum ada catatan';
            break;
        default:
            $badge = '<span class="badge pending">Pending</span>';
            $catatan_text = '-';
    }
?>
<tr>
    <td><?= $no++; ?></td>
    <td style="text-align:left;"><?= htmlspecialchars($d['nama_sk']); ?></td>
    <td><?= htmlspecialchars($d['tahun']); ?></td>
    <td><?= htmlspecialchars($d['nomor_sk']); ?></td>
    <td><?= $badge; ?></td>

    <td>
        <?php if($status == 'rejected'): ?>
            <button class="btn-info" onclick="openModal('modal-<?= $id ?>')">Lihat</button>

            <div id="modal-<?= $id ?>" class="modal-overlay">
                <div class="modal-box">
                    <span class="close" onclick="closeModal('modal-<?= $id ?>')">&times;</span>
                    <h3>Catatan Revisi</h3>
                    <p><?= nl2br($catatan_text) ?></p>
                </div>
            </div>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>

   <td>
    <div class="aksi-btn">
        <a href="sk_edit.php?id=<?= $id; ?>" class="btn-warning">Edit</a>
        <a href="sk_list.php?hapus=<?= $id; ?>" 
           class="btn-delete" 
           onclick="return confirm('Hapus SK ini?')">Hapus</a>
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
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
