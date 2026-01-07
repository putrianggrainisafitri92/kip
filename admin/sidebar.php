<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --sidebar-width: 240px;
            --primary-purple: #4e0a8a;
            --secondary-purple: #7b35d4;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-purple), var(--secondary-purple));
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 25px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 4px 0 18px rgba(0, 0, 0, 0.35);
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10000;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

        .sidebar .logo-box { text-align: center; margin-bottom: 20px; position: relative; }
        .sidebar .logo-box img { width: 70px; filter: drop-shadow(0 0 5px rgba(0,0,0,0.3)); }

        .sidebar h3 {
            text-align: center;
            margin: 0 0 25px 0;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
            margin: 4px 15px;
            border-radius: 10px;
            font-weight: 500;
        }

        .sidebar a i { width: 20px; text-align: center; font-size: 18px; }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }

        .logout-btn {
            background: #ff4d4d !important;
            color: white !important;
            margin-top: 30px !important;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(255, 77, 77, 0.3);
        }

        /* Responsive Hamburger Button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            width: 45px;
            height: 45px;
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 20px;
            cursor: pointer;
            z-index: 99999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .close-sidebar {
            display: none;
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            z-index: 11000;
        }

        /* Overlay Background */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(3px);
            z-index: 9999;
            opacity: 0;
            transition: 0.3s;
        }

        @media (max-width: 1024px) {
            .sidebar {
                left: -260px;
            }
            .sidebar.show {
                left: 0;
            }
            .mobile-toggle {
                display: flex !important;
            }
            .close-sidebar {
                display: block;
            }
            .sidebar.show ~ .sidebar-overlay {
                display: block;
                opacity: 1;
            }
        }
    </style>
</head>
<body>




<button class="mobile-toggle" id="btnToggle">
    <i class="fa-solid fa-bars"></i>
</button>

<div class="sidebar-overlay" id="overlay"></div>

<div class="sidebar" id="sidebarMenu">
    <button class="close-sidebar" id="btnClose">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <div class="logo-box">
        <img src="../assets/logo-polinela.png" alt="Logo Polinela">
    </div>

    <h3>Admin</h3>

    <a href="index.php">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>

    <a href="sk_list.php">
        <i class="fa-solid fa-file-contract"></i> Kelola SK KIP
    </a>

    <a href="mahasiswa_kip.php">
        <i class="fa-solid fa-user-graduate"></i> Data Mahasiswa
    </a>

    <a href="laporan_list.php">
        <i class="fa-solid fa-file-invoice"></i> Data Laporan
    </a>

    <a href="evaluasi_list.php">
        <i class="fa-solid fa-clipboard-check"></i> Evaluasi Mhs
    </a>

    <a href="bantuan.php">
        <i class="fa-solid fa-circle-question"></i> Bantuan
    </a>

    <a href="../logout.php" class="logout-btn">
        <i class="fa-solid fa-power-off"></i> Logout
    </a>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnToggle = document.getElementById('btnToggle');
    const btnClose = document.getElementById('btnClose');
    const sidebar = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('overlay');

    if(btnToggle && sidebar) {
        function toggleSidebar() {
            sidebar.classList.toggle('show');
        }

        btnToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });

        if(btnClose) btnClose.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
    }

    // Active Link
    const currentUrl = window.location.pathname.split('/').pop();
    const links = document.querySelectorAll('.sidebar a');
    links.forEach(link => {
        if (link.getAttribute('href') === currentUrl) link.classList.add('active');
    });

});
</script>

</body>
</html>
