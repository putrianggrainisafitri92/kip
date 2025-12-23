<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['level']) || $_SESSION['level'] != '11') {
    die("Akses ditolak!");
}

include "../koneksi.php";
include "sidebar.php";

$q = mysqli_query($koneksi, "SELECT * FROM pedoman ORDER BY id_pedoman DESC");
?>


<!DOCTYPE html>
<html>
<head>
<title>Daftar Pedoman</title>

<style>
body {
    font-family: "Poppins", sans-serif;
    background: #f3e8ff; /* ungu soft */
    margin: 0;
}

/* ===== Content Wrapper ===== */
.content {
    margin-left: 230px;
    padding: 25px;
    min-height: 100vh;
}

/* ===== Title ===== */
.content h2 {
    color: #5a189a;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* ===== Table ===== */
table {
    width: 95%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

th {
    background: linear-gradient(90deg, #5a189a, #7b2cbf);
    color: white;
    padding: 14px;
    font-size: 15px;
    text-transform: uppercase;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    background: #fff;
    vertical-align: top;
}

/* Hover row */
tr:hover td {
    background: #f3e8ff;
    transition: 0.2s;
}

/* ===== Status Colors ===== */
.pending { color: #ff9800; font-weight:bold; }
.revisi, .rejected { color: #e63946; font-weight:bold; }
.approved { color: #2a9d8f; font-weight:bold; }

/* ===== Buttons ===== */
.btn {
    padding: 7px 12px;
    border-radius: 6px;
    text-decoration:none;
    font-size: 13px;
    font-weight: 600;
    color:white;
    display: inline-block;
    transition: 0.2s;
}

.btn-download {
    background:#5a189a;
}
.btn-download:hover {
    background:#3d0f69;
}

.btn-edit {
    background: #7b2cbf;
}
.btn-edit:hover {
    background: #5a189a;
}

.btn-hapus {
    background:#d00000;
}
.btn-hapus:hover {
    background:#9b0000;
}

/* ===== Modal ===== */
.modal {
    display:none;
    position: fixed;
    z-index: 9999;
    left:0; top:0;
    width:100%; height:100%;
    overflow:auto;
    background: rgba(0,0,0,0.6);
    animation: fadeIn 0.3s ease-out;
}

.modal-content {
    background:white;
    margin:10% auto;
    padding:25px;
    border-radius:12px;
    width:45%;
    box-shadow:0 5px 20px rgba(0,0,0,0.2);
    animation: scaleIn 0.25s ease-out;
}

@keyframes fadeIn { from {opacity:0;} to {opacity:1;} }
@keyframes scaleIn { 
    from {transform:scale(0.8); opacity:0;} 
    to {transform:scale(1); opacity:1;} 
}

.close {
    float:right;
    font-size:22px;
    font-weight:bold;
    cursor:pointer;
    color:#7b2cbf;
}
.close:hover {
    color:#5a189a;
}

/* TOMBOL KEMBALI */
.btn-kembali {
    display: inline-block;
    padding: 10px 18px;
    margin-bottom: 18px;
    background: #5a189a;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: 0.25s;
}

.btn-kembali:hover {
    background: #3d0f69;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(90, 24, 154, 0.3);
}
</style>

<script>
function showModal(id){
    document.getElementById(id).style.display = "block";
}
function closeModal(id){
    document.getElementById(id).style.display = "none";
}
function confirmDelete(id){
    if(confirm("Hapus pedoman ini?")){
        window.location = "hapus_pedoman.php?id=" + id;
    }
}

// Close modal if click outside
window.onclick = function(event){
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal){
        if(event.target == modal){
            modal.style.display = "none";
        }
    });
}
</script>

</head>

<body>

<div class="content">
    <h2>Daftar Pedoman</h2>

    <button onclick="history.back()" class="btn-kembali">← Kembali</button>

    <table>
        <tr>
            <th>Nama File</th>
            <th>Status</th>
            <th>Catatan Revisi</th>
            <th>Aksi</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($q)) { 
            $statusClass = strtolower($row['status']);
            $catatan = !empty($row['catatan_revisi']) ? htmlspecialchars($row['catatan_revisi']) : "-";
        ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_file']) ?></td>

            <td class="<?= $statusClass ?>">
                <?= strtoupper(htmlspecialchars($row['status'])) ?>
            </td>

            <td>
                <?php if(!empty($row['catatan_revisi'])): ?>
                    <button class="btn btn-download" onclick="showModal('modal-<?= $row['id_pedoman'] ?>')">Lihat</button>

                    <!-- Modal -->
                    <div id="modal-<?= $row['id_pedoman'] ?>" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('modal-<?= $row['id_pedoman'] ?>')">&times;</span>
                            <h3 style="color:#5a189a;">Catatan Revisi</h3>
                            <p><?= nl2br($catatan) ?></p>
                        </div>
                    </div>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <td>
                <?php if(!empty($row['file_path'])) { ?>
                    <a class="btn btn-download" href="/KIPWEB/<?= htmlspecialchars($row['file_path']) ?>" target="_blank">Download</a>
                <?php } ?>

                <a class="btn btn-edit" href="edit_pedoman.php?id=<?= $row['id_pedoman'] ?>">Edit</a>
                <a class="btn btn-hapus" href="javascript:void(0);" onclick="confirmDelete(<?= $row['id_pedoman'] ?>)">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>

