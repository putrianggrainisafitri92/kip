<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>403 Forbidden</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    body {
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #000428, #004e92);
        font-family: "Poppins", sans-serif;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
    }

    .container {
        text-align: center;
        animation: fadeIn 1.2s ease-in-out;
    }

    h1 {
        font-size: 130px;
        margin: 0;
        font-weight: 700;
        letter-spacing: 5px;
        color: #ff4b5c;
        text-shadow: 0 0 20px rgba(255, 75, 92, 0.7);
        animation: glow 2s infinite alternate;
    }

    h2 {
        margin-top: -20px;
        font-size: 30px;
        font-weight: 400;
        opacity: 0.9;
    }

    p {
        margin-top: 10px;
        font-size: 18px;
        opacity: 0.85;
    }

    .btn {
        display: inline-block;
        margin-top: 25px;
        padding: 12px 25px;
        background: #ff4b5c;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(255, 75, 92, 0.4);
        transition: 0.3s ease;
    }

    .btn:hover {
        background: #ff1f3a;
        box-shadow: 0 6px 20px rgba(255, 31, 58, 0.6);
        transform: translateY(-3px);
    }

    @keyframes glow {
        from { text-shadow: 0 0 10px rgba(255, 75, 92, 0.6); }
        to { text-shadow: 0 0 25px rgba(255, 75, 92, 1); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>

<body>

<div class="container">
    <h1>403</h1>
    <h2>Akses Ditolak</h2>
    <p>Anda tidak memiliki izin untuk membuka halaman ini.</p>

    <a href="login.php" class="btn">Kembali ke Login</a>
</div>

</body>
</html>
