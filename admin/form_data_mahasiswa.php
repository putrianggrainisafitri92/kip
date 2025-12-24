<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include '../koneksi.php'; // koneksi ke database
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Data Mahasiswa KIP</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <!-- html2pdf.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 12pt;
      margin: 0;
      background: #f8fafc;
      color: #000;
    }

    .main-content {
      padding: 2rem;
      margin-left: 260px; /* agar tidak tabrakan sidebar */
    }

    /* Kop Surat */
    .kop-header {
      text-align: center;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
      margin-bottom: 1.5rem;
    }

    .kop-header img {
      width: 80px;
      height: 80px;
      margin-bottom: 10px;
    }

    .kop-header h2 {
      margin: 0;
      font-size: 16pt;
      font-weight: bold;
    }

    .kop-header h3 {
      margin: 0;
      font-size: 13pt;
      font-weight: bold;
    }

    .kop-header p {
      margin: 0;
      font-size: 11pt;
    }

    h1 {
      font-size: 18pt;
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      margin-bottom: 1rem;
    }

    .print-date {
      text-align: right;
      margin-bottom: 15px;
      font-size: 11pt;
    }

    /* Section Data */
    .data-section {
      background: #ffffff;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid #999;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      font-size: 12pt;
      margin-top: 0.5rem;
    }

    th, td {
      border: 1px solid #000;
      padding: 8px;
      text-align: center;
    }

    th {
      background: #e2e8f0;
      font-weight: bold;
      text-transform: uppercase;
    }

    tr:nth-child(even) td {
      background: #f7fafc;
    }

    .no-data {
      text-align: center;
      padding: 20px;
      font-weight: bold;
      border: 1px dashed #999;
      border-radius: 5px;
      background: #f1f5f9;
    }

    /* Button PDF */
    .download-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: #1e40af;
      color: white;
      padding: 8px 18px;
      border-radius: 8px;
      font-weight: bold;
      transition: 0.3s;
      margin-bottom: 20px;
    }

    .download-btn:hover {
      background: #2563eb;
    }

    .icon-wrapper {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 30px;
      height: 30px;
      background: #ccc;
      border-radius: 5px;
      color: #000;
      font-size: 1rem;
      margin-right: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .main-content {
        margin-left: 0; /* agar mobile tidak terpotong */
        padding: 1rem;
      }
    }
  </style>
</head>
<body>

  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <div class="text-center mb-6">
      <button id="downloadPDF" class="download-btn">
        <i class="fas fa-file-pdf"></i> Unduh PDF
      </button>
    </div>

    <div id="pdfArea">
      <!-- KOP LAPORAN -->
      <div class="kop-header">
        <img src="../assets/logo-polinela.png" alt="Logo Polinela" class="w-14 mr-3 drop-shadow-lg">
        <h2>POLITEKNIK NEGERI LAMPUNG</h2>
        <h3>Jl. Soekarno-Hatta No.10, Rajabasa, Bandar Lampung 35144</h3>
        <p>Telp. (0721) 703995 | Website: polinela.ac.id</p>
      </div>

      <h1>LAPORAN DATA MAHASISWA PENERIMA KIP</h1>
      <p class="print-date">Tanggal cetak: <?php echo date('d-m-Y'); ?></p>

      <!-- Data Mahasiswa per Tahun -->
      <div class="data-section">
        <h2><div class="icon-wrapper"><i class="fas fa-calendar-alt"></i></div> Total Mahasiswa per Tahun</h2>
        <?php
        $tahun = mysqli_query($koneksi, "SELECT tahun, COUNT(*) AS total FROM mahasiswa_kip GROUP BY tahun ORDER BY tahun ASC");
        if(mysqli_num_rows($tahun) > 0){
          echo '<table><tr><th>Tahun</th><th>Total Mahasiswa</th></tr>';
          while($row = mysqli_fetch_assoc($tahun)){
            echo "<tr><td>{$row['tahun']}</td><td>{$row['total']}</td></tr>";
          }
          echo '</table>';
        } else {
          echo "<div class='no-data'>Belum ada data mahasiswa tersedia.</div>";
        }
        ?>
      </div>

      <!-- Data Mahasiswa per Jurusan -->
      <div class="data-section">
        <h2><div class="icon-wrapper"><i class="fas fa-graduation-cap"></i></div> Total Mahasiswa per Jurusan</h2>
        <?php
        $jurusan = mysqli_query($koneksi, "SELECT jurusan, COUNT(*) AS total FROM mahasiswa_kip GROUP BY jurusan ORDER BY jurusan");
        if(mysqli_num_rows($jurusan) > 0){
          echo '<table><tr><th>Jurusan</th><th>Total Mahasiswa</th></tr>';
          while($row = mysqli_fetch_assoc($jurusan)){
            echo "<tr><td>{$row['jurusan']}</td><td>{$row['total']}</td></tr>";
          }
          echo '</table>';
        } else {
          echo "<div class='no-data'>Belum ada data jurusan tersedia.</div>";
        }
        ?>
      </div>

      <!-- Data Mahasiswa per Program Studi -->
      <div class="data-section">
        <h2><div class="icon-wrapper"><i class="fas fa-book"></i></div> Total Mahasiswa per Program Studi</h2>
        <?php
        $prodi = mysqli_query($koneksi, "SELECT program_studi, COUNT(*) AS total FROM mahasiswa_kip GROUP BY program_studi ORDER BY program_studi");
        if(mysqli_num_rows($prodi) > 0){
          echo '<table><tr><th>Program Studi</th><th>Total Mahasiswa</th></tr>';
          while($row = mysqli_fetch_assoc($prodi)){
            echo "<tr><td>{$row['program_studi']}</td><td>{$row['total']}</td></tr>";
          }
          echo '</table>';
        } else {
          echo "<div class='no-data'>Belum ada data program studi tersedia.</div>";
        }
        ?>
      </div>

    </div>
  </div>

  <script>
    document.getElementById("downloadPDF").addEventListener("click", function () {
      const element = document.getElementById("pdfArea");
      const opt = {
        margin: 0.5,
        filename: 'Laporan_Mahasiswa_KIP.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
      };
      html2pdf().set(opt).from(element).save();
    });
  </script>

</body>
</html>
