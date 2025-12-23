<?php
include '../../koneksi.php';

// Hitung total mahasiswa
$total_mahasiswa = 0;
$result_total = $koneksi->query("SELECT COUNT(*) AS total FROM mahasiswa_kip");
if ($row_total = $result_total->fetch_assoc()) {
    $total_mahasiswa = $row_total['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa KIP dan SK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

  <style>
    body {
      background-color: #f4f6fa;
      font-family: 'Poppins', sans-serif;
    }
    .content {
      margin-left: 250px;
      padding: 30px;
    }
    .title {
      text-align: center;
      font-weight: 600;
      font-size: 24px;
      margin-bottom: 30px;
    }

    /* Tombol utama */
    .btn-main {
      border-radius: 8px;
      font-weight: 500;
      margin: 6px;
      padding: 12px 18px;
      min-width: 220px;
      height: 60px;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: all 0.3s ease;
    }

    /* ✅ Kotak Total Keseluruhan seukuran tombol */
    .total-box {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background: linear-gradient(135deg, #2c437c, #1a2a4f);
      color: white;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
      min-width: 220px;
      height: 60px;
      margin: 6px;
    }

    .total-box:hover {
      transform: translateY(-3px);
      background: linear-gradient(135deg, #1a2a4f, #2c437c);
    }

    .total-box h4 {
      font-size: 13px;
      font-weight: 500;
      margin: 0;
      line-height: 1.2;
    }

    .total-box p {
      font-size: 20px;
      font-weight: 700;
      margin: 0;
    }

    /* Tabel */
    .table thead th {
      background-color: #2c437c;
      color: white;
      text-align: center;
    }

    .dataTables_filter input {
      border-radius: 8px;
      padding: 5px 10px;
      border: 1px solid #ccc;
    }
  </style>
</head>

<body>
  <?php include '../sidebar.php'; ?>

  <div class="content">
    <h2 class="title">Data Mahasiswa KIP dan SK</h2>

    <div class="d-flex justify-content-center flex-wrap align-items-center mb-4">
      <a href="upload_data_mahasiswa.php" class="btn btn-primary btn-main">+ Upload File Excel</a>
      <a href="update_data_mahasiswa.php" class="btn btn-info btn-main text-white">Update Data Mahasiswa</a>

      <!-- ✅ Kotak Total Keseluruhan -->
      <a href="../uploadjumlah/total_keseluruhan.php" style="text-decoration:none;">
        <div class="total-box">
          <h4>Total Keseluruhan</h4>
          <p><?= number_format($total_mahasiswa); ?></p>
        </div>
      </a>

      <a href="hapus_data_mahasiswa.php" class="btn btn-danger btn-main">Hapus Data Mahasiswa</a>
      <a href="lihat_data_sk.php" class="btn btn-dark btn-main">Lihat Data SK</a>
    </div>

    <div class="card">
      <div class="card-header bg-dark text-white">
        <strong>Daftar Mahasiswa KIP</strong>
      </div>
      <div class="card-body">
        <table id="tabelMahasiswa" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>NPM</th>
              <th>Nama Mahasiswa</th>
              <th>Program Studi</th>
              <th>Jurusan</th>
              <th>Tahun</th>
              <th>Skema</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            $result = $koneksi->query("SELECT * FROM mahasiswa_kip ORDER BY tahun DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['npm']}</td>
                        <td>{$row['nama_mahasiswa']}</td>
                        <td>{$row['program_studi']}</td>
                        <td>{$row['jurusan']}</td>
                        <td>{$row['tahun']}</td>
                        <td>{$row['skema']}</td>
                      </tr>";
                $no++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ✅ JQuery + DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#tabelMahasiswa').DataTable({
        "pageLength": 10,
        "lengthChange": true,
        "language": {
          "search": "Cari Nama atau NPM:",
          "lengthMenu": "Tampilkan _MENU_ data per halaman",
          "zeroRecords": "Data tidak ditemukan",
          "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          "infoEmpty": "Tidak ada data tersedia",
          "infoFiltered": "(disaring dari _MAX_ total data)"
        }
      });
    });
  </script>
</body>
</html>
