<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Admin</title>

    <!-- FONT AWESOME (CDN TERJAMIN BERFUNGSI) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    /* ===== SIDEBAR UNGU ELEGAN ===== */
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
        z-index: 1000;
        transition: 0.3s;
    }

    /* Logo */
    .sidebar .logo-box {
        text-align: center;
        margin-bottom: 18px;
    }

    .sidebar .logo-box img {
        width: 75px;
        filter: drop-shadow(0 0 5px rgba(0,0,0,0.3));
    }

    /* Title */
    .sidebar h3 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 19px;
        letter-spacing: 1px;
        font-weight: 600;
        text-shadow: 0 0 6px rgba(0,0,0,0.25);
    }

    /* Menu Links */
    .sidebar a {
        display: flex;
        align-items: center;
        padding: 11px 18px;
        margin: 4px 10px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        color: white;
        transition: 0.25s;
    }

    /* ICON FIX WIDTH */
    .sidebar a i {
        width: 22px;
        text-align: center;
        margin-right: 10px;
        font-size: 17px;
    }

    /* Hover */
    .sidebar a:hover {
        background: rgba(255,255,255,0.22);
        transform: translateX(5px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    /* Logout */
    .logout-btn {
        background: #d32f2f !important;
        margin-top: 25px;
        justify-content: center;
        letter-spacing: 0.5px;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }

    .logout-btn:hover {
        background: #b71c1c !important;
        transform: scale(1.03);
    }

    /* MAIN CONTENT */
    .main-content {
        margin-left: 230px;
        padding: 25px;
        transition: 0.3s;
    }

    /* MOBILE TOGGLE */
    .sidebar-toggle {
        display: none;
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1100;
        background: #6f42c1;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 900;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar {
            left: -230px;
        }
        .sidebar.active {
            left: 0;
        }
        .main-content {
            margin-left: 0 !important;
        }
        .sidebar-toggle {
            display: block;
        }
        .sidebar-overlay.active {
            display: block;
        }
    }
    </style>

</head>
<body>

<button class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>

<div class="sidebar" id="sidebar">

    <div class="logo-box">
        <img src="../assets/logo-polinela.png" alt="Logo">
    </div>

    <h3>Admin Level 2</h3>

    <!-- Dashboard -->
    <a href="index.php">
        <i class="fa-solid fa-gauge"></i>
        Dashboard
    </a>

    <!-- SK KIP -->
    <a href="sk_list.php">
        <i class="fa-solid fa-file-lines"></i>
        Data SK
    </a>

    <!-- Mahasiswa -->
    <a href="mahasiswa_kip.php">
        <i class="fa-solid fa-user-graduate"></i>
        Data Mahasiswa
    </a>

    <!-- Laporan -->
    <a href="laporan_list.php">
        <i class="fa-solid fa-file-alt"></i>
        Data Laporan
    </a>

    <!-- Evaluasi -->
    <a href="evaluasi_list.php">
        <i class="fa-solid fa-clipboard-check"></i>
        Evaluasi Mahasiswa
    </a>

    <!-- Logout -->
    <a href="../logout.php" class="logout-btn">
        <i class="fa-solid fa-right-from-bracket"></i>
        Logout
    </a>

</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('overlay').classList.toggle('active');
}
</script>

