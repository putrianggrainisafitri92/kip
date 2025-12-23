<?php
require '../../vendor/autoload.php';
include '../../koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Setup Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Query data
$total = $koneksi->query("SELECT COUNT(*) AS jumlah FROM mahasiswa_kip")->fetch_assoc();
$perTahun = $koneksi->query("SELECT tahun, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY tahun ORDER BY tahun DESC");
$perJurusan = $koneksi->query("SELECT jurusan, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY jurusan ORDER BY jurusan ASC");
$perProdi = $koneksi->query("SELECT program_studi, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY program_studi ORDER BY program_studi ASC");
$perSkema = $koneksi->query("SELECT skema, COUNT(*) AS jumlah FROM mahasiswa_kip GROUP BY skema ORDER BY skema ASC");

// Mulai HTML
$html = '
<style>
    body { 
        font-family: "Times New Roman", Times, serif; 
        font-size: 12pt;
        color: #000;
        margin: 15px;
    }
    h2 { 
        text-align: center; 
        font-size: 16pt;
        margin-bottom: 15px;
        font-weight: bold;
    }
    h3 { 
        font-size: 14pt;
        margin-top: 15px;
        margin-bottom: 8px;
        font-weight: bold;
    }
    table { 
        border-collapse: collapse; 
        width: 100%; 
        margin-bottom: 10px;
        font-size: 12pt;
    }
    th, td { 
        border: 1px solid #999; 
        padding: 5px; 
        text-align: left;
    }
    th { 
        background-color: #f0f0f0;
        font-weight: bold;
    }
    tr:nth-child(even) { 
        background-color: #f9f9f9;
    }
</style>

<h2>Laporan Total Mahasiswa KIP</h2>

<h3>Total Keseluruhan</h3>
<table>
    <tr>
        <td>Total Mahasiswa</td>
        <td>' . $total['jumlah'] . '</td>
    </tr>
</table>

<h3>Per Tahun</h3>
<table>
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>';
while($row = $perTahun->fetch_assoc()) {
    $html .= '<tr>
        <td>'.$row['tahun'].'</td>
        <td>'.$row['jumlah'].'</td>
    </tr>';
}
$html .= '</tbody></table>

<h3>Per Jurusan</h3>
<table>
    <thead>
        <tr>
            <th>Jurusan</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>';
while($row = $perJurusan->fetch_assoc()) {
    $html .= '<tr>
        <td>'.$row['jurusan'].'</td>
        <td>'.$row['jumlah'].'</td>
    </tr>';
}
$html .= '</tbody></table>

<h3>Per Program Studi</h3>
<table>
    <thead>
        <tr>
            <th>Program Studi</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>';
while($row = $perProdi->fetch_assoc()) {
    $html .= '<tr>
        <td>'.$row['program_studi'].'</td>
        <td>'.$row['jumlah'].'</td>
    </tr>';
}
$html .= '</tbody></table>

<h3>Per Skema</h3>
<table>
    <thead>
        <tr>
            <th>Skema</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>';
while($row = $perSkema->fetch_assoc()) {
    $html .= '<tr>
        <td>'.$row['skema'].'</td>
        <td>'.$row['jumlah'].'</td>
    </tr>';
}
$html .= '</tbody></table>';

// Render PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_total_keseluruhan.pdf", ["Attachment" => true]);
exit();
?>
