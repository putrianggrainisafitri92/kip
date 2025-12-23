<?php
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

if(!isset($_GET['id'])) die("ID SK tidak ditemukan.");

$id = intval($_GET['id']);
$q = mysqli_query($koneksi, "SELECT * FROM sk_kipk WHERE id_sk_kipk=$id");
$d = mysqli_fetch_assoc($q);
if(!$d) die("SK tidak ditemukan.");
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

/* DETAIL CARD */
.detail-card {
    background: white;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    margin-bottom: 28px;
}

.detail-card p {
    font-size: 15px;
    margin: 10px 0;
}

.detail-label {
    font-weight: bold;
    color: #4e0a8a;
}

/* STATUS BADGE */
.badge {
    padding: 6px 12px;
    border-radius: 10px;
    color: white;
    font-size: 13px;
    font-weight: 600;
}

.success { background: #2ecc71; }
.danger  { background: #e74c3c; }
.pending { background: #f1c40f; color: #4a3d00; }

/* FORM BOX */
.form-card {
    background: white;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

textarea {
    width: 100%;
    padding: 12px;
    font-size: 15px;
    border-radius: 12px;
    border: 1px solid #bbb;
    resize: vertical;
    margin-top: 10px;
}

/* BUTTONS */
.btn {
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

.btn-approve { background: #2ecc71; }
.btn-reject  { background: #e74c3c; }
.btn-back    { background: #6a0dad; }

.btn:hover { opacity: 0.85; }

</style>

<div class="content-wrapper">

    <div class="header-card">
        <h2>📄 Detail SK KIPK</h2>
    </div>

    <div class="detail-card">

        <p><span class="detail-label">Nama SK:</span> <?= htmlspecialchars($d['nama_sk']); ?></p>

        <p><span class="detail-label">Tahun:</span> <?= htmlspecialchars($d['tahun']); ?></p>

        <p><span class="detail-label">Nomor SK:</span> <?= htmlspecialchars($d['nomor_sk']); ?></p>

        <p>
            <span class="detail-label">Status:</span>
            <?php
                $status_lower = strtolower($d['status']);
                $badgeClass = 
                    ($status_lower == "approved") ? "success" :
                    (($status_lower == "pending") ? "pending" : "danger");
            ?>
            <span class="badge <?= $badgeClass; ?>"><?= strtoupper($d['status']); ?></span>
        </p>

        <p>
            <span class="detail-label">Catatan Revisi:</span><br>
            <?= !empty($d['catatan_revisi']) ? nl2br(htmlspecialchars($d['catatan_revisi'])) : "<span style='color:red;'>Belum ada catatan</span>"; ?>
        </p>

        <p>
            <span class="detail-label">File:</span> 
            <?php if(!empty($d['file_url'])): ?>
                <a href="<?= $d['file_url']; ?>" target="_blank" style="color:#6a0dad; font-weight:bold;">Lihat File</a>
            <?php else: ?>
                Tidak ada file
            <?php endif; ?>
        </p>

    </div>

    <div class="form-card">
        <h3 style="color:#4e0a8a; font-weight:800; margin-top:0;">Validasi SK</h3>

        <form action="validasi_sk_proses.php" method="post" onsubmit="return validateReject(this);">
            <input type="hidden" name="id" value="<?= $d['id_sk_kipk']; ?>">

            <button type="submit" name="s" value="approved" class="btn btn-approve">Approve</button>

            <br><br>

            <label><b>Catatan Revisi (wajib jika Reject):</b></label>
            <textarea name="catatan_revisi" rows="4" placeholder="Tuliskan alasan penolakan jika Reject..."></textarea>

            <br><br>

            <button type="submit" name="s" value="rejected" class="btn btn-reject">Reject</button>

            <br><br>

            <!-- TOMBOL KEMBALI -->
            <a href="validasi_sk.php" class="btn btn-back" style="text-decoration:none;">Kembali</a>
        </form>
    </div>
</div>

<script>
function validateReject(form){
    if(form.s.value === "rejected"){
        if(form.catatan_revisi.value.trim() === ""){
            alert("Catatan revisi harus diisi saat menolak SK!");
            form.catatan_revisi.focus();
            return false;
        }
    }
    return true;
}
</script>
