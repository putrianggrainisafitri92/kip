<!-- ========== HEADER / TOPBAR ========== -->
<?php
// Deteksi direktori saat ini untuk menentukan base url
if (file_exists('index.php')) {
    $base_url = '';
} elseif (file_exists('../index.php')) {
    $base_url = '../';
} else {
    $base_url = ''; // Default fallback
}
?>
<header class="topbar">
  <button id="toggle-btn" class="toggle-btn">
    <i class="bi bi-list"></i>
  </button>

  <div class="topbar-brand">
    <img src="<?= $base_url ?>assets/logo-polinela.png" class="logo-img">
    <h1 class="topbar-title">Sistem Informasi KIP-Kuliah</h1>
  </div>

  <!-- LOGIN BUTTON -->
  <div class="topbar-login">
    <button class="login-btn" id="openLogin">
  <i class="bi bi-box-arrow-in-right"></i> Login
  </button>
  </div>
</header>



<!-- ===== LOGIN MODAL ===== -->
<div id="loginModal" class="login-modal">
  <div class="login-box">
    <span id="closeLogin" class="close-login">&times;</span>

    <h2 class="login-title">LOGIN ADMIN</h2>
    <p class="login-note">
      ⚠ Akses login <strong>khusus Admin</strong>. Mahasiswa tidak dapat login.
    </p>

    <!-- ERROR LOGIN SAJA -->
    <?php if(isset($_GET['login_error'])): ?>
      <div class="login-alert">
        <?php 
          if($_GET['login_error'] === 'user'){
              echo "❌ Username tidak ditemukan!";
          } elseif($_GET['login_error'] === 'pass'){
              echo "❌ Password salah!";
          } elseif($_GET['login_error'] === 'empty'){
              echo "⚠ Semua field wajib diisi!";
          }
        ?>
      </div>
    <?php endif; ?>

    <form action="<?= $base_url ?>cek_login.php" method="POST">
      <div class="input-wrap">
        <label>Username</label>
        <input type="text" name="username" required>
      </div>

      <div class="input-wrap">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>

    <!-- LINK KE RESET -->
    <div style="text-align:center; margin:10px 0;">
      <a href="#" id="openReset" style="color:#6a0dad;font-weight:600;">
        Lupa password?
      </a>
    </div>

  </div>
</div>




<!-- ===== RESET PASSWORD MODAL ===== -->
<div id="resetModal" class="login-modal">
  <div class="login-box">
    <span id="closeReset" class="close-login">&times;</span>

    <h2 class="login-title">Reset Password</h2>

    <!-- ERROR RESET SAJA -->
    <?php if(isset($_GET['reset_error'])): ?>
      <div class="login-alert">
        <?php
          if($_GET['reset_error']=='empty'){
            echo "⚠ Semua field wajib diisi!";
          } elseif($_GET['reset_error']=='user'){
            echo "❌ Username tidak ditemukan!";
          }
        ?>
      </div>
    <?php endif; ?>

 <?php if(isset($_GET['reset_success'])): ?>
  <div class="login-alert alert-purple">
     Password berhasil diubah
  </div>
<?php endif; ?>


    <form action="<?= $base_url ?>reset_password.php" method="POST">
      <div class="input-wrap">
        <label>Username</label>
        <input type="text" name="username" required>
      </div>

      <div class="input-wrap">
        <label>Password Baru</label>
        <input type="password" name="new_password" required>
      </div>

      <button type="submit" class="btn-login">
        Ubah Password
      </button>
    </form>

    <!-- KEMBALI LOGIN -->
    <div style="text-align:center;margin-top:10px;">
      <a href="#" id="backLogin" style="font-weight:600;">
        ← Kembali ke Login
      </a>
    </div>

  </div>
</div>




