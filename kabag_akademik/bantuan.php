<?php
session_start();
include '../protect.php';
check_level(13);
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pusat Bantuan - Kabag Akademik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f2ff;
            margin: 0;
            color: #333;
        }

        .content {
            margin-left: 240px;
            padding: 40px;
            min-height: 100vh;
            transition: 0.3s ease;
        }

        .header-section {
            text-align: center;
            margin-bottom: 50px;
            padding-top: 20px;
        }

        .header-section h2 {
            color: #4e0a8a;
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            position: relative;
            display: inline-block;
        }
        .header-section h2::after {
            content: '';
            position: absolute;
            left: 50%; bottom: -12px;
            width: 80px; height: 5px;
            background: #7b35d4;
            border-radius: 5px;
            transform: translateX(-50%);
        }

        .guide-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .guide-card {
            background: white;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
            transition: 0.3s;
            border: 1px solid rgba(123, 53, 212, 0.05);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .guide-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(123, 53, 212, 0.1);
            border-color: #7b35d4;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #f0e6ff;
            color: #7b35d4;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: 0.3s;
        }

        .guide-card:hover .icon-box {
            background: #7b35d4;
            color: white;
            transform: rotate(10deg);
        }

        .guide-card h3 {
            margin: 0;
            font-size: 1.15rem;
            color: #4e0a8a;
            font-weight: 700;
        }

        .guide-card p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
        }

        .footer-note {
            text-align: center;
            margin-top: 60px;
            padding: 30px;
            border-top: 1px solid #eee;
            color: #999;
            font-size: 0.85rem;
        }

        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 85px 15px 40px 15px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Pusat Panduan Kabag</h2>
        <p style="color: #888; margin-top: 20px;">Panduan operasional sistem untuk peran Kabag Akademik (Admin 3)</p>
    </div>

    <div class="guide-grid">
        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-th-large"></i></div>
            <h3>Dashboard</h3>
            <p>Melihat ringkasan data, grafik validasi, dan waktu sistem secara real-time.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-newspaper"></i></div>
            <h3>Validasi Berita</h3>
            <p>Meninjau berita yang diajukan Pengurus. Berita butuh persetujuan Anda untuk tampil di halaman publik.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-file-invoice"></i></div>
            <h3>Validasi SK</h3>
            <p>Melakukan validasi terhadap Surat Keputusan. Tombol reject akan memunculkan popup catatan revisi.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-book"></i></div>
            <h3>Pusat Pedoman</h3>
            <p>Mengelola dokumen pedoman pendaftaran. Pastikan file PDF sudah sah sebelum disebarkan.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-id-card"></i></div>
            <h3>Batch KIP</h3>
            <p>Validasi data mahasiswa penerima KIP secara kolektif per skema dan tahun angkatan.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-award"></i></div>
            <h3>Validasi Prestasi</h3>
            <p>Kurasi data prestasi mahasiswa yang layak dipublikasikan sebagai apresiasi kampus.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-exclamation-triangle"></i></div>
            <h3>Monitoring Laporan</h3>
            <p>Melihat keluhan atau laporan kendala dari mahasiswa terkait sistem atau pencairan dana.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-clipboard-check"></i></div>
            <h3>Evaluasi Akademik</h3>
            <p>Verifikasi rutin nilai dan berkas semesteran mahasiswa KIP-K untuk menentukan keberlanjutan beasiswa.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-user-shield"></i></div>
            <h3>Kontrol User</h3>
            <p>Otoritas untuk menambah atau mengedit akun Admin 1 (Pengurus) dan Admin 2 di sistem.</p>
        </div>

        <div class="guide-card">
            <div class="icon-box"><i class="fas fa-envelope-open-text"></i></div>
            <h3>Saran & Pertanyaan</h3>
            <p>Menampung masukan pengguna dan menjawab pertanyaan publik secara efisien.</p>
        </div>
    </div>

    <div class="footer-note">
        <i class="fas fa-shield-alt"></i> Sistem Pengelolaan KIP-Kuliah Politeknik Negeri Lampung | 2024
    </div>
</div>

</body>
</html>
