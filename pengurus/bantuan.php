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
    <title>Bantuan Pengurus - KIP Kuliah Polinela</title>
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
            align-items: center;
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
        <h2><i class="fas fa-question-circle float-anim"></i> Bantuan Pengurus</h2>

        <!-- SECTION 1: DASHBOARD -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-gauge"></i></div> 1. Dashboard Statistik</h3>
            <div class="guide-content">
                <p>Pantau semua aktivitas Anda dalam satu tampilan ringkas:</p>
                <ul>
                    <li><i class="fas fa-chart-pie" style="color:#ba68ff"></i> <b>Visualisasi Data:</b> Lihat perbandingan status berita dan pedoman (Pending, Approved, Revisit) melalui grafik interaktif.</li>
                    <li><i class="fas fa-sync" style="color:#ba68ff"></i> <b>Statistik Real-time:</b> Data diperbarui secara otomatis ketika ada perubahan status dari Kabag Akademik.</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 2: UPLOAD BERITA -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-newspaper"></i></div> 2. Pengelolaan Berita</h3>
            <div class="guide-content">
                <p>Langkah-langkah untuk mempublikasikan kegiatan KIP-Kuliah:</p>
                <ul>
                    <li><span class="step-badge">Langkah 1</span> Klik menu <b>Kelola Berita</b> dan pilih tombol <b>+ Tambah Berita</b>.</li>
                    <li><span class="step-badge">Langkah 2</span> Masukkan <b>Judul</b> dan tentukan <b>Tanggal Kegiatan</b> yang sesuai.</li>
                    <li><span class="step-badge">Langkah 3</span> Tambahkan <b>Gambar</b> utama dan deskripsi gambar (caption).</li>
                    <li><span class="step-badge">Langkah 4</span> Gunakan tombol <b>+ Tambah Slot Gambar</b> jika Anda ingin mengupload banyak foto sekaligus.</li>
                    <li><span class="step-badge">Langkah 5</span> Klik <b>Simpan Berita</b>. Status akan menjadi <i>Pending</i> menunggu validasi.</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 3: UPLOAD PEDOMAN -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-book"></i></div> 3. Pengelolaan Pedoman</h3>
            <div class="guide-content">
                <p>Bagaimana cara mengunggah dokumen aturan/pedoman baru:</p>
                <ul>
                    <li><span class="step-badge">Langkah 1</span> Pilih file dengan format <b>PDF</b> (Maksimal ukuran: 10 MB).</li>
                    <li><span class="step-badge">Langkah 2</span> Berikan nama file yang informatif agar mudah dicari oleh mahasiswa.</li>
                    <li><span class="step-badge">Langkah 3</span> Setelah diupload, Anda dapat memantau apakah pedoman disetujui atau memerlukan revisi di tabel daftar pedoman.</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 4: UPLOAD PRESTASI (FIXED) -->
        <div class="guide-section">
            <h3><div class="icon-box pulse-anim"><i class="fas fa-trophy"></i></div> 4. Mahasiswa Berprestasi</h3>
            <div class="guide-content">
                <p>Berikan apresiasi terbaik bagi mahasiswa penerima KIP-Kuliah:</p>
                <ul>
                    <li><span class="step-badge">Langkah 1</span> Isi data identitas (<b>Nama</b>, <b>NIM/NPM</b>, dan <b>Jurusan</b> mahasiswa).</li>
                    <li><span class="step-badge">Langkah 2</span> Berikan <b>Judul Prestasi</b> yang menarik (Contoh: Juara 1 Olimpiade Nasional).</li>
                    <li><span class="step-badge">Langkah 3</span> Pilih <b>Tanggal Perolehan</b> prestasi tersebut.</li>
                    <li><span class="step-badge">Langkah 4</span> Tuliskan <b>Deskripsi</b> cerita singkat yang inspiratif tentang perjalanan prestasi mereka.</li>
                    <li><span class="step-badge">Langkah 5</span> Unggah foto/piagam kualitas tinggi (Resolusi baik).</li>
                </ul>
                <div class="tip-box">
                    <i class="fas fa-lightbulb"></i>
                    <div>
                        <b>Tips Upload Multi-Foto:</b><br>
                        • <b>Laptop:</b> Tahan tombol <code>Ctrl</code> atau <code>Shift</code> sambil klik file-file foto.<br>
                        • <b>Smartphone:</b> Tekan lama pada salah satu foto di galeri, lalu centang foto lainnya yang ingin diupload.
                    </div>
                </div>
                <div style="margin-top:15px; font-size: 0.9rem; color: #f1e4ff;">
                    <i class="fas fa-check-circle"></i> Setelah dikirim, data akan masuk ke dashboard pengecekan Kabag Akademik sebelum ditampilkan ke publik.
                </div>
            </div>
        </div>

        <div class="footer-info">
            <p><i class="fas fa-info-circle"></i> Panel dikembangkan untuk mempermudah alur kerja administratif KIP-Kuliah Polinela. Butuh bantuan teknis? Hubungi Admin IT.</p>
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
