<?php
session_start();

// Kalau sudah login, langsung ke beranda
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$redirect = $_GET['redirect'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Administrator</title>

<style>
/* RESET & DASAR */
* {
    box-sizing: border-box;
    font-family: "Segoe UI", Arial, sans-serif;
}
/* ANIMASI BACKGROUND */
    body {
        margin: 0;
        position: relative;
        overflow: hidden; /* Mencegah scrollbar saat zoom */
    }

    /* Pseudo-element untuk background agar bisa di-animate tanpa menggeser konten */
    body::before {
        content: "";
        position: fixed;
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        z-index: -1;
        background: 
            linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)),
            url("assets/bgpolinela.jpeg") no-repeat center center fixed;
        background-size: cover;
        animation: zoomBg 25s infinite alternate ease-in-out;
    }

    @keyframes zoomBg {
        0% { transform: scale(1); }
        100% { transform: scale(1.15); }
    }

/* WRAPPER UTAMA */
.page-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    perspective: 1000px; /* Untuk efek 3D jika perlu */
}

/* CARD INFORMASI */
.info-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px); /* Efek kaca */
    -webkit-backdrop-filter: blur(10px);
    max-width: 520px;
    width: 100%;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    text-align: center;
    
    /* ANIMASI MASUK */
    animation: slideUpFade 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    opacity: 0; /* Mulai hidden */
    transform: translateY(30px);
}

@keyframes slideUpFade {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* JUDUL */
.info-card h1 {
    margin: 0 0 15px;
    font-size: 28px;
    font-weight: 800;
    background: linear-gradient(135deg, #4B0082, #2563eb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* SUBTEXT */
.info-card p {
    margin: 0 0 25px;
    font-size: 16px;
    color: #4b5563;
    line-height: 1.6;
}

/* BUTTON LOGIN */
.btn-login {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 32px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    text-decoration: none;
    border-radius: 50px;
    border: none;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
    position: relative;
    overflow: hidden;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 25px -5px rgba(37, 99, 235, 0.5);
}

.btn-login:active {
    transform: translateY(0);
}

/* Efek kilauan pada tombol */
.btn-login::after {
    content: "";
    position: absolute;
    top: 0; left: -100%; width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    20% { left: 100%; }
    100% { left: 100%; }
}

/* Button close di modal (jika ada) */
.close-modal {
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    color: #555;
}

/* MODAL LOGIN & TEXT LAINNYA DI SIDEBAR.PHP */
#loginModal {
    position: fixed;
    inset: 0;
    z-index: 99999;

    display: none;
    align-items: center;
    justify-content: center;

    background: rgba(0, 0, 0, 0.45);
    padding: 20px;
}

/* AKTIF */
#loginModal.active {
    display: flex;
}

/* BOX LOGIN */
#loginModal .login-box {
    background: #fff;
    width: 380px;
    max-width: 100%;
    padding: 32px;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(0,0,0,.35);
    animation: pop .25s ease;
}

/* ANIMASI */
@keyframes pop {
    from { transform: scale(.9); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

/* RESPONSIVE */
@media (max-height: 600px) {
    #loginModal {
        align-items: flex-start;
        overflow-y: auto;
    }
}
</style>
</head>

<body>

<?php
$_GET['login'] = 'required';
$_GET['redirect'] = $redirect;
include 'sidebar.php';
?>

<div class="page-wrapper">
    <div class="info-card">
        <h1>Akses Administrator</h1>
        <p>
            Untuk menjaga keamanan dan integritas sistem,  
            halaman ini hanya dapat diakses oleh pengguna yang memiliki
            <strong>hak akses administrator</strong>.
        </p>
        <p>
            Silakan login kembali menggunakan akun Anda untuk melanjutkan ke sistem.
        </p>
        
        <!-- BUTTON LOGIN DITAMBAHKAN -->
        <button class="btn-login" onclick="openLogin()">
            Login Administrator
        </button>
    </div>
</div>

<script>
function openLogin() {
    // Memanggil modal yang ada di sidebar.php
    // Pastikan ID modalnya sesuai, biasanya 'loginModal'
    const modal = document.getElementById('loginModal');
    if(modal) {
        modal.classList.add('active');
    } else {
        alert('Modal login tidak ditemukan. Pastikan sidebar.php termuat.');
    }
}
</script>

</body>
</html>
