<?php
include "../protect.php";
check_level(12);
include "../koneksi.php";
include "sidebar.php";

// Ambil laporan berdasarkan status
$aktif   = $koneksi->query("SELECT * FROM laporan WHERE status_tindak!='selesai' OR status_tindak IS NULL ORDER BY created_at DESC");
$riwayat = $koneksi->query("SELECT * FROM laporan WHERE status_tindak='selesai' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Laporan Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f2ff;
            margin: 0;
            color: #333;
        }

        .content {
            margin-left: 230px;
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
        }
        .header-section h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 50px;
            height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #4e0a8a;
            margin: 40px 0 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ===== Table ===== */
        .table-responsive {
            background: white;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow-x: auto;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .search-box {
            margin-bottom: 20px;
            position: relative;
            animation: fadeInUp 0.6s ease-out;
        }
        .search-input {
            width: 100%;
            padding: 15px 45px 15px 20px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            box-sizing: border-box;
        }
        .search-input:focus {
            border-color: #7b35d4;
            box-shadow: 0 8px 20px rgba(123, 53, 212, 0.1);
            outline: none;
        }
        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
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

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
            vertical-align: middle;
        }

        tr:hover td { background: #fbf9ff; }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
        }
        .pending { background: #fff8e1; color: #ffa000; }
        .diproses { background: #e3f2fd; color: #1976d2; }
        .selesai { background: #e8f5e9; color: #2e7d32; }

        .btn-detail {
            background: #f3e8ff;
            color: #7b35d4;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-detail:hover { background: #7b35d4; color: white; }

        /* Responsive */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
            .header-section h2 { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Data Laporan Mahasiswa</h2>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <input type="text" id="searchInput" class="search-input" placeholder="Cari laporan (Pelapor, Terlapor, Alasan)...">
        <i class="fas fa-search search-icon"></i>
    </div>

    <!-- Tampilkan Daftar Laporan Aktif -->
    <div class="section-title">
        <i class="fas fa-exclamation-circle"></i> Laporan Aktif (Perlu Tindak Lanjut)
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Pelapor</th>
                    <th>Terlapor</th>
                    <th>Jurusan / Prodi</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($d = $aktif->fetch_assoc()): ?>
                <tr>
                    <td><?= $d['id_laporan'] ?></td>
                    <td><div style="font-weight: 600; color: #4e0a8a;"><?= htmlspecialchars($d['nama_pelapor']) ?></div></td>
                    <td>
                        <div style="font-weight: 600;"><?= htmlspecialchars($d['nama_terlapor']) ?></div>
                        <small class="text-muted"><?= $d['npm_terlapor'] ?></small>
                    </td>
                    <td><small><?= htmlspecialchars($d['jurusan']) ?></small><br><small class="text-muted"><?= htmlspecialchars($d['prodi']) ?></small></td>
                    <td><div style="max-width: 200px; font-size: 13px; line-height: 1.4;"><?= htmlspecialchars($d['alasan']) ?></div></td>
                    <td>
                        <?php 
                        $status = strtolower(trim($d['status_tindak']));
                        if ($status === "" || $status === "pending") {
                            echo "<span class='status-badge pending'>PENDING</span>";
                        } else {
                            echo "<span class='status-badge diproses'>DIPROSES</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="laporan_tindak.php?id=<?= $d['id_laporan'] ?>" class="btn-detail">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($aktif->num_rows == 0): ?>
                    <tr><td colspan="7" style="text-align:center; padding: 30px; color: #999;">Tidak ada laporan aktif.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Tampilkan Riwayat Laporan Selesai -->
    <div class="section-title">
        <i class="fas fa-history"></i> Riwayat Laporan (Selesai)
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Pelapor</th>
                    <th>Terlapor</th>
                    <th>Jurusan / Prodi</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($d = $riwayat->fetch_assoc()): ?>
                <tr>
                    <td><?= $d['id_laporan'] ?></td>
                    <td><div style="font-weight: 600;"><?= htmlspecialchars($d['nama_pelapor']) ?></div></td>
                    <td>
                        <div style="font-weight: 600;"><?= htmlspecialchars($d['nama_terlapor']) ?></div>
                        <small class="text-muted"><?= $d['npm_terlapor'] ?></small>
                    </td>
                    <td><small><?= htmlspecialchars($d['jurusan']) ?></small><br><small class="text-muted"><?= htmlspecialchars($d['prodi']) ?></small></td>
                    <td><div style="max-width: 200px; font-size: 13px;"><?= htmlspecialchars($d['alasan']) ?></div></td>
                    <td>
                        <span class='status-badge selesai'>SELESAI</span>
                    </td>
                    <td>
                        <a href="laporan_tindak.php?id=<?= $d['id_laporan'] ?>" class="btn-detail">
                            <i class="fas fa-search"></i> Lihat
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($riwayat->num_rows == 0): ?>
                    <tr><td colspan="7" style="text-align:center; padding: 30px; color: #999;">Belum ada riwayat laporan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr'); // Target all tables

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

</body>
</html>
