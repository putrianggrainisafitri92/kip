<?php
include 'protect.php';
include '../koneksi.php';
include 'sidebar.php';

$msg = "";

if (isset($_POST['submit'])) {

    $nama_sk   = trim($_POST['nama_sk']);
    $tahun     = trim($_POST['tahun']);
    $nomor_sk  = trim($_POST['nomor_sk']);
    $file      = $_FILES['file_sk'];

    if ($nama_sk == "" || $tahun == "" || $nomor_sk == "" || !$file['name']) {
        $msg = "<div class='alert alert-warning'>⚠️ Semua field wajib diisi.</div>";
    } else {

        $cek = $koneksi->prepare("SELECT id_sk_kipk FROM sk_kipk WHERE nama_sk=? AND tahun=? AND nomor_sk=?");
        $cek->bind_param("sss", $nama_sk, $tahun, $nomor_sk);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>⚠️ Data SK sudah ada!</div>";
        } else {

            $uploadDir = '../uploads/sk/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $allowed = ['pdf','xlsx','xls'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $msg = "<div class='alert alert-danger'>❌ Format file tidak diizinkan!</div>";
            } else {

                $cleanName = preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $file['name']);
                $fileName = time() . '_' . $cleanName;
                $filePath = $uploadDir . $fileName;
                $fileUrl  = '../uploads/sk/' . $fileName;

                if (move_uploaded_file($file['tmp_name'], $filePath)) {

                    $stmt = $koneksi->prepare("
                        INSERT INTO sk_kipk 
                        (nama_sk, tahun, nomor_sk, file_path, file_url, id_admin, status)
                        VALUES (?, ?, ?, ?, ?, ?, 'pending')
                    ");

                    $stmt->bind_param(
                        "sssssi",
                        $nama_sk,
                        $tahun,
                        $nomor_sk,
                        $filePath,
                        $fileUrl,
                        $_SESSION['id_admin']
                    );

                    $stmt->execute();

                    echo "<script>
                            alert('✅ Berhasil! SK masuk ke Pending. Menunggu verifikasi Kabag Akademik.');
                            window.location='sk_list.php';
                          </script>";
                    exit;

                } else {
                    $msg = "<div class='alert alert-danger'>❌ Upload gagal!</div>";
                }
            }
        }
        $cek->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload SK KIP-K</title>
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

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 20px;
            font-size: 15px;
            color: #f1e4ff;
        }

        input[type=text], input[type=number], input[type=file] {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            transition: all 0.3s;
            box-sizing: border-box;
            margin-bottom: 5px;
        }

        input:focus {
            outline: none;
            background: rgba(255,255,255,0.2);
            border-color: #ba68ff;
            box-shadow: 0 0 15px rgba(186, 104, 255, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-warning { background: rgba(255, 193, 7, 0.2); border: 1px solid #ffc107; color: #ffeb3b; }
        .alert-danger { background: rgba(255, 77, 77, 0.2); border: 1px solid #ff4d4d; color: #ffcccc; }

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
            margin-top: 30px;
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

        /* Responsive */
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
        <h2>Upload SK KIP-K</h2>

        <?= $msg; ?>

        <form method="POST" enctype="multipart/form-data">
            <label class="form-label">Nama SK</label>
            <input type="text" name="nama_sk" required placeholder="Masukkan nama SK">

            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" required placeholder="Contoh: 2026">

            <label class="form-label">Nomor SK</label>
            <input type="text" name="nomor_sk" required placeholder="Contoh: 123/POLINELA/SK/2026">

            <label class="form-label">File SK (PDF / Excel, Max 10MB)</label>
            <input type="file" name="file_sk" accept=".pdf,.xlsx,.xls" required>

            <button type="submit" name="submit" class="btn-upload">
                <i class="fas fa-cloud-upload-alt"></i> Upload File SK
            </button>

            <a href="sk_list.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar SK
            </a>
        </form>
    </div>
</div>

</body>
</html>
