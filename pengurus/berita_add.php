<?php
session_start();
if(!isset($_SESSION['level']) || $_SESSION['level'] != '11') die("Akses ditolak!");

include "../koneksi.php";
include "sidebar.php";

// Proses simpan
if (isset($_POST['simpan'])) {

    $judul = trim($_POST['judul']);

    $stmt = $koneksi->prepare("
        INSERT INTO berita (judul, tanggal)
        VALUES (?, NOW())
    ");
    $stmt->bind_param("s", $judul);
    $stmt->execute();

    $idBerita = $stmt->insert_id;
    $stmt->close();

    // Upload Gambar
    if (!empty($_FILES['gambar_files'])) {

        $uploadDir = "../uploads/berita/";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $allowed = ['jpg','jpeg','png','gif','webp'];

        foreach ($_FILES['gambar_files']['tmp_name'] as $i => $tmpName) {
           if (!empty($_FILES['gambar_files']['tmp_name'][$i]) && $_FILES['gambar_files']['error'][$i] === 0) {


                $originalName = $_FILES['gambar_files']['name'][$i];
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) continue;

                $safe = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalName);
                $filename = time().'_'.rand(100,999).'_'.$safe;
                $target = $uploadDir . $filename;

                if (move_uploaded_file($tmpName, $target)) {

                    $caption = $_POST['captions'][$i] ?? null;

                    $ins = $koneksi->prepare("
                        INSERT INTO berita_gambar (id_berita, file, caption, sortorder)
                        VALUES (?, ?, ?, ?)
                    ");
                    $ins->bind_param("issi", $idBerita, $filename, $caption, $i);
                    $ins->execute();
                    $ins->close();
                }
            }
        }
    }

    echo "<script>alert('Berita disimpan. Menunggu validasi.'); window.location='berita_list.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berita</title>

<style>



    body {
        margin: 0; padding: 0;
        font-family: 'Segoe UI', Tahoma;

        background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .content {
        margin-left: 230px;
        padding: 40px 20px;
        min-height: 100vh;
    }

    .form-card {
        width: 90%;
        max-width: 850px;
        margin: auto;
        padding: 35px;
        border-radius: 18px;
        background: rgba(123, 31, 162, 0.92);
        backdrop-filter: blur(4px);
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.45);
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 30px;
        font-weight: bold;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        margin-top: 15px;
        font-size: 14px;
    }

    input[type=text], input[type=file], textarea {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: none;
        background: #f8f2ff;
        color: #3a0063;
        font-size: 14px;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.15);
        margin-top: 5px;
    }

    textarea {
        min-height: 120px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #ffffff;
        border: none;
        color: #5e1780;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.25s;
        margin-top: 18px;
    }

    button:hover {
        background: #f2dfff;
        transform: scale(1.02);
    }

    .icon-list {
        display: inline-flex;
        align-items: center;
        padding: 10px 18px;
        background: #7b1fa2;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.25);
        transition: 0.3s ease;
    }

    .icon-list:hover {
        background: #5e1780;
        transform: translateY(-3px);
    }

    .grid-box {
        background: rgba(255,255,255,0.15);
        padding: 15px;
        border-radius: 12px;
        margin-top: 15px;
    }

    .btn-del {
        background: #ff3b3b;
        color: white;
        padding: 10px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: 0.25s;
        margin-top: 10px;
    }

    .btn-del:hover {
        background: #c60000;
        transform: scale(1.05);
    }

</style>
</head>
<body>

<div class="content">

    <!-- TOMBOL DAFTAR BERITA -->
    <div style="width: 90%; max-width: 850px; margin: 0 auto 25px auto;">
        <a href="berita_list.php" class="icon-list">📄 <span>Daftar Berita</span></a>
    </div>

    <div class="form-card">

        <h2>Tambah Berita Baru</h2>

        <form method="post" enctype="multipart/form-data">

            <label>Judul Berita</label>
            <input type="text" name="judul" required>

            <h3 style="margin-top:25px;">Gambar & Deskripsi</h3>

            <div id="galleryRows">

                <div class="grid-box">
                    <label>Pilih Gambar</label>
                   <input type="file" name="gambar_files[]" accept="image/*">


                    <label>Deskripsi Gambar</label>
                    <textarea name="captions[]" placeholder="Masukkan deskripsi..."></textarea>

                    <button type="button" class="btn-del" onclick="removeRow(this)">Hapus</button>
                </div>

            </div>

            <button type="button" onclick="addRow()">+ Tambah Gambar</button>

            <button type="submit" name="simpan">Simpan Berita</button>

        </form>

    </div>

</div>

<script>
function addRow() {
    let box = document.createElement('div');
    box.className = "grid-box";

    box.innerHTML = `
        <label>Pilih Gambar</label>
      <input type="file" name="gambar_files[]" accept="image/*">
 
        <label>Deskripsi Gambar</label>
        <textarea name="captions[]" placeholder="Masukkan deskripsi..."></textarea>

        <button type="button" class="btn-del" onclick="removeRow(this)">Hapus</button>
    `;

    document.getElementById('galleryRows').appendChild(box);
}

function removeRow(btn) {
    btn.parentElement.remove();
}
</script>

</body>
</html>
