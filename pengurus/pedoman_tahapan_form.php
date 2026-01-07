<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['level']) || $_SESSION['level'] != '11') {
    die("Akses ditolak!");
}
include "../koneksi.php";
include "sidebar.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$judul = "";
$deskripsi = "";
$urutan = 1;
$is_edit = false;

if ($id) {
    $q = mysqli_query($koneksi, "SELECT * FROM pedoman_tahapan WHERE id='$id'");
    $data = mysqli_fetch_assoc($q);
    if ($data) {
        $judul = $data['judul'];
        $deskripsi = $data['deskripsi'];
        $urutan = $data['urutan'];
        $kategori = $data['kategori'];
        $is_edit = true;
    }
}

// Map category key to label
$labels = [
    'tahapan_umum' => 'Tahapan Umum 2026',
    'snbp' => 'Proses Seleksi SNBP',
    'utbk' => 'Proses Seleksi UTBK-SNBT',
    'kip' => 'Proses KIP Kuliah'
];
$cat_label = isset($labels[$kategori]) ? $labels[$kategori] : $kategori;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $is_edit ? 'Edit' : 'Tambah' ?> Item Tahapan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 24px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #d1c4e9;
            margin-bottom: 30px;
            font-weight: 500;
        }

        label {
            display: block;
            margin-bottom: 8px;
            margin-top: 20px;
            font-weight: 500;
            font-size: 14px;
            color: #f3e5f5;
            letter-spacing: 0.5px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            background: rgba(255,255,255,0.2);
            border-color: #ba68c8;
            box-shadow: 0 0 15px rgba(186, 104, 200, 0.4);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 40px;
        }

        button, .btn-cancel {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            text-decoration: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-save {
            background: linear-gradient(135deg, #ab47bc, #8e24aa);
            color: white;
            box-shadow: 0 4px 15px rgba(142, 36, 170, 0.4);
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(142, 36, 170, 0.5);
            background: linear-gradient(135deg, #ba68c8, #9c27b0);
        }

        .btn-cancel {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-cancel:hover {
            background: rgba(255,255,255,0.2);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 80px 20px; }
        }
        @media (max-width: 600px) {
            .form-card { padding: 25px; }
            h2 { font-size: 20px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="form-card">
        <h2><?= $is_edit ? 'Edit' : 'Tambah' ?> Data</h2>
        <div class="subtitle">Kategori: <?= htmlspecialchars($cat_label) ?></div>
        
        <form action="pedoman_tahapan_proses.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="kategori" value="<?= $kategori ?>">
            
            <label>Judul Tahapan</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($judul) ?>" required placeholder="Contoh: Pendaftaran Akun Siswa">
            
            <label>Jadwal / Deskripsi (Tanggal)</label>
            <input type="text" name="deskripsi" value="<?= htmlspecialchars($deskripsi) ?>" required placeholder="Contoh: 14 Februari – 27 Februari 2026">
            
            <label>Urutan Tampil</label>
            <input type="number" name="urutan" value="<?= $urutan ?>" required>
            
            <div class="btn-group">
                <a href="pedoman_tahapan.php" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" name="simpan" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
