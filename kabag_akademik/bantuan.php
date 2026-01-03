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

        .c1 { width: 400px; height: 400px; top: -100px; right: -100px; animation-delay: 0s; }
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
            font-size: 42px;
            font-weight: 800;
            margin: 0;
            display: inline-block;
            position: relative;
        }

        .header-section h2 span {
            color: var(--accent-purple);
            display: block;
            font-size: 18px;
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
            perspective: 1000px;
        }

        .guide-card {
            background: var(--glass-white);
            backdrop-filter: blur(10px);
            padding: 40px 30px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid rgba(123, 53, 212, 0.1);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            transform: translateY(30px);
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }

        .guide-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(123, 53, 212, 0.05) 0%, transparent 100%);
            z-index: 0;
        }

        .guide-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .guide-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(123, 53, 212, 0.15);
            border-color: var(--accent-purple);
            background: white;
        }

        /* Card Content Inner */
        .card-inner {
            position: relative;
            z-index: 1;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: #f0e6ff;
            color: var(--accent-purple);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 25px;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 5px 15px rgba(123, 53, 212, 0.1);
        }

        .guide-card:hover .icon-box {
            background: var(--accent-purple);
            color: white;
            transform: rotateY(360deg) scale(1.1);
            box-shadow: 0 10px 25px rgba(123, 53, 212, 0.3);
        }

        .guide-card h3 {
            margin: 0 0 15px 0;
            font-size: 1.3rem;
            color: var(--primary-purple);
            font-weight: 800;
        }

        .guide-card p {
            margin: 0;
            font-size: 0.95rem;
            color: #666;
            line-height: 1.6;
        }

        /* ===== FOOTER NOTE ===== */
        .footer-note {
            text-align: center;
            margin-top: 80px;
            padding: 40px;
            border-top: 1px solid rgba(0,0,0,0.05);
            color: #999;
            font-size: 0.9rem;
            animation: fadeIn 2s;
        }

        .footer-note i {
            color: var(--accent-purple);
            margin-right: 8px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ===== TOOLTIP / POP ANIMATION ===== */
        .pop-dot {
            position: absolute;
            width: 10px; height: 10px;
            background: var(--accent-purple);
            border-radius: 50%;
            top: 20px; right: 20px;
            opacity: 0.3;
        }

        .guide-card:hover .pop-dot {
            animation: ping 1s infinite;
        }

        @keyframes ping {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(3); opacity: 0; }
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 100px 20px 40px 20px; }
            .header-section h2 { font-size: 32px; }
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

<div class="content">
    <div class="header-section">
        <h2>Pusat Panduan Kabag <span>Operasional Sistem Admin 3</span></h2>
        <div class="line"></div>
    </div>

    <div class="guide-grid" id="guideGrid">
        <?php
        $guides = [
            ["icon" => "fas fa-th-large", "title" => "Dashboard", "desc" => "Melihat ringkasan data, grafik validasi, dan waktu sistem secara real-time."],
            ["icon" => "fas fa-newspaper", "title" => "Validasi Berita", "desc" => "Meninjau berita yang diajukan Pengurus. Berita butuh persetujuan Anda untuk tampil di halaman publik."],
            ["icon" => "fas fa-file-invoice", "title" => "Validasi SK", "desc" => "Melakukan validasi terhadap Surat Keputusan. Tombol reject akan memunculkan popup catatan revisi."],
            ["icon" => "fas fa-book", "title" => "Pusat Pedoman", "desc" => "Mengelola dokumen pedoman pendaftaran. Pastikan file PDF sudah sah sebelum disebarkan."],
            ["icon" => "fas fa-id-card", "title" => "Batch KIP", "desc" => "Validasi data mahasiswa penerima KIP secara kolektif per skema dan tahun angkatan."],
            ["icon" => "fas fa-award", "title" => "Validasi Prestasi", "desc" => "Kurasi data prestasi mahasiswa yang layak dipublikasikan sebagai apresiasi kampus."],
            ["icon" => "fas fa-exclamation-triangle", "title" => "Monitoring Laporan", "desc" => "Melihat keluhan atau laporan kendala dari mahasiswa terkait sistem atau pencairan dana."],
            ["icon" => "fas fa-clipboard-check", "title" => "Evaluasi Akademik", "desc" => "Verifikasi rutin nilai dan berkas semesteran mahasiswa KIP-K untuk menentukan keberlanjutan beasiswa."],
            ["icon" => "fas fa-user-shield", "title" => "Kontrol User", "desc" => "Otoritas untuk menambah atau mengedit akun Admin 1 (Pengurus) dan Admin 2 di sistem."],
            ["icon" => "fas fa-envelope-open-text", "title" => "Saran & Pertanyaan", "desc" => "Menampung masukan pengguna dan menjawab pertanyaan publik secara efisien."]
        ];

        foreach ($guides as $index => $g) {
            $delay = $index * 0.1;
            echo "
            <div class='guide-card' style='transition-delay: {$delay}s'>
                <div class='pop-dot'></div>
                <div class='card-inner'>
                    <div class='icon-box'><i class='{$g['icon']}'></i></div>
                    <h3>{$g['title']}</h3>
                    <p>{$g['desc']}</p>
                </div>
            </div>";
        }
        ?>
    </div>

    <div class="footer-note">
        <i class="fas fa-shield-alt"></i> Sistem Pengelolaan KIP-Kuliah Politeknik Negeri Lampung | 2024
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.guide-card');
        
        // Staggered appearance
        setTimeout(() => {
            cards.forEach(card => card.classList.add('show'));
        }, 100);

        // Optional: Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => observer.observe(card));
    });
</script>

</body>
</html>
