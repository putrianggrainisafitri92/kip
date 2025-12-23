<?php
session_start();

// Level khusus admin3 (13)
if (!isset($_SESSION['level']) || $_SESSION['level'] != '13') {
    die("Akses ditolak!");
}

include "../koneksi.php";
include "sidebar.php";

if (!($koneksi instanceof mysqli)) {
    die("Koneksi gagal!");
}

if (!isset($_GET['id'])) {
    die("ID tidak ada!");
}

$id = $_GET['id'];

// Ambil data pertanyaan
$q = $koneksi->query("SELECT * FROM pertanyaan WHERE id_pertanyaan='$id'");
$data = $q->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan!");
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

/* INFO CARD */
.info-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    margin-bottom: 25px;
}

.label {
    font-weight: 700;
    color: #4e0a8a;
}

/* FORM CARD */
.form-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

textarea {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: 1px solid #ccc;
    resize: vertical;
    font-size: 15px;
}

/* BUTTON */
.btn-send {
    padding: 12px 22px;
    background: #6a0dad;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.btn-send:hover {
    background: #4e0a8a;
}
</style>


<div class="content-wrapper">

    <!-- Header -->
    <div class="header-card">
        <h2>📩 Balas Pertanyaan</h2>
    </div>

    <!-- Detail Pertanyaan -->
    <div class="info-card">
        <p><span class="label">Nama:</span> <?= $data['nama']; ?></p>
        <p><span class="label">Email:</span> <?= $data['email']; ?></p>
        <p><span class="label">Pertanyaan:</span><br><?= nl2br($data['pesan']); ?></p>
    </div>

    <!-- Form Balasan -->
    <div class="form-card">
        <form method="POST">
            <label class="label">Balasan (copy manual untuk dikirim lewat Gmail):</label>
            <textarea name="balasan" rows="6" required></textarea><br><br>

            <button type="submit" name="kirim" class="btn-send">
                ✔ Simpan Status
            </button>
        </form>
    </div>

</div>

<?php
if (isset($_POST['kirim'])) {

    // Update status ke "sudah"
    $koneksi->query("UPDATE pertanyaan SET status_balasan='sudah' WHERE id_pertanyaan='$id'");

    echo "<script>
            alert('Status berhasil diperbarui! Silakan copy balasan dan kirim lewat Gmail.');
            window.location='admin3_pertanyaan.php';
          </script>";
}
?>
