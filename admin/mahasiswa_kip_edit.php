<?php 
include "../koneksi.php";
include "protect.php";

// IZINKAN LEVEL 12 & 13 AKSES HALAMAN EDIT
check_level(12, 13);

if (isset($_POST['update'])) {
    $id_post = intval($_GET['id']);
    $stmt = $koneksi->prepare("
        UPDATE mahasiswa_kip 
        SET npm=?, nama_mahasiswa=?, program_studi=?, jurusan=?, tahun=?, skema=?, status='pending'
        WHERE id_mahasiswa_kip=?
    ");

    $stmt->bind_param(
        "ssssisi",
        $_POST['npm'],
        $_POST['nama'],
        $_POST['prodi'],
        $_POST['jurusan'],
        $_POST['tahun'],
        $_POST['skema'],
        $id_post
    );

    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil diperbarui. Status kembali pending menunggu verifikasi.'); window.location='mahasiswa_kip.php';</script>";
    exit;
}

include "sidebar.php";

$id = intval($_GET['id']);
$stmt = $koneksi->prepare("SELECT * FROM mahasiswa_kip WHERE id_mahasiswa_kip=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='mahasiswa_kip.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa KIP-K</title>
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
            max-width: 800px;
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

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 20px;
            font-size: 15px;
            color: #f1e4ff;
        }

        input[type=text], input[type=number] {
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

        .btn-update {
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

        .btn-update:hover { filter: brightness(1.1); transform: translateY(-2px); }

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
        }
        .btn-back:hover { background: rgba(255,255,255,0.15); transform: translateY(-2px); }

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
        <h2>✏ Edit Mahasiswa KIP-K</h2>

        <form method="post">
            <label class="form-label">NPM</label>
            <input type="text" name="npm" value="<?= htmlspecialchars($data['npm']); ?>" required>

            <label class="form-label">Nama Mahasiswa</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama_mahasiswa']); ?>" required>

            <label class="form-label">Program Studi</label>
            <input type="text" name="prodi" value="<?= htmlspecialchars($data['program_studi']); ?>" required>

            <label class="form-label">Jurusan</label>
            <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']); ?>" required>

            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" value="<?= htmlspecialchars($data['tahun']); ?>" required>

            <label class="form-label">Skema</label>
            <input type="text" name="skema" value="<?= htmlspecialchars($data['skema']); ?>" required>

            <button class="btn-update" name="update">
                <i class="fas fa-save"></i> Simpan Perubahan Data
            </button>

            <a href="mahasiswa_kip.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Mahasiswa
            </a>
        </form>
    </div>
</div>

</body>
</html>
