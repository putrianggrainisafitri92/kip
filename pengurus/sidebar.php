<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- WAJIB: FONT AWESOME ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .sidebar {
            width: 230px;
            height: 100vh;
            background: linear-gradient(180deg, #4e0a8a, #7b35d4);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 25px;
            font-family: 'Segoe UI', Arial, sans-serif;
            box-shadow: 4px 0 18px rgba(0, 0, 0, 0.35);
            border-right: 2px solid rgba(255,255,255,0.1);
        }

        .sidebar .logo-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo-box img {
            width: 75px;
            filter: drop-shadow(0 0 5px rgba(0,0,0,0.3));
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
            letter-spacing: 1px;
            font-weight: 600;
            text-shadow: 0 0 6px rgba(0,0,0,0.25);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            padding: 14px 22px;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
            border-radius: 8px;
            margin: 5px 10px;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.20);
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .logout-btn {
            background: #d32f2f !important;
            margin-top: 20px;
            text-align: center;
            justify-content: center;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        .logout-btn:hover {
            background: #b71c1c !important;
            transform: scale(1.03);
        }
    </style>

</head>
<body>

<div class="sidebar">

    <div class="logo-box">
        <img src="../assets/logo-polinela.png" width="80" alt="Logo Polinela">
    </div>

    <h3>Admin Pengurus</h3>

    <!-- MENU DENGAN ICON -->
    <a href="index.php">
        <i class="fa-solid fa-gauge"></i> Dashboard
    </a>

    <a href="berita_add.php">
        <i class="fa-solid fa-newspaper"></i> Upload Berita
    </a>

    <a href="pedoman_upload.php">
        <i class="fa-solid fa-book"></i> Upload Pedoman
    </a>

    <a href="prestasi_list.php">
        <i class="fa-solid fa-user-graduate"></i> Upload Mahasiswa Berprestasi
    </a>

    <a href="bantuan.php">
        <i class="fa-solid fa-circle-question"></i> Bantuan
    </a>

    <a href="../logout.php" class="logout-btn">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>

</div>

</body>
</html>
