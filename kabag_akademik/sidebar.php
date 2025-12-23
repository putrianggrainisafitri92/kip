<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
/* Sidebar Container */
.sidebar {
    width: 230px;
    height: 100vh;
    background: linear-gradient(180deg, #4e0a8a, #7b35d4);
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding-top: 25px;
    box-shadow: 4px 0 18px rgba(0,0,0,0.35);
    border-right: 2px solid rgba(255,255,255,0.1);
}

/* Judul */
.sidebar h3 {
    text-align: center;
    font-size: 20px;
    margin-bottom: 28px;
    font-weight: 600;
    letter-spacing: 1px;
    text-shadow: 0 0 6px rgba(0,0,0,0.25);
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

/* Menu */
.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    margin: 5px 10px;
}

.sidebar ul li a {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: #fff;
    padding: 14px 20px;
    font-size: 16px;
    border-radius: 8px;
    transition: 0.3s;
    font-weight: 500;
}

.sidebar ul li a:hover {
    background: rgba(255,255,255,0.20);
    transform: translateX(5px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}

.sidebar ul li a.logout {
    background: #d32f2f !important;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.20);
}
.sidebar ul li a.logout:hover {
    background: #b71c1c !important;
    transform: scale(1.03);
}
</style>

<div class="sidebar">
    <div class="logo-box">
        <img src="../assets/logo-polinela.png" alt="Logo">
    </div>
    <h3>Kabag Akademik</h3>

    <ul>
        <li><a href="index.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></li>
        <li><a href="validasi_berita.php"><i class="fa-solid fa-newspaper"></i>Validasi Berita</a></li>
        <li><a href="validasi_sk.php"><i class="fa-solid fa-file-signature"></i>Validasi SK</a></li>
        <li><a href="validasi_pedoman.php"><i class="fa-solid fa-book"></i>Validasi Pedoman</a></li>
        <li><a href="validasi_kip.php"><i class="fa-solid fa-coins"></i>Validasi Jumlah KIP</a></li>
        <li><a href="lihat_laporan.php"><i class="fa-solid fa-chart-line"></i>Lihat Pelaporan</a></li>
        <li><a href="lihat_evaluasi.php"><i class="fa-solid fa-clipboard-check"></i>Lihat Evaluasi</a></li>
        <li><a href="crud_user.php"><i class="fa-solid fa-users-cog"></i>CRUD User</a></li>

        <!-- POSISI DIPINDAH KE BAWAH -->
        <li><a href="saran.php"><i class="fa-solid fa-lightbulb"></i>Saran Pengguna</a></li>
        <li><a href="pertanyaan.php"><i class="fa-solid fa-circle-question"></i>Pertanyaan User</a></li>

        <li><a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
    </ul>
</div>
