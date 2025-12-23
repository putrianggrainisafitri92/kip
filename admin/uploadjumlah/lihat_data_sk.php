<?php
include '../sidebar.php';
include '../../koneksi.php';

// Ambil semua data SK
$dataSK = $koneksi->query("SELECT * FROM sk_kipk ORDER BY tahun DESC, id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar SK KIP-K</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: Arial, sans-serif; background: #f4f6fa; }
.content { margin-left: 220px; padding: 35px; }
h2 { color: #1f4aa8; text-align: center; margin-bottom: 20px; }
table { width: 100%; border-collapse: collapse; background: white; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
th { background: #1f4aa8; color: white; }
.action-btn { padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; color: white; }
.update-btn { background: #1f4aa8; }
.delete-btn { background: #e74c3c; }
.nav-btn { background: #6c757d; margin-top: 10px; color: white; padding: 7px 15px; border-radius: 5px; text-decoration: none; display:inline-block; }
.nav-btn:hover { background: #5a6268; }
</style>
</head>
<body>
<div class="content">
    <h2> Data SK KIP-K</h2>

    <!-- Tombol Upload SK Baru -->
    <div class="mb-3">
        <a href="upload_sk.php" class="btn btn-success">+ Upload SK Baru</a>
    </div>

    <!-- Tombol Kembali ke Data Mahasiswa -->
    <div class="mb-3">
        <a href="../uploadjumlah/index.php" class="nav-btn">← Kembali ke Data Mahasiswa</a>
    </div>

    <table>
        <tr>
            <th>Nama SK</th>
            <th>Tahun</th>
            <th>Nomor SK</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>

        <?php if($dataSK->num_rows > 0): ?>
            <?php while($row = $dataSK->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama_sk']) ?></td>
                    <td><?= htmlspecialchars($row['tahun']) ?></td>
                    <td><?= htmlspecialchars($row['nomor_sk']) ?></td>
                    <td><a href="<?= htmlspecialchars($row['file_url']) ?>" target="_blank">Lihat File</a></td>
                    <td>
                        <button class="action-btn update-btn"
                            onclick="location.href='update_sk.php?id=<?= $row['id'] ?>'">
                            Update
                        </button>
                        <button class="action-btn delete-btn"
                            onclick="if(confirm('Yakin hapus SK ini?')) location.href='hapus_row_sk.php?id=<?= $row['id'] ?>'">
                            Hapus
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Data SK belum tersedia.</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
