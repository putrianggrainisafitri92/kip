<?php
include '../sidebar.php';
include '../../koneksi.php';

// Query total keseluruhan
$total = $koneksi->query("SELECT COUNT(*) AS jumlah FROM mahasiswa_kip")->fetch_assoc();

// Query total per tahun
$perTahun = $koneksi->query("SELECT tahun, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY tahun ORDER BY tahun DESC");

// Query total per jurusan
$perJurusan = $koneksi->query("SELECT jurusan, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY jurusan ORDER BY jurusan ASC");

// Query total per prodi
$perProdi = $koneksi->query("SELECT program_studi, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY program_studi ORDER BY program_studi ASC");

// Query total per skema
$perSkema = $koneksi->query("SELECT skema, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY skema ORDER BY skema ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Total Keseluruhan Mahasiswa KIP</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f2f2f7; /* abu-abu muda */
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
}
.content {
    margin-left: 250px; /* sesuaikan jika pakai sidebar */
    padding: 30px;
}
.title {
    text-align: center;
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 25px;
    color: #1e3c72;
}
.btn-primary, .btn-secondary {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.btn-primary {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: #fff;
    border: none;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #2a5298, #1e3c72);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(30,60,114,0.3);
}
.btn-secondary {
    background: linear-gradient(135deg, #7e8ba3, #5a6c7d);
    color: #fff;
    border: none;
}
.btn-secondary:hover {
    background: linear-gradient(135deg, #5a6c7d, #7e8ba3);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(90,108,125,0.3);
}
.card {
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
    margin-bottom: 25px;
    border: none;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.card-header {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    font-weight: 600;
    font-size: 16px;
    padding: 12px 20px;
}
.card-body h3 {
    font-weight: 700;
    color: #1e3c72;
    margin: 0;
}
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 8px;
    overflow: hidden;
}
table thead {
    background: linear-gradient(135deg, #2a5298, #1e3c72);
    color: #fff;
}
table th, table td {
    padding: 10px 12px;
    text-align: left;
    font-size: 14px;
}
table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}
table tbody tr:hover {
    background-color: #e3f2fd;
}
</style>
</head>
<body>

<div class="content">
    <h2 class="title">Hasil Total Keseluruhan Mahasiswa KIP</h2>

    <!-- Tombol Download PDF dan Kembali -->
    <div class="mb-4">
        <a href="download_total_pdf.php" class="btn btn-primary mb-2">
            <i class="bi bi-download"></i> Unduh PDF
        </a>
        <br>
        <a href="../uploadjumlah/index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Data Mahasiswa
        </a>
    </div>

    <!-- Total Keseluruhan -->
    <div class="card">
        <div class="card-header">Total Keseluruhan Mahasiswa</div>
        <div class="card-body">
            <h3><strong><?= $total['jumlah']; ?></strong> Mahasiswa</h3>
        </div>
    </div>

    <!-- Total Per Tahun -->
    <div class="card">
        <div class="card-header">Total Mahasiswa Per Tahun</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $perTahun->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['tahun']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total Per Jurusan -->
    <div class="card">
        <div class="card-header">Total Mahasiswa Per Jurusan</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Jurusan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $perJurusan->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['jurusan']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total Per Prodi -->
    <div class="card">
        <div class="card-header">Total Mahasiswa Per Program Studi</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Program Studi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $perProdi->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['program_studi']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total Per Skema -->
    <div class="card">
        <div class="card-header">Total Mahasiswa Per Skema</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Skema</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $perSkema->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['skema']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
