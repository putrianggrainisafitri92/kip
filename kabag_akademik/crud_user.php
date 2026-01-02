<?php
session_start();
include '../protect.php';
check_level(13);
include '../koneksi.php';
include 'sidebar.php';

$q = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY level ASC, id_admin ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User - Kabag Akademik</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
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
            left: 0; bottom: -5px;
            width: 50px; height: 4px;
            background: #7b35d4;
            border-radius: 2px;
        }

        .btn-add {
            background: #4e0a8a;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(78, 10, 138, 0.2);
            transition: 0.3s;
        }
        .btn-add:hover {
            background: #7b35d4;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 10, 138, 0.3);
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
            min-width: 800px;
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

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            background: #f0e6ff;
            color: #7b35d4;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.2rem;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            color: white;
        }
        .lvl-11 { background: #9b59b6; } /* Admin 1 */
        .lvl-12 { background: #3498db; } /* Admin 2 */
        .lvl-13 { background: #e67e22; } /* Admin 3 */

        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.2s;
            font-size: 14px;
        }
        .btn-edit { background: #e3f2fd; color: #1976d2; margin-right: 5px; }
        .btn-edit:hover { background: #1976d2; color: white; }
        
        .btn-delete { background: #ffebee; color: #c62828; }
        .btn-delete:hover { background: #c62828; color: white; }

        @media (max-width: 1024px) {
            .content { margin-left: 0; padding: 85px 15px 40px 15px; }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="header-section">
        <h2>Manajemen User</h2>
        <a href="user_add.php" class="btn-add">
            <i class="fas fa-user-plus"></i> Tambah User
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align:center;">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th style="text-align:center;">Level Akses</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($d = mysqli_fetch_array($q)){ 
                    $lvl = intval($d['level']);
                ?>
                <tr>
                    <td style="text-align:center; font-weight: 600; color: #999;"><?= $no++ ?></td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar"><i class="fas fa-user"></i></div>
                            <div style="font-weight: 700; color: #4e0a8a;"><?= htmlspecialchars($d['nama_lengkap']); ?></div>
                        </div>
                    </td>
                    <td>
                        <code style="background: #f4f4f4; padding: 2px 6px; border-radius: 4px; color: #e83e8c;">@<?= htmlspecialchars($d['username']); ?></code>
                    </td>
                    <td style="text-align:center;">
                        <span class="badge lvl-<?= $lvl ?>">
                            Level <?= $lvl ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <a href="user_edit.php?id=<?= $d['id_admin']; ?>" class="btn-action btn-edit" title="Edit User">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="user_delete.php?id=<?= $d['id_admin']; ?>" class="btn-action btn-delete" title="Hapus User" onclick="return confirm('Hapus user ini?');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
                <?php if(mysqli_num_rows($q) == 0): ?>
                    <tr><td colspan="5" style="text-align:center; padding: 40px; color: #999; font-style: italic;">Belum ada user.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
