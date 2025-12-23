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
body {
    background: 
        linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)),
        url("assets/bgpolinela.jpeg") no-repeat center center fixed;
    background-size: cover;
}

/* WRAPPER UTAMA */
.page-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* CARD INFORMASI */
.info-card {
    background: #ffffff;
    max-width: 520px;
    width: 100%;
    padding: 32px;
    border-radius: 18px;
    box-shadow: 0 15px 40px rgba(0,0,0,.15);
    text-align: center;
}

/* JUDUL */
.info-card h1 {
    margin: 0 0 12px;
    font-size: 24px;
    color: #333;
}

/* SUBTEXT */
.info-card p {
    margin: 0 0 20px;
    font-size: 15px;
    color: #555;
    line-height: 1.6;
}

/* BUTTON LOGIN */
.btn-login {
    display: inline-block;
    padding: 12px 22px;
    background: #2563eb;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-size: 15px;
    transition: background .2s;
}

.btn-login:hover {
    background: #1e4ed8;
}

/* MODAL LOGIN */
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

       
    </div>
</div>

<script>
function openLogin() {
    document.getElementById('loginModal').classList.add('active');
}
</script>

</body>
</html>
