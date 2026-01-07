<?php
session_start();

// Cek login admin level 2
if (!isset($_SESSION['level']) || $_SESSION['level'] != '12') {
    header("Location: ../index.php?error=akses");
    exit;
}

include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tatacara Penggunaan - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #4e0a8a;
            --accent-purple: #7b35d4;
            --bg-light: #f8f2ff;
            --glass-white: rgba(255, 255, 255, 0.85);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            margin: 0;
            color: #333;
            overflow-x: hidden;
        }

        /* ===== BACKGROUND ANIMATIONS ===== */
        .animated-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f2ff 0%, #e0d0ff 100%);
        }

        .bg-circle {
            position: absolute;
            background: rgba(123, 53, 212, 0.05);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        .c1 { width: 400px; height: 400px; top: -100px; right: -100px; }
        .c2 { width: 300px; height: 300px; bottom: -50px; left: -50px; animation-delay: -5s; }
        .c3 { width: 200px; height: 200px; top: 40%; left: 10%; animation-delay: -10s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        /* ===== CONTENT WRAPPER ===== */
        .content {
            margin-left: 240px;
            padding: 60px 40px;
            min-height: 100vh;
            transition: 0.3s ease;
            position: relative;
        }

        /* ===== HEADER SECTION ===== */
        .header-section {
            text-align: center;
            margin-bottom: 60px;
            animation: slideDown 1s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-section h2 {
            color: var(--primary-purple);
            font-size: 38px;
            font-weight: 800;
            margin: 0;
            display: inline-block;
            position: relative;
        }

        .header-section h2 span {
            color: var(--accent-purple);
            display: block;
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 2px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .header-section .line {
            width: 100px;
            height: 6px;
            background: var(--accent-purple);
            margin: 20px auto;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .header-section .line::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: white;
            animation: sweep 2s infinite;
        }

        @keyframes sweep {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: 100%; }
        }

        /* ===== GUIDE GRID ===== */
        .guide-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .guide-card {
            background: var(--glass-white);
            backdrop-filter: blur(10px);
            padding: 35px 25px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid rgba(123, 53, 212, 0.1);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            transform: translateY(30px);
            position: relative;
            overflow: hidden;
        }

        .guide-card.show { opacity: 1; transform: translateY(0); }

        .guide-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(123, 53, 212, 0.12);
            border-color: var(--accent-purple);
            background: white;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #f0e6ff;
            color: var(--accent-purple);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            transition: 0.4s ease;
        }

        .guide-card:hover .icon-box {
            background: var(--accent-purple);
            color: white;
            transform: rotateY(360deg);
        }

        .guide-card h3 {
            margin: 0 0 15px 0;
            font-size: 1.25rem;
            color: var(--primary-purple);
            font-weight: 800;
        }

        /* ===== STEP STYLING ===== */
        .steps {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .steps li {
            margin-bottom: 12px;
            font-size: 0.9rem;
            color: #555;
            display: flex;
            gap: 12px;
            line-height: 1.5;
        }

        .step-num {
            background: #eee;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
            color: var(--primary-purple);
        }

        .guide-card:hover .step-num {
            background: var(--accent-purple);
            color: white;
        }

        .important-box {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            font-size: 0.75rem;
            color: #5d4037;
        }

        .pop-dot {
            position: absolute;
            width: 8px; height: 8px;
            background: var(--accent-purple);
            border-radius: 50%;
            top: 20px; right: 20px;
            opacity: 0.2;
        }

        .guide-card:hover .pop-dot { animation: ping 1s infinite; opacity: 0.5; }

        @keyframes ping {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(3); opacity: 0; }
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 100px 20px 40px 20px; }
            .header-section h2 { font-size: 28px; }
        }

        @media (max-width: 480px) {
            .guide-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="animated-bg">
    <div class="bg-circle c1"></div>
    <div class="bg-circle c2"></div>
    <div class="bg-circle c3"></div>
</div>

<?php include "sidebar.php"; ?>

<div class="content">
    <div class="header-section">
        <h2>Tatacara Penggunaan Web <span>Panduan Administratif Level 2</span></h2>
        <div class="line"></div>
    </div>

    <div class="guide-grid" id="guideGrid">
<<<<<<< HEAD
        <!-- 1. Dashboard -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-desktop"></i></div>
            <h3>1. Dashboard</h3>
            <ul class="steps">
                <li><div class="step-num">1</div> Login ke akun Admin.</li>
                <li><div class="step-num">2</div> Cek grafik statistik SK, Mahasiswa, Laporan & Evaluasi.</li>
                <li><div class="step-num">3</div> Pantau ringkasan data terkini di halaman utama.</li>
            </ul>
        </div>

        <!-- 2. Kelola SK -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-file-invoice"></i></div>
            <h3>2. Pengelolaan Dokumen SK</h3>
=======
        <!-- Kelola SK -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-file-invoice"></i></div>
            <h3>1. Pengelolaan Dokumen SK</h3>
>>>>>>> 5aacb94924f591cbbd3502ad80e2e6f2445cc3a0
            <ul class="steps">
                <li><div class="step-num">1</div> Klik menu <b>SK KIP</b> -> <b>Tambah SK</b>.</li>
                <li><div class="step-num">2</div> Isi Nama, Tahun, dan nomor SK.</li>
                <li><div class="step-num">3</div> Unggah file format <b>PDF/Excel</b>.</li>
                <li><div class="step-num">4</div> Tunggu validasi pimpinan (Kabag).</li>
            </ul>
        </div>

<<<<<<< HEAD
        <!-- 3. Manajemen Mahasiswa -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-users"></i></div>
            <h3>3. Manajemen Mahasiswa</h3>
=======
        <!-- Manajemen Mahasiswa -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-users"></i></div>
            <h3>2. Manajemen Mahasiswa</h3>
>>>>>>> 5aacb94924f591cbbd3502ad80e2e6f2445cc3a0
            <ul class="steps">
                <li><div class="step-num">1</div> Gunakan menu <b>Import Excel</b> untuk data massal.</li>
                <li><div class="step-num">2</div> Gunakan menu <b>Cari</b> untuk edit data satuan.</li>
                <li><div class="step-num">3</div> Sinkronisasi NIM data kolektif tiap angkatan.</li>
            </ul>
            <div class="important-box">
                <b>Aturan Excel:</b><br>
                Kolom harus urut: NPM | Nama | Prodi | Tahun | Skema. Ganti nama Sheet menjadi "Sheet1".
            </div>
        </div>

<<<<<<< HEAD
        <!-- 4. Pelaporan -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-flag"></i></div>
            <h3>4. Menangani Laporan</h3>
=======
        <!-- Pelaporan -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-flag"></i></div>
            <h3>3. Menangani Laporan</h3>
>>>>>>> 5aacb94924f591cbbd3502ad80e2e6f2445cc3a0
            <ul class="steps">
                <li><div class="step-num">1</div> Buka menu <b>Monitoring Laporan</b>.</li>
                <li><div class="step-num">2</div> Tinjau bukti lampiran aduan mahasiswa.</li>
                <li><div class="step-num">3</div> Klik <b>Proses</b> jika mulai ditangani.</li>
                <li><div class="step-num">4</div> Klik <b>Selesai</b> setelah solusi tercapai.</li>
            </ul>
        </div>

<<<<<<< HEAD
        <!-- 5. Evaluasi -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-check-double"></i></div>
            <h3>5. Evaluasi Kinerja</h3>
=======
        <!-- Evaluasi -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-check-double"></i></div>
            <h3>4. Evaluasi Kinerja</h3>
>>>>>>> 5aacb94924f591cbbd3502ad80e2e6f2445cc3a0
            <ul class="steps">
                <li><div class="step-num">1</div> Verifikasi berkas semesteran yang diunggah mahasiswa.</li>
                <li><div class="step-num">2</div> Beri status <b>Verified</b> jika data sesuai.</li>
                <li><div class="step-num">3</div> Cetak formulir fisik via tombol <b>Generate PDF</b>.</li>
            </ul>
        </div>
    </div>

<<<<<<< HEAD
        <!-- 6. Bantuan -->
        <div class="guide-card">
            <div class="pop-dot"></div>
            <div class="icon-box"><i class="fas fa-circle-question"></i></div>
            <h3>6. Bantuan</h3>
            <ul class="steps">
                <li><div class="step-num">1</div> Halaman ini adalah menu <b>Bantuan</b>.</li>
                <li><div class="step-num">2</div> Berisi panduan langkah demi langkah.</li>
                <li><div class="step-num">3</div> Hubungi admin jika ada kendala.</li>
            </ul>
        </div>
    </div>

=======
>>>>>>> 5aacb94924f591cbbd3502ad80e2e6f2445cc3a0
    <div style="text-align:center; margin-top:50px; color:#aaa; font-size:0.85rem;">
        <i class="fas fa-shield-alt"></i> Panel Administrator KIP-Kuliah Politeknik Negeri Lampung.
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.guide-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, { threshold: 0.1 });

        cards.forEach((card, i) => {
            card.style.transitionDelay = (i * 0.1) + 's';
            observer.observe(card);
        });
    });
</script>

</body>
</html>
