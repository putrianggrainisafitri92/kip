<?php
include('../koneksi.php');

// =========================
// Ambil data hanya yang sudah disetujui Admin 3
// =========================

// Total mahasiswa approved
$totalQuery = $koneksi->query("SELECT COUNT(*) AS total FROM mahasiswa_kip WHERE status='approved'");
$totalMahasiswa = $totalQuery->fetch_assoc()['total'];

// Data untuk grafik per tahun (approved)
$grafikQuery = $koneksi->query("
    SELECT tahun, COUNT(*) AS jumlah 
    FROM mahasiswa_kip 
    WHERE status='approved'
    GROUP BY tahun 
    ORDER BY tahun ASC
");
$tahun = [];
$jumlah = [];
while ($row = $grafikQuery->fetch_assoc()) {
    $tahun[] = $row['tahun'];
    $jumlah[] = $row['jumlah'];
}

// Daftar jurusan (approved)
$jurusanQuery = $koneksi->query("
    SELECT DISTINCT jurusan 
    FROM mahasiswa_kip 
    WHERE status='approved' 
    ORDER BY jurusan ASC
");
$jurusanList = [];
while ($row = $jurusanQuery->fetch_assoc()) {
    $jurusanList[] = $row['jurusan'];
}

// Daftar tahun SK (approved)
$skQuery = $koneksi->query("
    SELECT DISTINCT tahun 
    FROM sk_kipk 
    WHERE status='approved'
    ORDER BY tahun ASC
");
$skTahunList = [];
while ($row = $skQuery->fetch_assoc()) {
    $skTahunList[] = $row['tahun'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistik Pertahun - KIP-Kuliah POLINELA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    background: url("../assets/bgpolinela.jpeg") no-repeat center center;
    background-size: cover;  
    font-family: 'Poppins', sans-serif;
    color: #333;
    min-height: 100vh;        
}

/* Main Content */
.main-content {
    margin-left: 250px;
    margin-top: 70px;
    padding: 20px;
    transition: all 0.3s;
}
/* HP & Tablet */
@media (max-width: 991px) {
    .main-content {
        margin-left: 0;
        margin-top: 70px;
        padding: 15px;
    }
}
/* Statistik Container */
.container-statistik {
    width: 90%;
    max-width: 1100px;
    background: rgba(255, 255, 255, 0.95); /* putih semi-transparan */
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
/* HP */
@media (max-width: 576px) {
    .container-statistik {
        padding: 20px;
        border-radius: 12px;
    }
}

/* Title */
h2 {
    text-align: center;
    font-weight: 700;
    color: #2b2b9f;
    margin-bottom: 25px;
}

/* Chart */
.chart-container {
    position: relative;
    margin: auto;
    height: 300px;
    width: 90%;
}
@media (max-width: 576px) {
    .chart-container {
        height: 220px;
    }
}

/* Info Box */
.info-box {
    border-radius: 15px;
    background: #f1f1ff;
    text-align: center;
    padding: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    position: relative;
    overflow: visible; 
}
@media (max-width: 767px) {
    .info-box {
        margin-bottom: 15px;
    }
}

.dropdown-wrapper {
    position: relative; 
    width: 100%;       
}
#jurusanSelect {
    width: 100%;
    font-size: 14px;
    padding: 8px 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background: #fff;
    z-index: 10;  
}
.info-box:hover {
    background: #dfe2ff;
    transform: scale(1.05);
}

/* Select Dropdown */
select {
    border-radius: 10px;
    padding: 8px 10px;
    border: 1px solid #ccc;
}

/* Dropdown Tahun */
.dropdown-tahun {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    padding: 12px;
    display: none;
    z-index: 999;
    width: 80%;
}
@media (max-width: 576px) {
    .dropdown-tahun {
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
    }
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    overflow: auto;
}

..modal-content {
    background: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 50%;
    max-width: 500px;
    position: relative;
}

.close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}

/* Modal List */
.modal-content ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.modal-content ul li {
    margin-bottom: 10px;
}

.modal-content ul li a {
    display: block;
    width: 100%;
    text-align: center;
    padding: 10px;
    background-color: #4B0082;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
}

.modal-content ul li a:hover {
    background-color: #6a1b9a;
}

/* Responsive */
@media (max-width: 991px) {
    .main-content {
        margin-left: 0 !important;
    }
    .modal-content {
        width: 90%;
    }
}

</style>
</head>
<body>

<?php include('../sidebar.php'); ?>

<div class="main-content">
  <div class="container-statistik">
    <h2>Statistik Pertahun</h2>

    <!-- Grafik -->
    <div class="chart-container mb-4">
      <canvas id="grafikTahun"></canvas>
    </div>

    <!-- 3 Box Bawah -->
    <div class="row text-center mt-4">
      <!-- Box Total -->
      <div class="col-md-4">
      <div class="info-box">
        Total Mahasiswa<br>
        <span class="fs-4 text-primary" id="totalMahasiswa"><?= $totalMahasiswa; ?></span>
      </div>
    </div>


      <!-- Box Nama Jurusan -->
      <div class="col-md-4">
        <div class="info-box">
          <label>Nama Jurusan</label><br>
          <select id="jurusanSelect" onchange="jurusanBerubah(this.value)">
            <option value="">-- Pilih Jurusan --</option>
            <?php foreach ($jurusanList as $j): ?>
              <option value="<?= htmlspecialchars($j) ?>"><?= htmlspecialchars($j) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Box SK -->
      <div class="col-md-4 position-relative">
        <div class="info-box" id="skBox">
          SK KIP-K<br>
          <span class="text-muted">Klik untuk pilih tahun</span>
          <div class="dropdown-tahun" id="dropdownSK">
            <label for="tahunSelect" class="fw-semibold mb-2 d-block">Pilih Tahun:</label>
            <select id="tahunSelect" class="form-select">
              <option value="">-- Pilih Tahun --</option>
              <?php foreach($skTahunList as $th): ?>
                <option value="<?= $th ?>"><?= $th ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal SK -->
<div id="modalSK" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h4>Daftar SK</h4>
    <ul id="listSK"></ul>
  </div>
</div>

<script>
// Chart Tahun
const ctx = document.getElementById('grafikTahun');
let chartTahun = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?php echo json_encode($tahun); ?>,
    datasets: [{
      label: 'Jumlah Mahasiswa per Tahun',
      data: <?php echo json_encode($jumlah); ?>,
      backgroundColor: 'rgba(43, 43, 159, 0.6)',
      borderColor: '#2b2b9f',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: { y: { beginAtZero: true } },
    plugins: { legend: { display: false } }
  }
});

// Fungsi Jurusan
function jurusanBerubah(jurusan) {
  if(!jurusan) return;
  fetch("get_grafik_jurusan.php?jurusan=" + encodeURIComponent(jurusan) + "&status=approved")
    .then(res => res.json())
    .then(data => {
      chartTahun.data.labels = data.tahun;
      chartTahun.data.datasets[0].data = data.jumlah.map(Number);
      chartTahun.update();
    })
    .catch(err => console.error('Gagal fetch grafik jurusan:', err));
}

// Dropdown SK
const skBox = document.getElementById('skBox');
const dropdown = document.getElementById('dropdownSK');
const tahunSelect = document.getElementById('tahunSelect');
const modal = document.getElementById('modalSK');
const listSK = document.getElementById('listSK');

// Toggle dropdown SK
skBox.addEventListener('click', e => {
  e.stopPropagation();
  dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
});
document.addEventListener('click', e => { if(!skBox.contains(e.target)) dropdown.style.display = 'none'; });
dropdown.addEventListener('click', e => e.stopPropagation());

// Modal functions
function openModal(){ modal.style.display = 'block'; }
function closeModal(){ modal.style.display = 'none'; }
window.onclick = function(event){ if(event.target == modal) closeModal(); }

// Pilih tahun SK
tahunSelect.addEventListener('change', function(){
  const tahun = this.value;
  if(!tahun) return;

  fetch('get_sk.php?tahun=' + encodeURIComponent(tahun) + "&status=approved")
    .then(res => res.json())
    .then(data => {
      if(!data || data.length === 0){
        alert('SK untuk tahun '+tahun+' tidak ditemukan.');
        return;
      }

      if(data.length === 1){
        window.open(data[0].file_url,'_blank');
      } else {
        listSK.innerHTML = '';
        data.forEach(sk=>{
          const li = document.createElement('li');
          li.innerHTML = `<a href="${sk.file_url}" target="_blank">${sk.nama_sk}</a>`;
          listSK.appendChild(li);
        });
        openModal();
      }
      dropdown.style.display = 'none';
    })
    .catch(err => {
      console.error('Gagal fetch SK:', err);
      alert('Terjadi kesalahan saat mengambil data SK.');
      dropdown.style.display = 'none';
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<?php include('../footer.php'); ?>
</body>
</html>
