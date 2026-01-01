<?php
session_start();
// Check if user is logged in as Kabag Akademik (assuming level 13 or similar, adjust based on system)
// Based on sidebar, it doesn't show explicit level check but follows the pattern.
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan Kabag Akademik - KIP Kuliah Polinela</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #e5d3e8ff 0%, #ffffffff 100%);
            color: #2d3436;
            overflow-x: hidden;
            background-attachment: fixed;
        }

        .main-content {
            margin-left: 230px;
            padding: 50px 30px;
            transition: 0.4s;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 50px;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.4);
            animation: moveIn 1s cubic-bezier(0.23, 1, 0.32, 1) both;
        }

        @keyframes moveIn {
            from { opacity: 0; transform: translateY(100px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        h2 {
            color: #4834d4;
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            background: linear-gradient(90deg, #4834d4, #686de0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            padding-bottom: 20px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            width: 100px; height: 5px;
            background: #4834d4;
            transform: translateX(-50%);
            border-radius: 5px;
            animation: expandWidth 1.5s ease-out infinite alternate;
        }

        @keyframes expandWidth {
            from { width: 50px; }
            to { width: 150px; }
        }

        .guide-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .guide-item {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: 0.5s;
            border: 1px solid transparent;
            opacity: 0;
            transform: translateY(30px);
        }

        .guide-item.show {
            opacity: 1;
            transform: translateY(0);
        }

        .guide-item:hover {
            transform: translateY(-15px) rotateX(5deg);
            box-shadow: 0 25px 50px rgba(72, 52, 212, 0.2);
            border-color: #686de0;
        }

        .guide-item i.main-icon {
            font-size: 3rem;
            color: #4834d4;
            margin-bottom: 20px;
            display: block;
            transition: 0.5s;
        }

        .guide-item:hover i.main-icon {
            transform: scale(1.2) rotate(15deg);
            color: #686de0;
        }

        .guide-item h3 {
            font-size: 1.4rem;
            color: #130f40;
            margin-bottom: 15px;
        }

        .guide-item p {
            line-height: 1.7;
            color: #535c68;
            font-size: 1rem;
        }

        .btn-action {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background: #4834d4;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-action:hover {
            background: #686de0;
            padding-right: 30px;
        }

        /* Loading Dots Animation */
        .loading-dots:after {
            content: '.';
            animation: dots 1.5s steps(5, end) infinite;
        }
        @keyframes dots {
            0%, 20% { color: rgba(0,0,0,0); text-shadow: .5em 0 0 rgba(0,0,0,0), 1em 0 0 rgba(0,0,0,0); }
            40% { color: #4834d4; text-shadow: .5em 0 0 rgba(0,0,0,0), 1em 0 0 rgba(0,0,0,0); }
            60% { text-shadow: .5em 0 0 #4834d4, 1em 0 0 rgba(0,0,0,0); }
            80%, 100% { text-shadow: .5em 0 0 #4834d4, 1em 0 0 #4834d4; }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            .container {
                padding: 30px 15px;
            }
            .guide-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="main-content">
    <div class="container">
        <h2><i class="fas fa-crown"></i> Hub Bantuan Kabag Akademik</h2>
        <p style="text-align: center; margin-bottom: 40px; color: #7f8c8d;">
            Panduan lengkap pengelolaan otoritas tertinggi akademik KIP-Kuliah Polinela.
        </p>

        <div class="guide-grid">
            <div class="guide-item">
                <i class="fas fa-gauge main-icon"></i>
                <h3>1. Dashboard</h3>
                <p>Memantau ringkasan statistik seluruh data KIP-Kuliah, mulai dari jumlah mahasiswa hingga grafik publikasi yang perlu divalidasi.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-newspaper main-icon"></i>
                <h3>2. Validasi Berita</h3>
                <p>Meninjau berita yang dikirim pengurus. Anda bisa menyetujui agar tampil di web utama atau menolak dengan catatan revisi.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-file-signature main-icon"></i>
                <h3>3. Validasi SK</h3>
                <p>Memeriksa keabsahan file SK penetapan yang diunggah admin. SK hanya akan tampil bagi mahasiswa setelah divalidasi oleh Anda.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-book main-icon"></i>
                <h3>4. Validasi Pedoman</h3>
                <p>Otorisasi dokumen pedoman pendaftaran atau aturan baru. Pastikan file PDF sudah benar sebelum dipublish.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-coins main-icon"></i>
                <h3>5. Validasi Kuota KIP</h3>
                <p>Mengatur dan mengonfirmasi jumlah kuota penerimaan KIP-Kuliah setiap angkatan agar data anggaran akurat.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-user-graduate main-icon"></i>
                <h3>6. Validasi Prestasi</h3>
                <p>Memilih dan menyetujui profil mahasiswa berprestasi yang berhak dipajang di galeri prestasi website utama.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-chart-line main-icon"></i>
                <h3>7. Lihat Pelaporan</h3>
                <p>Memonitor laporan masuk dari mahasiswa terkait kendala teknis atau administrasi pencairan dana KIP.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-clipboard-check main-icon"></i>
                <h3>8. Lihat Evaluasi</h3>
                <p>Meninjau hasil evaluasi semester mahasiswa (IPK dan berkas) untuk menentukan kelayakan kelanjutan bantuan.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-users-cog main-icon"></i>
                <h3>9. CRUD User</h3>
                <p>Manajemen akun sistem. Anda berhak menambah, mengedit, atau menghapus akun Admin dan Pengurus jika diperlukan.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-lightbulb main-icon"></i>
                <h3>10. Saran Pengguna</h3>
                <p>Membaca masukan dan ide dari pengguna umum untuk pengembangan fasilitas dan sistem KIP-Kuliah ke depannya.</p>
            </div>

            <div class="guide-item">
                <i class="fas fa-question-circle main-icon"></i>
                <h3>11. Pertanyaan User</h3>
                <p>Merespon pertanyaan publik melalui email luar. <b>Prosedur:</b> Copy email pengguna dan isi pertanyaan, lalu buka email Anda, paste detail tersebut, dan kirimkan jawaban secara resmi melalui email.</p>
                <a href="pertanyaan.php" class="btn-action">Cek Pertanyaan <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div style="margin-top: 50px; text-align: center;">
            <div class="loading-dots" style="font-size: 1.2rem; color: #4834d4; font-weight: bold; margin-bottom: 20px;">
                Sinkronisasi Sistem <span class="loading-dots"></span>
            </div>
            <p style="font-size: 0.9rem; color: #95a5a6;">
                Dibuat dengan dedikasi untuk efisiensi akademik Politeknik Negeri Lampung.
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.guide-item');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('show');
                    }, index * 150);
                }
            });
        }, { threshold: 0.1 });

        items.forEach(item => observer.observe(item));
    });
</script>

</body>
</html>
