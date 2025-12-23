<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>


<?php
include '../koneksi.php';
include 'sidebar.php';

// Update status laporan jika tombol aksi diklik
if (isset($_GET['ubah_status'])) {
    $id = $_GET['id'];
    $status = $_GET['ubah_status'];
    mysqli_query($koneksi, "UPDATE laporan SET status='$status' WHERE id='$id'");
    header("Location: data_pelapor.php");
    exit;
}

// Ambil semua data laporan
$semua_laporan = mysqli_query($koneksi, "SELECT * FROM laporan ORDER BY id DESC");

// Ambil data laporan yang sudah ditindaklanjuti
$riwayat_laporan = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status='Ditindaklanjuti' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pelapor - Admin KIP</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f6fb;
}
.main-content {
    margin-left: 250px;
    padding: 30px;
}
.table thead {
    background: linear-gradient(90deg, #4B6CB7, #182848);
    color: white;
}
.table td, .table th {
    vertical-align: middle !important;
}

/* ======== STATUS BADGE MODERN ======== */
.status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-width: 140px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 25px;
    padding: 6px 12px;
    color: #fff;
    text-align: center;
    text-transform: capitalize;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* Warna status */
.status.belum {
    background-color: #dc3545; /* merah */
}

.status.sudah {
    background-color: #ffc107; /* kuning */
    color: #000;
}

.status.lanjut {
    background-color: #28a745; /* hijau */
}

/* ======== CARD & BUTTON STYLE ======== */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.btn-group .btn {
    border-radius: 10px !important;
    padding: 6px 10px !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.btn-group .btn i {
    font-size: 14px;
}
</style>
</head>

<body>
<div class="main-content">
    <h2 class="mb-4 text-primary"><i class="bi bi-bar-chart"></i> Jumlah Pelaporan Mahasiswa</h2>

    <!-- Tabel Semua Pelaporan -->
    <div class="card p-4 mb-5">
        <h5 class="mb-3 text-secondary"><i class="bi bi-folder2-open"></i> Daftar Laporan Aktif</h5>
        <table class="table table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelapor</th>
                    <th>Email</th>
                    <th>Nama Terlapor</th>
                    <th>NPM</th>
                    <th>Jurusan</th>
                    <th>Alasan</th>
                    <th>Detail</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($semua_laporan)) {
                $status = $row['status'] ?? 'Belum Ditinjau';
                echo "<tr>
                        <td>$no</td>
                        <td>{$row['nama_pelapor']}</td>
                        <td>{$row['email_pelapor']}</td>
                        <td>{$row['nama_terlapor']}</td>
                        <td>{$row['npm_terlapor']}</td>
                        <td>{$row['jurusan']}</td>
                        <td>{$row['alasan']}</td>
                        <td>{$row['detail_laporan']}</td>
                        <td><a href='../uploads/{$row['bukti']}' target='_blank'>Lihat</a></td>";

                // Tampilan status modern
                if ($status == 'Belum Ditinjau') {
                    echo "<td><span class='status belum'><i class='bi bi-exclamation-circle'></i> Belum Ditinjau</span></td>";
                } elseif ($status == 'Sudah Ditinjau') {
                    echo "<td><span class='status sudah'><i class='bi bi-eye-fill'></i> Sudah Ditinjau</span></td>";
                } elseif ($status == 'Ditindaklanjuti') {
                    echo "<td><span class='status lanjut'><i class='bi bi-check-circle-fill'></i> Ditindaklanjuti</span></td>";
                } else {
                    echo "<td><span class='status belum'><i class='bi bi-question-circle'></i> Belum Ditinjau</span></td>";
                }

                echo "<td>
                        <div class='btn-group'>
                            <a href='?ubah_status=Sudah Ditinjau&id={$row['id']}' class='btn btn-sm btn-warning'><i class='bi bi-eye'></i></a>
                            <a href='?ubah_status=Ditindaklanjuti&id={$row['id']}' class='btn btn-sm btn-success'><i class='bi bi-check2-circle'></i></a>
                        </div>
                      </td>
                      </tr>";
                $no++;
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Tabel Riwayat -->
    <div class="card p-4">
        <h5 class="mb-3 text-secondary"><i class="bi bi-clock-history"></i> Riwayat Tindak Lanjut</h5>
        <table class="table table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelapor</th>
                    <th>Nama Terlapor</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            while ($r = mysqli_fetch_assoc($riwayat_laporan)) {
                echo "<tr>
                        <td>$no</td>
                        <td>{$r['nama_pelapor']}</td>
                        <td>{$r['nama_terlapor']}</td>
                        <td>{$r['jurusan']}</td>
                        <td><span class='status lanjut'><i class='bi bi-check-circle-fill'></i> Ditindaklanjuti</span></td>
                        <td>" . date('d M Y', strtotime($r['tanggal'] ?? 'now')) . "</td>
                      </tr>";
                $no++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
