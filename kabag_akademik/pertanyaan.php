<?php
session_start();
include '../protect.php';
check_level(13);
include "../koneksi.php";
include "sidebar.php";

// Update status jika admin klik SELESAI
if (isset($_GET['done'])) {
    $id = intval($_GET['done']);
    mysqli_query($koneksi, "UPDATE pertanyaan SET status_balasan='sudah' WHERE id_pertanyaan='$id'");
    echo "<script>alert('Pertanyaan ditandai sudah dibalas'); window.location='pertanyaan.php';</script>";
    exit;
}

$q = mysqli_query($koneksi, "SELECT * FROM pertanyaan ORDER BY id_pertanyaan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pertanyaan Pengguna - Kabag Akademik</title>
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
        .badge-sudah { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .badge-belum { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

        .pertanyaan-box {
            max-width: 350px;
            font-size: 0.85rem;
            color: #555;
            line-height: 1.5;
            background: #f8f2ff;
            padding: 12px 15px;
            border-radius: 12px;
            border-left: 4px solid #7b35d4;
        }

        .action-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-copy {
            background: #f3e8ff;
            color: #7b35d4;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            border: 1px solid #e1d0ff;
            transition: 0.3s;
        }
        .btn-copy:hover {
            background: #7b35d4;
            color: white;
        }

        .btn-done {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 8px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            transition: 0.3s;
        }
        .btn-done:hover {
            background: #2e7d32;
            color: white;
            box-shadow: 0 4px 10px rgba(46, 125, 50, 0.2);
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
        <h2>Kumpulan Pertanyaan</h2>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">ID</th>
                    <th style="width: 200px;">Pengirim</th>
                    <th>Pesan Pertanyaan</th>
                    <th style="text-align:center;">Status Balas</th>
                    <th style="text-align:center;">Aksi Pengelola</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($q)) { 
                    $isBelum = ($row['status_balasan'] == "belum");
                ?>
                <tr>
                    <td style="text-align:center; font-weight: 700; color: #999;"><?= $row['id_pertanyaan'] ?></td>
                    <td>
                        <div style="font-weight: 700; color: #4e0a8a;"><?= htmlspecialchars($row['nama']) ?></div>
                        <div style="font-size: 0.8rem; color: #999;"><?= htmlspecialchars($row['email']) ?></div>
                    </td>
                    <td>
                        <div class="pertanyaan-box">
                            <?= nl2br(htmlspecialchars($row['pesan'])) ?>
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <span class="badge <?= $isBelum ? 'badge-belum' : 'badge-sudah' ?>">
                            <?= $isBelum ? 'BELUM' : 'SELESAI' ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <div class="action-group">
                            <a href="javascript:void(0)" class="btn-copy" onclick="copyText('<?= addslashes($row['email']) ?>')">
                                <i class="fas fa-at"></i> Copy Email
                            </a>
                            <a href="javascript:void(0)" class="btn-copy" onclick="copyText('<?= addslashes($row['pesan']) ?>')">
                                <i class="fas fa-quote-left"></i> Copy Pesan
                            </a>
                            <?php if ($isBelum): ?>
                                <a href="?done=<?= $row['id_pertanyaan'] ?>" class="btn-done" onclick="return confirm('Tandai sudah dibalas?')">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if(mysqli_num_rows($q) == 0): ?>
                    <tr><td colspan="5" style="text-align:center; padding: 40px; color: #999; font-style: italic;">Belum ada pertanyaan masuk.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert("Berhasil disalin ke clipboard!");
    });
}
</script>

</body>
</html>
