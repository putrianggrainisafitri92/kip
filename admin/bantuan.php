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
    <title>Bantuan Admin - KIP Kuliah Polinela</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #6a11cb;
            --secondary-purple: #2575fc;
            --deep-purple: #4e0a8a;
            --glass-purple: rgba(78, 10, 138, 0.9);
            --accent-purple: #7b35d4;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;       
            background-attachment: fixed; 
            color: white;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 230px;
            padding: 40px 20px;
            transition: 0.3s ease;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: var(--glass-purple);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            animation: fadeInPage 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(50px); filter: blur(10px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        h2 {
            color: #fff;
            padding-bottom: 20px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-size: 2.5rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
            border-bottom: 2px dashed rgba(255,255,255,0.2);
        }

        .guide-section {
            margin-bottom: 40px;
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .guide-section.show {
            opacity: 1;
            transform: translateX(0);
        }

        .guide-section h3 {
            font-size: 1.5rem;
            color: #f1e4ff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.3s;
            font-weight: 700;
        }

        .icon-box {
            width: 55px;
            height: 55px;
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .guide-section:hover .icon-box {
            background: #fff;
            color: var(--deep-purple);
            transform: rotate(360deg) scale(1.1);
        }

        .guide-content {
            background: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1);
            line-height: 1.8;
            transition: 0.4s;
            position: relative;
            overflow: hidden;
        }

        .guide-content::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, #ba68ff, #7b35d4);
        }

        .guide-section:hover .guide-content {
            background: rgba(255,255,255,0.1);
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.2);
        }

        .guide-content p {
            margin-top: 0;
            font-weight: 500;
            color: #f8f2ff;
        }

        .guide-content ul {
            padding-left: 0;
            list-style: none;
            margin-bottom: 0;
        }

        .guide-content li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            font-size: 0.95rem;
        }

        .step-badge {
            background: linear-gradient(135deg, #ba68ff, #7b35d4);
            color: #fff;
            padding: 5px 14px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(123, 53, 212, 0.3);
            text-transform: uppercase;
        }

        .tip-box {
            background: rgba(37, 117, 252, 0.2);
            border: 1px solid rgba(37, 117, 252, 0.3);
            padding: 15px;
            border-radius: 12px;
            margin-top: 15px;
            font-size: 0.85rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        /* Float Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float-anim {
            animation: float 3s ease-in-out infinite;
            display: inline-block;
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse-anim:hover {
            animation: pulse 1.5s infinite;
        }

        /* Responsive Improvements */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
            .container {
                padding: 30px 20px;
                border-radius: 20px;
            }
            h2 { font-size: 1.8rem; }
        }

        @media (max-width: 600px) {
            h2 { 
                font-size: 1.4rem; 
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            .guide-section h3 { font-size: 1.2rem; }
            .guide-content { padding: 20px; }
            .step-badge { padding: 4px 10px; font-size: 0.7rem; }
        }

        .footer-info {
            margin-top: 60px;
            text-align: center;
            opacity: 0.7;
            font-style: italic;
            animation: fadeIn 2s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 0.7; }
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="main-content">
    <div class="container">
        <h2><i class="fas fa-user-shield float-anim"></i> Bantuan Admin Level 2</h2>

        <!-- SECTION 1: DASHBOARD -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-chart-line"></i></div> 1. Dashboard Statistik</h3>
            <div class="guide-content">
                <p>Pusat kendali admin untuk melihat ringkasan statistik terkini:</p>
                <ul>
                    <li><i class="fas fa-chart-pie" style="color:#ba68ff; margin-right:10px;"></i> <b>Visualisasi Data:</b> Pantau grafik laporan masuk per bulan dan statistik mahasiswa secara real-time.</li>
                    <li><i class="fas fa-clock" style="color:#ba68ff; margin-right:10px;"></i> <b>Quick Stats:</b> Lihat total laporan, berita, mahasiswa, dan pedoman dalam satu tampilan dashboard.</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 2: PENGELOLAAN SK -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-file-invoice"></i></div> 2. Pengelolaan Data SK</h3>
            <div class="guide-content">
                <p>Kelola dokumen Surat Keputusan (SK) penetapan penerima KIP-Kuliah:</p>
                <ul>
                    <li><span class="step-badge">Tambah SK</span> Unggah dokumen SK baru (PDF/Excel) dengan mengisi nama, tahun, dan nomor SK.</li>
                    <li><span class="step-badge">Validasi</span> Setiap SK yang diunggah akan berstatus <i>Pending</i> menunggu verifikasi dari Kabag Akademik.</li>
                    <li><span class="step-badge">Revisi</span> Jika ditolak, cek catatan revisi dan unggah kembali file yang sudah diperbaiki.</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 3: MANAJEMEN MAHASISWA -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-users"></i></div> 3. Manajemen Mahasiswa</h3>
            <div class="guide-content">
                <p>Kelola basis data mahasiswa penerima KIP-Kuliah secara efisien:</p>
                <ul>
                    <li><span class="step-badge">Import Excel</span> Masukkan data mahasiswa secara massal menggunakan file .xlsx.</li>
                    <li><span class="step-badge">Update Data</span> Lakukan sinkronisasi data NIM dan Program Studi secara kolektif.</li>
                    <li><span class="step-badge">Hapus Data</span> Hapus data secara selektif berdasarkan Tahun, Jurusan, atau Prodi pada menu Hapus Semua.</li>
                </ul>
                <div class="tip-box">
                    <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #ba68ff;"></i>
                    <div>
                        <b>Agar sistem dapat membaca data dengan benar, silakan atur urutan kolom Excel Anda sebagai berikut:</b><br><br>
                        • <b>Kolom A:</b> NPM<br>
                        • <b>Kolom B:</b> Nama Mahasiswa<br>
                        • <b>Kolom C:</b> Program Studi (Harus Sesuai List Polinela)<br>
                        • <b>Kolom D:</b> Tahun (Contoh: 2026)<br>
                        • <b>Kolom E:</b> Skema (Contoh: Skema 1)
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: MONITORING LAPORAN -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-flag"></i></div> 4. Monitoring Laporan</h3>
            <div class="guide-content">
                <p>Pantau aduan atau laporan yang masuk dari mahasiswa:</p>
                <ul>
                    <li><span class="step-badge">Review</span> Cek detail identitas pelapor, terlapor, dan alasan pelaporan beserta bukti lampiran.</li>
                    <li><span class="step-badge">Proses</span> Tandai laporan sebagai <b>Diproses</b> saat mulai ditangani oleh tim.</li>
                    <li><span class="step-badge">Selesai</span> Tutup laporan setelah mediasi atau tindakan administratif selesai dilakukan.</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 5: EVALUASI MAHASISWA -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-tasks"></i></div> 5. Evaluasi Kinerja</h3>
            <div class="guide-content">
                <p>Lakukan validasi kelayakan mahasiswa penerima bantuan:</p>
                <ul>
                    <li><span class="step-badge">Cek Dokumen</span> Verifikasi berkas evaluasi (PDF) yang diunggah oleh mahasiswa.</li>
                    <li><span class="step-badge">Verifikasi</span> Tandai sebagai <b>Verified</b> untuk mahasiswa yang tetap layak menerima KIP-K.</li>
                    <li><span class="step-badge">Generate PDF</span> Cetak formulir evaluasi resmi untuk keperluan administrasi fisik.</li>
                </ul>
            </div>
        </div>

        <div class="footer-info">
            <p><i class="fas fa-shield-alt"></i> Sistem Pengawasan Administratif KIP-Kuliah - Politeknik Negeri Lampung</p>
        </div>
    </div>
</div>

<script>
    // Reveal animations on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.guide-section');
        
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    });
</script>

</body>
</html>
