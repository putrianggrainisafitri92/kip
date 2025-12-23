<?php if (!isset($_SESSION)) session_start(); ?>

<?php 
    // Base URL tetap sama seperti permintaanmu
    $base = "/KIPWEB/formaban";
?>

<style>
    .sidebar{
        width: 240px;
        height: 100vh;
        background: #0d6efd;
        color:white;
        padding:20px 18px;
        position: fixed;
        left:0;
        top:0;
        overflow-y:auto;
        font-family: 'Segoe UI', sans-serif;
        box-shadow: 3px 0 10px rgba(0,0,0,0.15);
    }

    .sidebar h3{
        margin:0 0 10px 0;
        font-size:20px;
        font-weight:bold;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        letter-spacing: .5px;
    }

    .sidebar .user-box{
        background: rgba(255,255,255,0.15);
        padding:10px 12px;
        border-radius:8px;
        margin-bottom:20px;
        line-height:1.3;
    }

    .sidebar .user-box small{
        opacity:0.9;
        font-size:12px;
    }

    .menu-title{
        margin-top:18px;
        margin-bottom:8px;
        font-size:12px;
        font-weight:bold;
        opacity:0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar a{
        display:block;
        padding:8px 12px;
        margin:5px 0;
        color:white;
        text-decoration:none;
        font-size:14px;
        border-radius:6px;
        transition:0.15s;
    }

    .sidebar a:hover{
        background: rgba(255,255,255,0.25);
        transform: translateX(3px);
    }

    /* Tambahan highlight jika ingin nanti */
    .sidebar a.active{
        background: rgba(255,255,255,0.35);
        font-weight:bold;
    }
</style>

<div class="sidebar">

    <h3>WEBKIP Panel</h3>

    <div class="user-box">
        <?= $_SESSION['nama_lengkap'] ?><br>
        <small><?= $_SESSION['role'] ?></small>
    </div>

    <div class="menu-title">Utama</div>
    <a href="<?= $base ?>/dashboard.php">Dashboard</a>

    <div class="menu-title">Berita</div>
    <a href="<?= $base ?>/berita/list.php">Daftar Berita</a>
    <a href="<?= $base ?>/berita/tambah.php">Tambah Berita</a>

    <div class="menu-title">Pedoman</div>
    <a href="<?= $base ?>/pedoman/list.php">Daftar Pedoman</a>
    <a href="<?= $base ?>/pedoman/tambah.php">Tambah Pedoman</a>
    
    <div class="menu-title">Pelaporan</div>
    <a href="<?= $base ?>/pelaporan/list.php">Daftar Pelaporan</a>

    <div class="menu-title">Akun</div>
    <a href="<?= $base ?>/logout.php">Logout</a>

</div>
