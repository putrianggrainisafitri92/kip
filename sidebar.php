<!-- ========== HEADER / TOPBAR ========== -->
<header class="topbar">
  <button id="toggle-btn" class="toggle-btn">
    <i class="bi bi-list"></i>
  </button>

  <div class="topbar-brand">
    <img src="http://localhost/KIPWEB/uploads/Logo_Polinela.png" class="logo-img">
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

    <h2 class="login-title">Masuk</h2>

      <?php if(isset($_GET['error'])): ?>
    <div class="login-alert">
        <?php 
          if($_GET['error'] === 'user'){
              echo "❌ Username tidak ditemukan!";
          } elseif($_GET['error'] === 'pass'){
              echo "❌ Password salah!";
          } elseif($_GET['error'] === 'akses'){
              echo "⚠ Level akun tidak valid!";
          }
        ?>
    </div>
<?php endif; ?>

<form action="/kipweb/cek_login.php" method="POST" class="login-form">
      
      <div class="input-wrap">
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan username..." required>
      </div>

      <div class="input-wrap">
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password..." required>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>
</div>


<!-- ========== SIDEBAR ========== -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h2 class="sidebar-title">KIP-Kuliah<br>POLINELA</h2>
  </div>

  <nav class="nav-links">
    <a href="/kipweb/index.php">
      <i class="bi bi-house-door"></i> Beranda
    </a>

    <a href="/kipweb/pedoman.php">
      <i class="bi bi-book"></i> Pedoman 2025
    </a>

    <div class="dropdown">
      <button class="dropdown-btn">
        <i class="bi bi-bar-chart"></i> Statistik
        <i class="bi bi-caret-down-fill arrow"></i>
      </button>

      <div class="dropdown-content">
        <a href="/kipweb/statistik/statistik_tahun.php">Per Tahun</a>
        <a href="/kipweb/statistik/statistik_jurusan.php">Per Jurusan</a>
        <a href="/kipweb/statistik/statistik_prodi.php">Per Prodi</a>
      </div>
    </div>

    <a href="/kipweb/pusat_layanan.php">
      <i class="bi bi-pencil-square"></i> Pusat Layanan
    </a>

    <a href="/kipweb/form_evaluasi.php">
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
  box-shadow: 0 8px 24px rgba(0,0,0,0.25);
  animation: zoomIn 0.25s ease;
  overflow: visible !important;
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
 
</style>


<!-- ========== JAVASCRIPT ========== -->
<script>
const toggleBtn = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const dropdownBtns = document.querySelectorAll('.dropdown-btn');

// LOGIN ELEMENTS
const openLogin = document.getElementById('openLogin');
const loginModal = document.getElementById('loginModal');
const closeLogin = document.getElementById('closeLogin');

/* ========== SIDEBAR TOGGLE ========== */
toggleBtn.addEventListener('click', () => {
  sidebar.classList.toggle('active');
  overlay.classList.toggle('active');
});

overlay.addEventListener('click', () => {
  sidebar.classList.remove('active');
  overlay.classList.remove('active');
});

/* ========== DROPDOWN MENU ========== */
dropdownBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    btn.parentElement.classList.toggle('open');
  });
});

/* ========== LOGIN POPUP OPEN ========== */
openLogin.addEventListener('click', () => {
  loginModal.classList.add('active');
});

/* ========== LOGIN POPUP CLOSE ========== */
closeLogin.addEventListener('click', () => {
  loginModal.classList.remove('active');
});

/* Klik luar modal menutup */
loginModal.addEventListener('click', (e) => {
  if (e.target === loginModal) {
    loginModal.classList.remove('active');
  }
});

/* ========== AUTO OPEN IF ERROR ========== */
document.addEventListener("DOMContentLoaded", function(){
    const url = new URL(window.location.href);
    if(url.searchParams.get("error")){
        loginModal.classList.add("active");
    }
});
</script>
