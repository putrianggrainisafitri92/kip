<?php
session_start();
include '../protect.php';
check_level(13);
include '../koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0) die("ID tidak valid.");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Minta Revisi Berita - Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8f2ff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: white;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(78, 10, 138, 0.1);
            animation: zoomIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #4e0a8a;
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-alert {
            background: #f8f2ff;
            padding: 15px 20px;
            border-radius: 15px;
            border-left: 5px solid #7b35d4;
            margin-bottom: 25px;
            font-size: 0.9rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        textarea {
            width: 100%;
            height: 180px;
            border-radius: 15px;
            border: 2px solid #e0d5f5;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            outline: none;
            resize: vertical;
            transition: 0.3s;
            box-sizing: border-box;
            background: #fdfcff;
        }

        textarea:focus {
            border-color: #7b35d4;
            background: white;
            box-shadow: 0 5px 15px rgba(123, 53, 212, 0.1);
        }

        .btn-group {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-send {
            background: linear-gradient(135deg, #4e0a8a, #7b35d4);
            color: white;
            box-shadow: 0 8px 20px rgba(78, 10, 138, 0.3);
        }

        .btn-send:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(78, 10, 138, 0.4);
        }

        .btn-back {
            background: #f1f1f1;
            color: #666;
            text-decoration: none;
        }
        .btn-back:hover { background: #e5e5e5; color: #333; }

        @media (max-width: 600px) {
            .container { padding: 30px 20px; }
            h2 { font-size: 20px; }
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Catatan Revisi Berita</h2>

    <div class="info-alert">
        <i class="fas fa-info-circle fa-lg" style="color: #7b35d4;"></i>
        <span>Pengurus akan menerima catatan ini dan status berita akan berubah menjadi <b>REVISI</b>.</span>
    </div>

    <form action="validasi_berita_proses.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="status" value="rejected">

        <textarea name="catatan" placeholder="Tulis instruksi atau alasan penolakan secara jelas di sini..." required></textarea>

        <div class="btn-group">
            <button type="submit" class="btn btn-send">
                <i class="fas fa-paper-plane"></i> Kirim Catatan Revisi
            </button>
            <a href="validasi_berita_detail.php?id=<?= $id ?>" class="btn btn-back">
                <i class="fas fa-times"></i> Batalkan
            </a>
        </div>
    </form>
</div>

</body>
</html>