<!-- ========== SIDEBAR ========== -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h2 class="sidebar-title">KIP-Kuliah<br>POLINELA</h2>
  </div>

  <nav class="nav-links">
    <a href="<?= $base_url ?>index.php">
      <i class="bi bi-house-door"></i> Beranda
    </a>

    <a href="<?= $base_url ?>pedoman.php">
      <i class="bi bi-book"></i> Pedoman 2025
    </a>

    <div class="dropdown">
      <button class="dropdown-btn">
        <i class="bi bi-bar-chart"></i> Statistik
        <i class="bi bi-caret-down-fill arrow"></i>
      </button>

      <div class="dropdown-content">
        <a href="<?= $base_url ?>statistik/statistik_tahun.php">Per Tahun</a>
        <a href="<?= $base_url ?>statistik/statistik_jurusan.php">Per Jurusan</a>
        <a href="<?= $base_url ?>statistik/statistik_prodi.php">Per Prodi</a>
      </div>
    </div>

    <a href="<?= $base_url ?>pusat_layanan.php">
      <i class="bi bi-pencil-square"></i> Pusat Layanan
    </a>

    <a href="<?= $base_url ?>form_evaluasi.php">
      <i class="bi bi-clipboard-check"></i> Evaluasi Mahasiswa
    </a>
  </nav>
</aside>

<div class="overlay" id="overlay"></div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">


<!-- ========== CSS FIXED, RAPIH & PRO ========== -->
<style>
/* ===== TOPBAR ===== */
.topbar {
  width: 100%;
  height: 72px;
  background: linear-gradient(90deg, #4B0082, #673AB7);
  color: #fff;
  display: flex;
  align-items: center;
  padding: 0 25px;
  justify-content: space-between;
  position: fixed;
  top: 0;
  left: 0;
  box-shadow: 0 4px 14px rgba(0,0,0,0.25);
  z-index: 3000;
}

.toggle-btn {
  background: none;
  border: none;
  color: #fff;
  font-size: 2rem;
  cursor: pointer;
  margin-right: 20px;
}

.topbar-brand {
  display: flex;
  align-items: center;
  gap: 12px;
}

.logo-img {
  height: 45px;
  border-radius: 50%;
}

.topbar-title {
  font-size: 1.3rem;
  font-weight: 600;
  margin: 0;
}

/* ===== LOGIN BUTTON ===== */
.topbar-login {
  margin-left: auto;
}

.login-btn {
  padding: 10px 20px;
  background: rgba(255,255,255,0.15);
  border: 1px solid rgba(255,255,255,0.30);
  border-radius: 10px;
  color: #fff;
  font-size: 1rem;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: 0.25s;
}

.login-btn:hover {
  background: rgba(255,255,255,0.30);
  transform: scale(1.05);
}

/* ===== LOGIN NOTE (ADMIN ONLY) ===== */
.login-note {
  text-align: center;
  font-size: 0.9rem;
  color: #555;
  margin-bottom: 15px;
}

.login-note strong {
  color: #4B0082;
}


/* ===== PERTEGAS TEKS LOGIN & RESET ===== */

/* Judul modal */
.login-title {
  color: #3b0764;          /* Ungu tua, kontras tinggi */
  font-weight: 800;        /* Extra bold */
  letter-spacing: 0.3px;
}

/* Catatan admin only */
.login-note {
  color: #1f2937;          /* Abu gelap (jelas di putih) */
  font-weight: 600;
}

/* Label input */
.input-wrap label {
  color: #111827;          /* Hampir hitam */
  font-weight: 700;
}

/* Isi input */
.input-wrap input {
  color: #111827;
  font-weight: 600;
}

/* Link lupa password & kembali login */
#openReset,
#backLogin {
  color: #4B0082 !important;
  font-weight: 700;
}

/* Hover link */
#openReset:hover,
#backLogin:hover {
  color: #2e004f !important;
  text-decoration: underline;
}

/* Alert text (error & success) */
.login-alert {
  font-weight: 700;
}


/* ===== SIDEBAR ===== */
.sidebar {
  position: fixed;
  top: 0;
  left: -260px;
  width: 260px;
  height: 100%;
  background: #4B0082;
  padding-top: 90px; 
  box-shadow: 4px 0 12px rgba(0,0,0,0.25);
  transition: 0.3s;
  z-index: 2500;
}

.sidebar.active {
  left: 0;
}

.sidebar-header {
  text-align: center;
  margin-bottom: 15px;
}

