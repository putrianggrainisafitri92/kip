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

        $target_dir = "../uploads/pedoman/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $target_file = $target_dir . $file_name;
        move_uploaded_file($file_tmp, $target_file);
        
        $file_path_db = "uploads/pedoman/" . $file_name;
    } else {
        $file_path_db = $pedoman['file_path']; 
    }

    // Update pedoman
    $stmt = $koneksi->prepare("
        UPDATE pedoman 
        SET nama_file=?, file_path=?, status='pending', catatan_revisi=NULL, updated_at=NOW() 
        WHERE id_pedoman=?
    ");
    $stmt->bind_param("ssi", $nama_file, $file_path_db, $id);
    $stmt->execute();

    echo "<script>
        alert('Berhasil diperbarui dan diajukan kembali!');
        window.location='pedoman_list.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pedoman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-purple: #6a11cb;
            --secondary-purple: #2575fc;
            --deep-purple: #4e0a8a;
            --glass-purple: rgba(78, 10, 138, 0.9);
        }

        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .content {
            margin-left: 230px;
            padding: 40px 20px;
            transition: all 0.3s ease;
        }

        .form-card {
            width: 100%;
            max-width: 700px;
            margin: auto;
            padding: 40px;
            border-radius: 24px;
            background: var(--glass-purple);
            backdrop-filter: blur(12px);
            color: white;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 20px;
            font-size: 15px;
            color: #f1e4ff;
        }

        input[type=text], input[type=file] {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            background: rgba(255,255,255,0.2);
            border-color: #ba68ff;
            box-shadow: 0 0 15px rgba(186, 104, 255, 0.3);
        }

        .file-info {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 12px;
            color: #fff;
            margin-bottom: 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #ba68ff, #7b35d4);
            color: white;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(123, 53, 212, 0.3);
            margin-top: 30px;
            transition: 0.3s;
        }

        .btn-save:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(123, 53, 212, 0.4);
        }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            margin-top: 15px;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="form-card">
        <h2>Edit Pedoman</h2>

        <form method="POST" enctype="multipart/form-data">
            <label>Nama File Pedoman</label>
            <input type="text" name="nama_file" 
                   value="<?= htmlspecialchars($pedoman['nama_file']) ?>" required>

            <label>File Saat Ini</label>
            <div class="file-info">
                <i class="fas fa-file-pdf" style="color:#ff4d4d; font-size:1.2rem;"></i>
                <?= basename($pedoman['file_path']) ?>
            </div>

            <label>Upload File Baru (Hanya jika ingin mengganti)</label>
            <input type="file" name="file_pedoman" accept="application/pdf">

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Simpan & Ajukan Kembali
            </button>

            <a href="pedoman_list.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </form>
    </div>
</div>

</body>
</html>
