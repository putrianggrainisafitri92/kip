<?php
include '../protect.php';
check_level(13);
include '../koneksi.php';

$id = intval($_GET['id']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Catatan Revisi</title>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #f3f0ff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 550px;
        margin: 70px auto;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        animation: fadeIn .4s ease;
    }

    @keyframes fadeIn {
        from { opacity:0; transform:translateY(10px); }
        to { opacity:1; transform:translateY(0); }
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #4b0082;
        font-size: 24px;
        font-weight: 700;
    }

    textarea {
        width: 100%;
        height: 150px;
        border-radius: 10px;
        border: 2px solid #c7b6ff;
        padding: 12px;
        font-size: 15px;
        outline: none;
        resize: vertical;
        transition: .2s;
    }

    textarea:focus {
        border-color: #7b4bff;
        box-shadow: 0 0 8px rgba(123, 75, 255, 0.3);
    }

    .btn {
        width: 100%;
        margin-top: 20px;
        padding: 12px;
        background: #7b4bff;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: .2s;
    }

    .btn:hover {
        background: #6a3fe8;
        transform: translateY(-2px);
    }

    .btn-back {
        display: block;
        margin-top: 15px;
        text-align: center;
        color: #6a3fe8;
        font-weight: 600;
        text-decoration: none;
        transition: .2s;
    }

    .btn-back:hover {
        color: #4b0082;
        text-decoration: underline;
    }
</style>
</head>

<body>

<div class="container">

    <h2>Catatan Revisi Berita</h2>

    <form action="validasi_berita_proses.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="status" value="rejected">

        <textarea name="catatan" placeholder="Tulis catatan revisi di sini..." required></textarea>

        <button type="submit" class="btn">Kirim Revisi</button>
    </form>

    <a href="validasi_berita.php" class="btn-back">← Kembali</a>
</div>

</body>
</html>
