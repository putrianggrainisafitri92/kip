<?php
include '../protect.php';
check_level(11); // hanya admin1
include '../koneksi.php';
include 'sidebar.php'; 

// Pastikan folder upload ada
$target_dir = "../uploads/pedoman/";
if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

// Batas ukuran file (10 MB)
$maxSize = 10 * 1024 * 1024;

// Proses upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
        echo "<script>alert('Tidak ada file yang diupload atau terjadi error!'); window.history.back();</script>";
        exit;
    }

    $nama_file = basename($_FILES["file"]["name"]);
    $fileSize  = $_FILES["file"]["size"];
    $ext       = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if ($ext != "pdf") {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!'); window.history.back();</script>";
        exit;
    }

    if ($fileSize > $maxSize) {
        echo "<script>alert('Ukuran file terlalu besar! Maks 10 MB.'); window.history.back();</script>";
        exit;
    }

    $nama_baru = pathinfo($nama_file, PATHINFO_FILENAME) . "_" . uniqid() . ".pdf";
    $target_file = $target_dir . $nama_baru;
    $file_path_db = "uploads/pedoman/" . $nama_baru;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $koneksi->prepare("INSERT INTO pedoman (nama_file, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_file, $file_path_db);
        if ($stmt->execute()) {
            echo "<script>alert('File berhasil diupload!'); window.location.href='pedoman_list.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan ke database.'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Gagal memindahkan file ke folder upload.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Pedoman</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .content {
        margin-left: 230px; /* ruang untuk sidebar */
        padding: 40px 20px;
        min-height: 100vh;
    }

    /* CARD FORM UNGU (SAMA DENGAN TAMBAH BERITA) */
    .form-card {
        width: 90%;
        max-width: 700px;
        margin: auto;
        padding: 35px;
        border-radius: 18px;
        background: rgba(123, 31, 162, 0.92);
        backdrop-filter: blur(3px);
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.40);
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 28px;
        color: #fff;
    }

    label {
        font-weight: bold;
        color: #fff;
        font-size: 14px;
    }

    input[type=file] {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: none;
        outline: none;
        margin-top: 6px;
        margin-bottom: 18px;
        font-size: 14px;
        background: #f8f2ff;
        color: #3a0063;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.15);
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
        transition: 0.25s ease;
    }

    button:hover {
        background: #f2dfff;
        transform: scale(1.02);
    }

    /* TOMBOL DAFTAR PEDOMAN (SAMA STYLE DENGAN DAFTAR BERITA) */
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

    .icon-list span {
        margin-left: 8px;
    }
</style>

</head>
<body>

<div class="content">

    <!-- TOMBOL DAFTAR PEDOMAN POSISI SAMA SEPERTI TAMBAH BERITA -->
    <div style="width: 90%; max-width: 700px; margin: 0 auto 25px auto; text-align: left;">
        <a href="pedoman_list.php" class="icon-list">📄 <span>Daftar Pedoman</span></a>
    </div>

    <div class="form-card">
        <h2>Upload Pedoman</h2>

        <div class="inner">
            <form method="post" enctype="multipart/form-data">
                <label>Pilih File PDF:</label>
                <input type="file" name="file" required>

                <button type="submit">Upload</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>

