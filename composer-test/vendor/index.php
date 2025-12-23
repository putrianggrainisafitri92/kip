<?php
// ===== Autoload Composer =====
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use GuzzleHttp\Client;

// ===== Koneksi Database =====
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pelaporan_mahasiswa"; // sesuaikan nama database

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ===== Set batas waktu & memory =====
ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');

$preview_data = [];
$inserted = $updated = 0;

// ===== Proses Upload Excel =====
if (isset($_POST['upload'])) {
    if (isset($_FILES['file_excel']) && $_FILES['file_excel']['error'] == 0) {

        $fileTmp  = $_FILES['file_excel']['tmp_name'];
        $fileName = $_FILES['file_excel']['name'];
        $ext      = pathinfo($fileName, PATHINFO_EXTENSION);

        if ($ext != 'xlsx') {
            echo "<script>alert('Hanya file .xlsx yang diperbolehkan');</script>";
        } else {
            try {
                $spreadsheet = IOFactory::load($fileTmp);
                $worksheet   = $spreadsheet->getActiveSheet();
                $rows        = $worksheet->toArray();

                $rownum = 0;

                foreach ($rows as $row) {
                    if ($rownum++ == 0) continue; // skip header

                    $npm           = isset($row[0]) ? trim($row[0]) : '';
                    $nama          = isset($row[1]) ? trim($row[1]) : '';
                    $program_studi = isset($row[2]) ? trim($row[2]) : '';
                    $jurusan       = isset($row[3]) ? trim($row[3]) : '';
                    $tahun         = isset($row[4]) && preg_match('/^[0-9]{4}$/', trim($row[4])) ? trim($row[4]) : null;
                    $skema         = isset($row[5]) ? trim($row[5]) : '';

                    if ($npm == '' || $nama == '') continue;

                    // ===== Cek data di DB =====
                    $cek = $koneksi->query("SELECT id FROM mahasiswa_kip WHERE npm='$npm'");
                    if ($cek->num_rows > 0) {
                        $koneksi->query("UPDATE mahasiswa_kip SET 
                            nama_mahasiswa='$nama',
                            program_studi='$program_studi',
                            jurusan='$jurusan',
                            tahun='$tahun',
                            skema='$skema'
                            WHERE npm='$npm'");
                        $updated++;
                    } else {
                        $koneksi->query("INSERT INTO mahasiswa_kip 
                            (npm, nama_mahasiswa, program_studi, jurusan, tahun, skema)
                            VALUES ('$npm', '$nama', '$program_studi', '$jurusan', '$tahun', '$skema')");
                        $inserted++;
                    }

                    // ===== Simpan untuk preview =====
                    $preview_data[] = [
                        'npm' => $npm,
                        'nama' => $nama,
                        'program_studi' => $program_studi,
                        'jurusan' => $jurusan,
                        'tahun' => $tahun,
                        'skema' => $skema
                    ];
                }

                echo "<script>alert('Upload selesai! Data baru: $inserted, Diperbarui: $updated');</script>";

            } catch (Exception $e) {
                echo "<script>alert('Gagal membaca file Excel: " . $e->getMessage() . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Pilih file Excel terlebih dahulu!');</script>";
    }
}

// ===== Test Guzzle =====
$client = new Client();
// Contoh request (bisa dikomen jika tidak dipakai)
// try {
//     $response = $client->get('https://api.github.com');
//     echo "Status code dari GitHub API: " . $response->getStatusCode() . "<br>";
// } catch (\Exception $e) {
//     echo "Guzzle gagal: " . $e->getMessage() . "<br>";
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Upload Data Penerimaan Mahasiswa</title>
<style>
body { font-family: Arial; background:#f5f5f5; text-align:center; padding:40px; }
form { background:#fff; display:inline-block; padding:20px 40px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);}
input[type="file"] { margin-bottom:15px;}
button { background:#007bff;color:white;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;}
button:hover { background:#0056b3;}
table { margin:30px auto; border-collapse:collapse; width:90%; background:#fff; box-shadow:0 0 10px rgba(0,0,0,0.1);}
th, td { border:1px solid #ddd; padding:8px 12px;}
th { background:#007bff; color:white;}
tr:nth-child(even){ background:#f2f2f2;}
h2,h3{ margin-bottom:10px;}
</style>
</head>
<body>

<h2>📊 Upload Data Penerimaan Mahasiswa (.xlsx)</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file_excel" accept=".xlsx" required><br>
    <button type="submit" name="upload">Upload & Update Database</button>
</form>

<?php if(!empty($preview_data)): ?>
<h3>📋 Preview Data dari Excel</h3>
<table>
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
<?php $no=1; foreach($preview_data as $d): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($d['npm']) ?></td>
    <td><?= htmlspecialchars($d['nama']) ?></td>
    <td><?= htmlspecialchars($d['program_studi']) ?></td>
    <td><?= htmlspecialchars($d['jurusan']) ?></td>
    <td><?= htmlspecialchars($d['tahun']) ?></td>
    <td><?= htmlspecialchars($d['skema']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

</body>
</html>