.sidebar-title {
  font-size: 1.3rem;
  font-weight: 700;
  color: #fff;
}

/* ===== NAVIGATION ===== */
.nav-links {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-links a {
  color: #fff;
  text-decoration: none;
  padding: 14px 24px;
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 1rem;
}

.nav-links a:hover {
  background: rgba(255,255,255,0.15);
}

.alert-purple {
  background: #f3e8ff;
  color: #5b21b6;
  border-left: 4px solid #7c3aed;
}


/* ===== DROPDOWN ===== */
.dropdown-btn {
  padding: 14px 24px;
  color: white;
  border: none;
  background: none;
  width: 100%;
  display: flex;
  align-items: center;
  gap: 14px;
  cursor: pointer;
}

.dropdown-content {
  display: none;
  flex-direction: column;
  background: rgba(75,0,130,0.92);
}

.dropdown.open .dropdown-content {
  display: flex;
}

.dropdown.open .arrow {
  transform: rotate(180deg);
}

/* ===== OVERLAY ===== */
.overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.45);
  opacity: 0;
  visibility: hidden;
  transition: 0.3s;
  z-index: 2000;
}

.overlay.active {
  opacity: 1;
  visibility: visible;
}

body {
  margin: 0;
  padding: 0;
}

main, .content {
  padding-top: 85px;
}
/* ===== LOGIN MODAL ===== */
.login-modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.55);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 5000;
}

.login-modal.active {
  display: flex;
}

/* Box */
.login-box {
  width: 380px;
  background: #fff;
  border-radius: 16px;
  padding: 30px 35px;
  position: relative;
  /* Glow ungu statis lembut */
  box-shadow: 0 0 20px rgba(124, 58, 237, 0.3);
  animation: zoomIn 0.3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
  overflow: visible !important;
  z-index: 10;
}

/* Moving Border - Purple Gradient */
.login-box::before {
  content: '';
  position: absolute;
  top: -4px; right: -4px; bottom: -4px; left: -4px;
  background: linear-gradient(135deg, #7C3AED, #A78BFA, #7C3AED);
  z-index: -1;
  border-radius: 20px;
}

/* White Shimmer (Kilauan Putih) */

.login-box::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: linear-gradient(120deg, transparent, rgba(139, 92, 246, 0.4), transparent);
  background-size: 200% 100%;
  z-index: -1;
  border-radius: 16px;
  animation: whiteShimmer 3s infinite linear;
}

@keyframes whiteShimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

