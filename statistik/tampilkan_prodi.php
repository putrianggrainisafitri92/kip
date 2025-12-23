<?php
include '../koneksi.php';

if (!isset($_GET['prodi']) || $_GET['prodi'] == '') {
  die("<script>alert('Program Studi tidak dipilih!'); window.location='pilih_prodi.php';</script>");
}

$prodi = $_GET['prodi'];
$stmt = $conn->prepare("SELECT npm, nama_mahasiswa, program_studi, jurusan, tahun, skema FROM mahasiswa_kip WHERE program_studi = ?");
$stmt->bind_param("s", $prodi);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa - <?= htmlspecialchars($prodi); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
      margin-left: 260px;
      padding: 20px;
    }
    h1 {
      color: #4B0082;
      font-weight: 700;
      margin-bottom: 20px;
    }
    table {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    th {
      background-color: #4B0082;
      color: white;
      text-align: center;
    }
    td {
      text-align: center;
    }
    .btn-danger {
      background-color: #dc3545;
      border: none;
    }
  </style>
</head>
<body>
  <h1>📚 Data Mahasiswa KIP-Kuliah</h1>
  <h5>Program Studi: <b><?= htmlspecialchars($prodi); ?></b></h5>

  <table class="table table-bordered table-hover mt-3">
    <thead>
      <tr>
        <th>NPM</th>
        <th>Nama Mahasiswa</th>
        <th>Jurusan</th>
        <th>Tahun</th>
        <th>Skema</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['npm']); ?></td>
          <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
          <td><?= htmlspecialchars($row['jurusan']); ?></td>
          <td><?= htmlspecialchars($row['tahun']); ?></td>
          <td><?= htmlspecialchars($row['skema']); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a href="cetak_prodi.php?prodi=<?= urlencode($prodi); ?>" target="_blank" class="btn btn-danger mt-3">
    🖨️ Cetak ke PDF
  </a>

  <a href="pilih_prodi.php" class="btn btn-secondary mt-3">⬅️ Kembali</a>
</body>
</html>
