<?php
session_start();
// Check if user is logged in as admin level 2
if(!isset($_SESSION['level']) || $_SESSION['level'] != '12') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan Admin - KIP Kuliah Polinela</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 230px;
            padding: 0px 20px 50px 20px; /* Padding atas nol */
            transition: 0.3s;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            margin: 0 auto; /* No margin top */
            background: rgba(255, 255, 255, 0.96);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 80px rgba(0,0,0,0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.4);
            animation: slideInDown 1s cubic-bezier(0.22, 1, 0.36, 1) both;
            position: relative;
            top: 0;
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #4e0a8a;
            border-bottom: 3px solid #7b35d4;
            padding-bottom: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.8rem;
        }

        .guide-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .guide-section {
            margin-bottom: 0; /* Menggunakan gap pada grid */
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.5s ease-out;
        }

        .guide-section.show {
            opacity: 1;
            transform: scale(1);
        }

        .guide-section h3 {
            font-size: 1.2rem;
            color: #7b35d4;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .guide-content {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            border-left: 6px solid #7b35d4;
            line-height: 1.6;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            font-size: 0.95rem;
        }

        .guide-content ul {
            padding-left: 0;
            list-style: none;
            margin: 10px 0 0 0;
        }

        .guide-content li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .step-badge {
            background: linear-gradient(135deg, #7b35d4, #4e0a8a);
            color: #fff;
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            background: #f3e5f5;
            color: #7b35d4;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .guide-section:hover .icon-box {
            background: #7b35d4;
            color: #fff;
            transform: rotate(360deg) scale(1.1);
        }

        /* Float Animation */
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .float-anim {
            animation: float 4s ease-in-out infinite;
            display: inline-block;
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(123, 53, 212, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(123, 53, 212, 0); }
            100% { box-shadow: 0 0 0 0 rgba(123, 53, 212, 0); }
        }
        .pulse-btn {
            animation: pulse 2s infinite;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px 10px;
            }
            .container {
                padding: 25px;
                border-radius: 0;
            }
            h2 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="main-content">
    <div class="container">
        <h2><i class="fas fa-user-shield float-anim"></i> Panduan Operasional Admin Level 2</h2>

        <div class="guide-grid">
            <div class="guide-section">
                <h3><div class="icon-box"><i class="fas fa-chart-line"></i></div> 1. Dashboard Admin</h3>
                <div class="guide-content">
                    <p>Pusat kendali admin untuk melihat ringkasan statistik terkini:</p>
                    <ul>
                        <li><span class="step-badge">Visual</span> Grafik data mahasiswa per tahun atau per jurusan.</li>
                        <li><span class="step-badge">Status</span> Pantau jumlah laporan masuk dan evaluasi yang belum diproses secara cepat.</li>
                    </ul>
                </div>
            </div>

            <div class="guide-section">
                <h3><div class="icon-box"><i class="fas fa-file-invoice"></i></div> 2. Pengelolaan Data SK</h3>
                <div class="guide-content">
                    <p>Kelola dokumen Surat Keputusan (SK) penetapan penerima KIP-Kuliah:</p>
                    <ul>
                        <li><span class="step-badge">Input</span> Tambah data SK baru dengan mengunggah file PDF yang valid.</li>
                        <li><span class="step-badge">Edit</span> Perbarui informasi SK jika terdapat kesalahan data atau revisi dari pimpinan.</li>
                        <li><span class="step-badge">Hapus</span> Bersihkan data SK lama yang sudah tidak berlaku lagi.</li>
                    </ul>
                </div>
            </div>

            <div class="guide-section">
                <h3><div class="icon-box"><i class="fas fa-users"></i></div> 3. Manajemen Data Mahasiswa</h3>
                <div class="guide-content">
                    <p>Kelola basis data mahasiswa penerima KIP-Kuliah:</p>
                    <ul>
                        <li><span class="step-badge">Import</span> Masukkan data mahasiswa secara massal untuk efisiensi waktu.</li>
                        <li><span class="step-badge">Verifikasi</span> Pastikan data NIM dan Program Studi sesuai dengan data akademik resmi Polinela.</li>
                        <li><span class="step-badge">Update</span> Sinkronisasi status aktif atau tidaknya mahasiswa penerima bantuan.</li>
                    </ul>
                </div>
            </div>

            <div class="guide-section">
                <h3><div class="icon-box"><i class="fas fa-file-alt"></i></div> 4. Monitoring Laporan Mahasiswa</h3>
                <div class="guide-content">
                    <p>Pantau laporan yang dikirimkan oleh mahasiswa melalui sistem:</p>
                    <ul>
                        <li><span class="step-badge">Review</span> Baca detail laporan/aduan yang masuk dari mahasiswa.</li>
                        <li><span class="step-badge">Tindak Lanjut</span> Teruskan laporan ke bagian terkait jika diperlukan koordinasi lebih lanjut.</li>
                    </ul>
                </div>
            </div>

            <div class="guide-section">
                <h3><div class="icon-box"><i class="fas fa-tasks"></i></div> 5. Evaluasi Kinerja Mahasiswa</h3>
                <div class="guide-content">
                    <p>Lakukan evaluasi rutin terhadap kelayakan penerima KIP-Kuliah:</p>
                    <ul>
                        <li><span class="step-badge">Nilai</span> Pantau IPK mahasiswa setiap semester sebagai syarat kelanjutan bantuan.</li>
                        <li><span class="step-badge">Dokumen</span> Cek kelengkapan file evaluasi yang diunggah oleh mahasiswa (KHS, Bukti Prestasi, dll).</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="guide-section text-center" style="margin-top: 60px;">
            <p style="opacity: 0.7; font-size: 1rem;">
                <a href="index.php" class="step-badge pulse-btn" style="text-decoration: none; padding: 12px 30px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </p>
            <p style="margin-top: 30px; opacity: 0.5; font-style: italic; font-size: 0.9rem;">
                <i class="fas fa-shield-alt"></i> Sistem Informasi KIP-Kuliah Polinela - Keamanan Terjamin
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.guide-section');
        
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Delay staggered entrance
                    setTimeout(() => {
                        entry.target.classList.add('show');
                    }, index * 100);
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