@keyframes zoomIn {
  from { transform: scale(0.85); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

/* Close button */
.close-login {
  position: absolute;
  top: 12px;
  right: 14px;
  font-size: 1.7rem;
  cursor: pointer;
  color: #333;
}
.close-login:hover {
  color: #000;
}

/* Title */
.login-title {
  text-align: center;
  font-size: 1.6rem;
  margin-bottom: 20px;
  color: #4B0082;
}

/* Input */
.input-wrap {
  margin-bottom: 18px;
}

.input-wrap label {
  font-size: 0.9rem;
  color: #333;
}

.input-wrap input {
  width: 100%;
  padding: 11px;
  margin-top: 6px;
  border-radius: 8px;
  border: 1px solid #aaa;
  font-size: 1rem;
}

/* Button */
.btn-login {
  width: 100%;
  padding: 13px;
  background: #4B0082;
  border: none;
  border-radius: 10px;
  color: white;
  font-size: 1.1rem;
  cursor: pointer;
  transition: 0.2s;
}

.btn-login:hover {
  background: #673AB7;
}

.login-alert {
    background: #ffdddd;
    color: #b30000 !important;
    padding: 12px 15px !important;
    margin-bottom: 15px;
    border-left: 4px solid #b30000;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 600;
    width: 100%;
    display: block !important;
    height: auto !important;
    line-height: 1.3rem !important;
}
 
/* ========== RESPONSIVE DESIGN (HP & TABLET) ========== */
@media (max-width: 1024px) {
  .topbar-title { font-size: 1.1rem; }
  .logo-img { height: 38px; }
}

@media (max-width: 768px) {
  .topbar { height: 60px; padding: 0 15px; }
  .topbar-title { font-size: 0.95rem; }
  .logo-img { height: 32px; }
  .toggle-btn { font-size: 1.6rem; margin-right: 12px; }
  .login-btn { padding: 8px 14px; font-size: 0.9rem; }
  
  .sidebar { width: 240px; left: -250px; padding-top: 75px; }
  .sidebar-header .sidebar-title { font-size: 1.1rem; }
  .nav-links a { padding: 12px 20px; font-size: 0.95rem; }
  .dropdown-btn { padding: 12px 20px; font-size: 0.95rem; }
  
  main, .content { padding-top: 75px; }
  
  .login-box { width: 90%; max-width: 360px; padding: 25px; }
  .login-title { font-size: 1.4rem; }
}

@media (max-width: 480px) {
  .topbar { height: 55px; padding: 0 10px; }
  .topbar-title { font-size: 0.8rem; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
  .logo-img { height: 28px; }
  .toggle-btn { font-size: 1.4rem; margin-right: 8px; }
  
  .login-btn { padding: 6px 10px; font-size: 0.8rem; }
  .login-btn i { display: none; }
  
  /* Sidebar full screen width hampir penuh di HP */
  .sidebar { width: 260px; left: -270px; padding-top: 70px; }
  .sidebarui-header .sidebar-title { font-size: 1rem; }
  
  main, .content { padding-top: 70px; }
  
  .login-box { width: 95%; padding: 20px; }
  .login-title { font-size: 1.2rem; margin-bottom: 15px; }
  .input-wrap input { padding: 10px; font-size: 0.95rem; }
  .btn-login { padding: 11px; font-size: 1rem; }
}

</style>


<!-- ========== JAVASCRIPT ========== -->
<script>
const toggleBtn = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const dropdownBtns = document.querySelectorAll('.dropdown-btn');

// LOGIN
const openLogin = document.getElementById('openLogin');
const loginModal = document.getElementById('loginModal');
const closeLogin = document.getElementById('closeLogin');

// RESET
const openReset  = document.getElementById('openReset');
const resetModal = document.getElementById('resetModal');
const closeReset = document.getElementById('closeReset');
const backLogin  = document.getElementById('backLogin');

/* SIDEBAR */
toggleBtn.addEventListener('click', () => {
  sidebar.classList.toggle('active');
  overlay.classList.toggle('active');
});

overlay.addEventListener('click', () => {
  sidebar.classList.remove('active');
  overlay.classList.remove('active');
});

/* DROPDOWN */
dropdownBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    btn.parentElement.classList.toggle('open');
  });
});

/* OPEN LOGIN */
openLogin.addEventListener('click', () => {
  loginModal.classList.add('active');
});

/* CLOSE LOGIN */
closeLogin.addEventListener('click', () => {
  loginModal.classList.remove('active');
});

/* CLICK OUTSIDE LOGIN */
loginModal.addEventListener('click', (e) => {
  if (e.target === loginModal) {
    loginModal.classList.remove('active');
  }
});

/* OPEN RESET */
openReset.addEventListener('click', (e) => {
  e.preventDefault();
  loginModal.classList.remove('active');
  resetModal.classList.add('active');
});

/* CLOSE RESET */
closeReset.addEventListener('click', () => {
  resetModal.classList.remove('active');
});

/* CLICK OUTSIDE RESET */
resetModal.addEventListener('click', (e) => {
  if (e.target === resetModal) {
    resetModal.classList.remove('active');
  }
});

/* BACK TO LOGIN */
if(backLogin){
  backLogin.addEventListener('click', function(e){
    e.preventDefault();
    resetModal.classList.remove('active');
    loginModal.classList.add('active');
  });
}

/* AUTO OPEN MODAL SESUAI KONTEKS */
document.addEventListener("DOMContentLoaded", function(){
  const url = new URL(window.location.href);

  if(url.searchParams.get("login_error")){
    loginModal.classList.add("active");
  }

  if(url.searchParams.get("reset_error") || url.searchParams.get("reset_success")){
    resetModal.classList.add("active");
  }
});
</script>