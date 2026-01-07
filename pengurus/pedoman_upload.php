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

    $nama_pedoman = mysqli_real_escape_string($koneksi, $_POST['nama_pedoman']);
    $nama_asli    = basename($_FILES["file"]["name"]);
    $fileSize     = $_FILES["file"]["size"];
    $ext          = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));

    if (empty($nama_pedoman)) {
        echo "<script>alert('Nama pedoman wajib diisi!'); window.history.back();</script>";
        exit;
    }

    if ($ext != "pdf") {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!'); window.history.back();</script>";
        exit;
    }

    if ($fileSize > $maxSize) {
        echo "<script>alert('Ukuran file terlalu besar! Maks 10 MB.'); window.history.back();</script>";
        exit;
    }

    $nama_baru = pathinfo($nama_asli, PATHINFO_FILENAME) . "_" . uniqid() . ".pdf";
    $target_file = $target_dir . $nama_baru;
    $file_path_db = "uploads/pedoman/" . $nama_baru;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $koneksi->prepare("INSERT INTO pedoman (nama_file, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_pedoman, $file_path_db);
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Pedoman</title>
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
            margin-bottom: 12px;
            font-size: 15px;
            color: #f1e4ff;
        }

        input[type=file], input[type=text] {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            transition: all 0.3s;
            box-sizing: border-box;
            font-family: inherit;
        }

        input[type=file] {
            border: 2px dashed rgba(255,255,255,0.3);
            cursor: pointer;
            margin-bottom: 25px;
        }

        input[type=text] {
            margin-bottom: 20px;
        }

        input[type=text]:focus {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
            outline: none;
        }

        input[type=file]:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
        }

        .btn-upload {
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
            transition: 0.3s;
        }

        .btn-upload:hover {
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
            margin-top: 20px;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        .header-section {
            width: 100%;
            max-width: 700px;
            margin: 0 auto 30px auto;
            display: flex;
            justify-content: flex-start;
        }

        .btn-list {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #4e0a8a;
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: 0.3s;
        }

        .btn-list:hover {
            background: #7b35d4;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
        }
        /* ANIMATIONS */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }
    </style>
</head>
<body>

<div class="content">

    <div class="form-card animate-up">
        <h2>Upload Pedoman</h2>

        <form method="post" enctype="multipart/form-data">
            <div style="margin-bottom: 25px;">
                <label>Nama Pedoman</label>
                <input type="text" name="nama_pedoman" placeholder="Contoh: Panduan KIP-K 2024" required>
            </div>

            <div style="margin-bottom: 25px;">
                <label>Pilih File Pedoman (Format: PDF, Max 10MB)</label>
                <input type="file" name="file" accept="application/pdf" required>
            </div>

            <button type="submit" class="btn-upload">
                <i class="fas fa-cloud-upload-alt"></i> Upload File Pedoman
            </button>

            <a href="pedoman_list.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </form>
    </div>

</div>

</body>
</html>
