<?php
session_start();
if($_SESSION['level'] != '11') die("Akses ditolak!");
include "../koneksi.php";
include "sidebar.php";

$id = intval($_GET['id']);
$q = mysqli_query($koneksi, "SELECT * FROM pedoman WHERE id_pedoman=$id");
$pedoman = mysqli_fetch_assoc($q);

if(!$pedoman) die("Pedoman tidak ditemukan.");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_file = trim($_POST['nama_file']);

    // Upload file baru jika ada
    if(isset($_FILES['file_pedoman']) && $_FILES['file_pedoman']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES['file_pedoman']['name']);
        $file_tmp = $_FILES['file_pedoman']['tmp_name'];

        $target_dir = "uploads/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $target_file = $target_dir . $file_name;
        move_uploaded_file($file_tmp, $target_file);
    } else {
        $target_file = $pedoman['file_path']; 
    }

    // Update pedoman
    $stmt = $koneksi->prepare("
        UPDATE pedoman 
        SET nama_file=?, file_path=?, status='pending', catatan_revisi=NULL, updated_at=NOW() 
        WHERE id_pedoman=?
    ");
    $stmt->bind_param("ssi", $nama_file, $target_file, $id);
    $stmt->execute();

    echo "<script>
        alert('Berhasil diperbarui dan diajukan kembali!');
        window.location='pedoman_list.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Pedoman</title>

<style>
    body {
        margin: 0;
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
        max-width: 700px;
        margin: auto;
        padding: 35px;
        border-radius: 18px;
        background: rgba(123, 31, 162, 0.92);
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.40);
        backdrop-filter: blur(3px);
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
        color: white;
    }

    label {
        font-weight: bold;
        color: white;
        font-size: 14px;
    }

    input[type=text], input[type=file] {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: none;
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
        background: white;
        border: none;
        color: #5e1780;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.25s;
    }

    button:hover {
        background: #f2dfff;
        transform: scale(1.02);
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 18px;
        background: #7b1fa2;
        color: white;
        border-radius: 10px;
        font-size: 15px;
        margin-bottom: 25px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 4px 15px rgba(0,0,0,0.25);
        transition: 0.3s;
    }

    .back-btn:hover {
        background: #5e1780;
        transform: translateY(-3px);
    }

    .file-info {
        background: white;
        padding: 10px;
        border-radius: 8px;
        color: #5e1780;
        margin-bottom: 15px;
        font-size: 14px;
        font-weight: bold;
    }
</style>

</head>
<body>

<div class="content">

    <div style="max-width: 700px; margin: 0 auto;">
        <a href="pedoman_list.php" class="back-btn">
             <span style="margin-left:8px;">⬅ Kembali</span>
        </a>
    </div>

    <div class="form-card">
        <h2>Edit Pedoman</h2>

        <form method="POST" enctype="multipart/form-data">

            <label>Nama File:</label>
            <input type="text" name="nama_file" 
                   value="<?= htmlspecialchars($pedoman['nama_file']) ?>" required>

            <label>File Lama:</label>
            <div class="file-info"><?= basename($pedoman['file_path']) ?></div>

            <label>Upload File Baru (opsional):</label>
            <input type="file" name="file_pedoman">

            <button type="submit">Simpan & Ajukan Kembali</button>
        </form>
    </div>

</div>

</body>
</html>
