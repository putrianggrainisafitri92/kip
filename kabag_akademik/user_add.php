<?php
session_start();
include '../protect.php';
check_level(13);
include '../koneksi.php';

// PROSES SIMPAN USER
$msg = "";
if (isset($_POST['simpan'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_plain = $_POST['password'];
    $password = password_hash($password_plain, PASSWORD_DEFAULT);
    $level    = intval($_POST['level']);

    if ($nama == "" || $username == "" || $password == "" || $level == 0) {
        $msg = "Semua field wajib diisi!";
    } else {
        // CEK USERNAME SUDAH ADA
        $cek = $koneksi->prepare("SELECT id_admin FROM admin WHERE username=? LIMIT 1");
        $cek->bind_param("s", $username);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $msg = "Username sudah digunakan!";
        } else {
            $ins = $koneksi->prepare("INSERT INTO admin (nama_lengkap, username, password, level) VALUES (?,?,?,?)");
            $ins->bind_param("sssi", $nama, $username, $password, $level);
            if ($ins->execute()) {
                echo "<script>alert('User berhasil ditambahkan'); window.location='crud_user.php';</script>";
                exit;
            } else {
                $msg = "Gagal menambah user!";
            }
        }
    }
}

include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User - Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #6a11cb;
            --secondary-purple: #2575fc;
            --deep-purple: #4e0a8a;
            --glass-purple: rgba(78, 10, 138, 0.95);
        }

        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .content {
            margin-left: 240px;
            padding: 40px 20px;
            transition: all 0.3s ease;
        }

        .form-card {
            width: 100%;
            max-width: 600px;
            margin: auto;
            padding: 40px;
            border-radius: 30px;
            background: var(--glass-purple);
            backdrop-filter: blur(15px);
            color: white;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            color: #f1e4ff;
        }

        input, select {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            box-sizing: border-box;
            outline: none;
            font-family: inherit;
            transition: 0.3s;
        }

        input:focus, select:focus {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
            box-shadow: 0 0 10px rgba(255,255,255,0.1);
        }

        select option { color: #333; }

        .btn-submit {
            background: linear-gradient(135deg, #ba68ff, #7b35d4);
            color: white;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
            box-shadow: 0 10px 20px rgba(123, 53, 212, 0.4);
            transition: 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(123, 53, 212, 0.5);
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
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.15);
        }

        .alert {
            background: #ff5252;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 85px 15px 40px 15px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="form-card">
        <h2>Tambah User Baru</h2>

        <?php if($msg != ""): ?>
            <div class="alert">
                <i class="fas fa-exclamation-circle"></i> <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap user..." required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Buat username unik..." required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password..." required>
            </div>

            <div class="form-group">
                <label>Level Akses</label>
                <select name="level" required>
                    <option value="">-- Pilih Level --</option>
                    <option value="11">Admin 1 (Pengurus)</option>
                    <option value="12">Admin 2 (Pimpinan)</option>
                    <option value="13">Admin 3 (Kabag Akademik)</option>
                </select>
            </div>

            <button type="submit" name="simpan" class="btn-submit">
                <i class="fas fa-user-plus"></i> Simpan User Baru
            </button>

            <a href="crud_user.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </form>
    </div>
</div>

</body>
</html>