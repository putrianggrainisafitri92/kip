<?php
include('../koneksi.php');

// Gunakan variabel koneksi yang benar
$query = $koneksi->query("SELECT * FROM mahasiswa_kip ORDER BY jurusan, program_studi, nama_mahasiswa");

echo "<div class='mt-4'>";
echo "<h5 class='text-center fw-bold mb-3'>Daftar Seluruh Mahasiswa Penerima KIP-K</h5>";
echo "<div class='table-responsive'>";
echo "<table class='table table-bordered table-striped'>
<thead class='table-light'>
<tr>
  <th>No</th>
  <th>NPM</th>
  <th>Nama</th>
  <th>Program Studi</th>
  <th>Jurusan</th>
  <th>Tahun</th>
  <th>Skema</th>
</tr>
</thead>
<tbody>";

$no = 1;
while ($row = $query->fetch_assoc()) {
    echo "<tr>
        <td>$no</td>
        <td>" . htmlspecialchars($row['npm']) . "</td>
        <td>" . htmlspecialchars($row['nama_mahasiswa']) . "</td>
        <td>" . htmlspecialchars($row['program_studi']) . "</td>
        <td>" . htmlspecialchars($row['jurusan']) . "</td>
        <td>" . htmlspecialchars($row['tahun']) . "</td>
        <td>" . htmlspecialchars($row['skema']) . "</td>
    </tr>";
    $no++;
}

echo "</tbody></table></div></div>";
?>
