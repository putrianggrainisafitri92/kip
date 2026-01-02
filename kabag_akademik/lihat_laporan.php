<?php
session_start();
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

// Ambil laporan berdasarkan status
$riwayat = $koneksi->query("SELECT * FROM laporan ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lihat Pelaporan - Kabag Akademik</title>
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
            margin-bottom: 30px;
        }

        .header-section h2 {
            color: #4e0a8a;
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            position: relative;
            display: inline-block;
        }
        .header-section h2::after {
            content: '';
            position: absolute;
            left: 0; bottom: -5px;
            width: 50px; height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        .table-container {
            background: white;
            padding: 15px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow-x: auto;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th {
            background: #4e0a8a;
            color: white;
            padding: 18px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }

        th:first-child { border-radius: 12px 0 0 12px; }
        th:last-child { border-radius: 0 12px 12px 0; }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fbf9ff; }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
        }
        .selesai { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .proses { background: #fff8e1; color: #ffa000; border: 1px solid #ffe082; }

        .btn-view {
            padding: 8px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f3e8ff;
            color: #7b35d4;
        }
        .btn-view:hover {
            background: #7b35d4;
            color: white;
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 85px 15px 40px 15px; }
            .header-section h2 { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Lihat Pelaporan</h2>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:50px; text-align:center;">ID</th>
                    <th>Pelapor</th>
                    <th>Terlapor</th>
                    <th>Jurusan / Prodi</th>
                    <th>Alasan Singkat</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($d = $riwayat->fetch_assoc()): 
                    $status = strtolower($d['status_tindak'] ?? 'proses');
                    $status_label = ($status == 'selesai') ? 'Selesai' : 'Dalam Proses';
                ?>
                <tr>
                    <td style="text-align:center; font-weight: 700; color: #7b35d4;"><?= $d['id_laporan'] ?></td>
                    <td>
                        <div style="font-weight: 600; color: #4e0a8a;"><?= htmlspecialchars($d['nama_pelapor']) ?></div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #333;"><?= htmlspecialchars($d['nama_terlapor']) ?></div>
                        <div style="font-size: 0.8rem; color: #999;"><?= htmlspecialchars($d['npm_terlapor']) ?></div>
                    </td>
                    <td>
                        <div style="font-size:0.85rem; color:#666;">
                            <?= htmlspecialchars($d['jurusan']) ?><br>
                            <span style="opacity:0.7; font-size: 0.8rem;"><?= htmlspecialchars($d['prodi']) ?></span>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.85rem; color:#555; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= htmlspecialchars($d['alasan']) ?>
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <span class="badge <?= ($status == 'selesai') ? 'selesai' : 'proses' ?>">
                            <?= $status_label ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <a href="detail_laporan.php?id=<?= $d['id_laporan'] ?>" class="btn-view">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
