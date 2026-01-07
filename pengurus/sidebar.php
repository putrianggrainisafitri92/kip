<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pengurus</title>

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

        /* Mobile Toggle Button */
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

<?php
// Notification Logic (Pengurus)
$n_ber=0; $n_ped=0; $n_tahap=0; $n_pres=0;
if(isset($koneksi)){
    $q=$koneksi->query("SELECT COUNT(*) FROM berita WHERE status='rejected' OR status='revisi'"); if($q)$n_ber=$q->fetch_row()[0];
    $q=$koneksi->query("SELECT COUNT(*) FROM pedoman WHERE status='rejected' OR status='revisi'"); if($q)$n_ped=$q->fetch_row()[0];
    $q=$koneksi->query("SELECT COUNT(*) FROM pedoman_tahapan WHERE status='rejected' OR status='revisi'"); if($q)$n_tahap=$q->fetch_row()[0];
    $q=$koneksi->query("SELECT COUNT(*) FROM mahasiswa_prestasi WHERE status='rejected' OR status='revisi'"); if($q)$n_pres=$q->fetch_row()[0];
}
?>

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

    <h3>Admin Pengurus</h3>

    <a href="index.php">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>

    <a href="berita_list.php">
        <i class="fa-solid fa-newspaper"></i> Kelola Berita
        <?php if($n_ber>0) echo "<span class='badge' style='background:#ff9800; padding:2px 6px; border-radius:4px; font-size:10px; margin-left:auto;'>$n_ber</span>"; ?>
    </a>

    <a href="pedoman_list.php">
        <i class="fa-solid fa-book"></i> Kelola Pedoman
        <?php if($n_ped>0) echo "<span class='badge' style='background:#ff9800; padding:2px 6px; border-radius:4px; font-size:10px; margin-left:auto;'>$n_ped</span>"; ?>
    </a>

    <a href="pedoman_tahapan.php">
        <i class="fa-solid fa-list-check"></i> Kelola Tahapan & Jadwal
        <?php if($n_tahap>0) echo "<span class='badge' style='background:#ff9800; padding:2px 6px; border-radius:4px; font-size:10px; margin-left:auto;'>$n_tahap</span>"; ?>
    </a>

    <a href="prestasi_list.php">
        <i class="fa-solid fa-trophy"></i> Mahasiswa Berprestasi
        <?php if($n_pres>0) echo "<span class='badge' style='background:#ff9800; padding:2px 6px; border-radius:4px; font-size:10px; margin-left:auto;'>$n_pres</span>"; ?>
    </a>

    <a href="bantuan.php">
        <i class="fa-solid fa-circle-question"></i> Bantuan
    </a>

    <a href="../logout.php" class="logout-btn">
        <i class="fa-solid fa-power-off"></i> Logout
    </a>
</div>

<audio id="notifSound" src="data:audio/mp3;base64,//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//uQxAsAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq" preload="auto"></audio>
<div id="toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 100000;"></div>

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

    const currentUrl = window.location.pathname.split('/').pop();
    const links = document.querySelectorAll('.sidebar a');
    links.forEach(link => {
        if (link.getAttribute('href') === currentUrl) link.classList.add('active');
    });

    // Notif Pengurus
    let lastCount = -1;
    function showToast(msg) {
        const c = document.getElementById('toast-container');
        if(!c) return;
        const t = document.createElement('div');
        t.style.cssText = "background:#fff; color:#333; padding:15px; margin-top:10px; border-radius:10px; box-shadow:0 5px 20px rgba(0,0,0,0.2); border-left:5px solid #ff9800; display:flex; align-items:center; gap:10px; animation:slideIn 0.5s;";
        t.innerHTML = `<i class='fa-solid fa-bell' style='color:#ff9800'></i><div><b>Info Pengurus</b><br>${msg}</div>`;
        c.appendChild(t);
        const a = document.getElementById('notifSound');
        if(a) a.play().catch(()=>{});
        setTimeout(()=>{ t.remove(); }, 5000);
    }
    
    // Add Keyframes
    const s = document.createElement('style');
    s.innerHTML = "@keyframes slideIn { from{transform:translateX(100%)} to{transform:translateX(0)} }";
    document.head.appendChild(s);

    function check() {
        fetch('get_notif.php').then(r=>r.json()).then(d=>{
            if(d.count !== undefined) {
                let c = parseInt(d.count);
                if(c > 0 && c > lastCount && lastCount != -1) showToast(d.message);
                lastCount = c;
            }
        }).catch(()=>{});
    }
    setInterval(check, 10000);
    check();
    
    document.body.addEventListener('click', function(){
        const a = document.getElementById('notifSound');
        if(a) { a.volume=0; a.play().then(()=>{ a.pause(); a.currentTime=0; a.volume=1; }).catch(()=>{}); }
    }, {once:true});
});
</script>

</body>
</html>
