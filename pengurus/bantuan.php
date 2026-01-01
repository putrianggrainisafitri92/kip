<?php
session_start();

// Cek login pengurus level 11
if (!isset($_SESSION['level']) || (int)$_SESSION['level'] !== 11) {
    header("Location: ../index.php?error=akses");
    exit;
}

include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan Pengurus - KIP Kuliah Polinela</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;       
            background-attachment: fixed; 
            color: #333;
            overflow-x: hidden;
        }


        .main-content {
            margin-left: 230px;
            padding: 40px 20px;
            transition: 0.3s;
            min-height: 100vh;
        }

        .container {
            max-width: 1100px; /* Diperlebar kesamping */
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            animation: fadeInPage 0.8s ease-out;
        }

        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #4e0a8a;
            border-bottom: 3px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 2rem;
            animation: slideInDown 0.7s ease-out;
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .guide-section {
            margin-bottom: 40px;
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.6s ease-out;
        }

        .guide-section.show {
            opacity: 1;
            transform: translateX(0);
        }

        .guide-section h3 {
            font-size: 1.4rem;
            color: #7b35d4;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
        }

        .guide-section:hover h3 {
            transform: scale(1.02);
            color: #4e0a8a;
        }

        .guide-content {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            border-left: 6px solid #7b35d4;
            line-height: 1.8;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            transition: 0.4s;
            border-top: 1px solid #f0f0f0;
            border-right: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
        }

        .guide-section:hover .guide-content {
            box-shadow: 0 8px 30px rgba(123, 53, 212, 0.15);
            transform: translateY(-5px);
            border-left-color: #4e0a8a;
        }

        .guide-content ul {
            padding-left: 20px;
            list-style: none;
        }

        .guide-content li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .step-badge {
            background: linear-gradient(135deg, #7b35d4, #4e0a8a);
            color: #fff;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: bold;
            flex-shrink: 0;
            box-shadow: 0 3px 6px rgba(123, 53, 212, 0.3);
        }

        .icon-box {
            width: 45px;
            height: 45px;
            background: #f3e5f5;
            color: #7b35d4;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: 0.5s;
        }

        .guide-section:hover .icon-box {
            background: #7b35d4;
            color: #fff;
            transform: rotate(360deg);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .container {
                padding: 25px;
                border-radius: 0;
            }
            h2 { font-size: 1.5rem; }
        }

        /* Float Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float-anim {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="main-content">
    <div class="container">
        <h2><i class="fas fa-question-circle float-anim"></i> Panduan Penggunaan Panel Pengurus</h2>

        <div class="guide-section">
            <h3><div class="icon-box"><i class="fas fa-gauge"></i></div> 1. Dashboard</h3>
            <div class="guide-content">
                Halaman utama yang menampilkan ringkasan data berupa grafik status berita dan pedoman yang telah diunggah. Pantau statistik publikasi Anda secara real-time di sini.
            </div>
        </div>

        <div class="guide-section">
            <h3><div class="icon-box"><i class="fas fa-newspaper"></i></div> 2. Upload Berita</h3>
            <div class="guide-content">
                <p>Gunakan menu ini untuk menambahkan berita atau kegiatan seputar KIP-Kuliah:</p>
                <ul>
                    <li><span class="step-badge">Langkah 1</span> Klik menu <b>Upload Berita</b> pada sidebar.</li>
                    <li><span class="step-badge">Langkah 2</span> Lengkapi formulir mulai dari judul hingga isi konten berita.</li>
                    <li><span class="step-badge">Langkah 3</span> Pilih file gambar yang menarik (format JPG/PNG).</li>
                    <li><span class="step-badge">Langkah 4</span> Tekan <b>Simpan</b>. Berita akan masuk ke antrean validasi Kabag Akademik.</li>
                </ul>
            </div>
        </div>

        <div class="guide-section">
            <h3><div class="icon-box"><i class="fas fa-book"></i></div> 3. Upload Pedoman</h3>
            <div class="guide-content">
                <p>Menu ini digunakan untuk mengunggah dokumen pedoman atau aturan terbaru:</p>
                <ul>
                    <li><span class="step-badge">Langkah 1</span> Berikan judul yang jelas pada dokumen pedoman.</li>
                    <li><span class="step-badge">Langkah 2</span> Pastikan file dokumen dalam format <b>PDF</b> agar mudah dibaca.</li>
                    <li><span class="step-badge">Langkah 3</span> Klik tombol <b>Upload</b>. Dokumen akan muncul di publik setelah disetujui.</li>
                </ul>
            </div>
        </div>

        <div class="guide-section">
            <h3><div class="icon-box"><i class="fas fa-user-graduate"></i></div> 4. Upload Mahasiswa Berprestasi</h3>
            <div class="guide-content">
                <p>Untuk mengapresiasi mahasiswa penerima KIP-Kuliah yang memiliki prestasi membanggakan:</p>
                <ul>
                    <li><span class="step-badge">Langkah 1</span> Masukkan identitas lengkap mahasiswa (Nama, NIM, Jurusan).</li>
                    <li><span class="step-badge">Langkah 2</span> Tulis deskripsi prestasi dengan detail dan menginspirasi.</li>
                    <li><span class="step-badge">Langkah 3</span> Unggah foto mahasiswa dengan resolusi yang baik.</li>
                    <li><span class="step-badge">Langkah 4</span> Kirim data. Prestasi akan dipajang di halaman utama website.</li>
                </ul>
            </div>
        </div>

        <div class="guide-section text-center" style="margin-top: 60px;">
            <p style="opacity: 0.6; font-style: italic;">
                <i class="fas fa-info-circle"></i> Butuh bantuan lebih lanjut? Silakan hubungi pusat bantuan Admin IT.
            </p>
        </div>
    </div>
</div>

<script>
    // Reveal animations on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.guide-section');
        
        const observerOptions = {
            threshold: 0.1
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

