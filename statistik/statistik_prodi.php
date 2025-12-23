<?php
include('../koneksi.php');
include('../sidebar.php');

// === Total Mahasiswa Semua Prodi ===
$totalQuery = $koneksi->query("SELECT COUNT(*) AS total FROM mahasiswa_kip WHERE status='approved'");
$totalMahasiswa = $totalQuery->fetch_assoc()['total'] ?? 0;

// === Ambil Daftar Prodi ===
$prodiQuery = $koneksi->query("SELECT DISTINCT program_studi FROM mahasiswa_kip WHERE status='approved' ORDER BY program_studi ASC");
$prodiList = [];
while ($row = $prodiQuery->fetch_assoc()) {
    $prodiList[] = $row['program_studi'];
}
$tahunSKQuery = $koneksi->query("
    SELECT DISTINCT tahun 
    FROM sk_kipk 
    WHERE status='approved'
    ORDER BY tahun ASC
");

$tahunSK = [];
while($row = $tahunSKQuery->fetch_assoc()){
    $tahunSK[] = $row['tahun'];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistik PerProdi - KIP-Kuliah POLINELA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
/* ========================
   Body & Layout
======================== */
body {
    background-color: #f5f6fa;
    font-family: 'Poppins', sans-serif;
    color: #333;
    margin: 0;
}

.main-content {
    margin-left: 250px;
    margin-top: 70px;
    padding: 20px;
    transition: all 0.3s;
}

/* ========================
   Statistik Container
======================== */
.container-statistik {
    width: 90%;
    max-width: 1100px;
    background: rgba(255, 255, 255, 0.95); /* putih semi-transparan */
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

h2 {
    text-align: center;
    font-weight: 700;
    color: #2b2b9f;
    margin-bottom: 25px;
}

/* ========================
   Chart
======================== */
.chart-container {
    position: relative;
    margin: auto;
    height: 300px;
    width: 90%;
}

/* ========================
   Info Box
======================== */
.info-box {
    border-radius: 15px;
    background: #f1f1ff;
    text-align: center;
    padding: 25px;
    font-weight: 600;
    cursor: pointer;
    position: relative;
    transition: 0.3s;
}

.info-box:hover {
    background: #dfe2ff;
    transform: scale(1.05);
}

/* ========================
   Select Dropdown
======================== */
select {
    border-radius: 10px;
    padding: 8px 10px;
    border: 1px solid #ccc;
}

.dropdown-tahun {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 -4px 10px rgba(0,0,0,0.15);
    padding: 12px;
    display: none;
    z-index: 999;
    width: 85%;
    animation: slideUp 0.2s ease;
}

@keyframes slideUp {
    from {
        transform: translate(-50%, 10px);
        opacity: 0;
    }
    to {
        transform: translate(-50%, 0);
        opacity: 1;
    }
}

/* ========================
   Hasil / Box Tambahan
======================== */
#hasil {
    margin-top: 30px;
    background: #f8f9ff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

/* ========================
   Modal SK
======================== */
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

.modal-content {
    background: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 12px;
    width: 50%;
    max-width: 500px;
    position: relative;
    border: 1px solid #7a6ff0;
}

.close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}

/* ========================
   List SK
======================== */
#listSK li {
    margin-bottom: 10px;
}

#listSK li a {
    display: block;
    background: #7a6ff0;
    color: #fff;
    padding: 10px;
    text-decoration: none;
    border-radius: 8px;
    text-align: center;
    transition: 0.3s;
}

#listSK li a:hover {
    background: #5f54d1;
}

/* ========================
   Responsive
======================== */
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

<div class="main-content">
  <div class="container-statistik">
    <h2>Statistik PerProdi</h2>

    <!-- Dropdown Prodi -->
    <div class="text-center mb-4">
      <label for="prodiSelect" class="fw-bold me-2">Pilih Program Studi:</label>
      <select id="prodiSelect" onchange="tampilkanGrafikProdi(this.value)">
        <option value="">-- Semua Prodi --</option>
        <?php foreach ($prodiList as $p): ?>
          <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Grafik Donat -->
    <div class="chart-container mb-4">
      <canvas id="grafikProdi"></canvas>
    </div>

    <!-- Info Box -->
    <div class="row text-center mt-4">
      <div class="col-md-4">
        <div class="info-box" onclick="tampilkanTotal()">
          Total Mahasiswa<br>
          <span class="fs-4 text-primary"><?= $totalMahasiswa; ?></span>
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box" onclick="tampilkanMahasiswa()">
          Nama Mahasiswa PerProdi<br>
          <span class="text-muted">Klik untuk lihat daftar</span>
        </div>
      </div>

      <div class="col-md-4 position-relative">
  <div class="info-box" id="skBox">
    SK KIP-K<br>
    <span class="text-muted">Klik untuk pilih tahun</span>

    <div class="dropdown-tahun" id="dropdownSK">
      <label for="tahunSelect" class="fw-semibold mb-2 d-block">
        Pilih Tahun:
      </label>

      <select id="tahunSelect" class="form-select">
        <option value="">-- Pilih Tahun --</option>
        <?php foreach($tahunSK as $tahun): ?>
          <option value="<?= $tahun ?>"><?= $tahun ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
</div>
    </div>

    <div id="hasil" class="mt-4"></div>
  </div>
</div>

<!-- Modal SK -->
<div id="modalSK" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h4>Daftar SK Tahun <span id="modalTahun"></span></h4>
    <ul id="listSK" style="list-style:none; padding-left:0;"></ul>
  </div>
</div>

<script>
let chartProdi;

function tampilkanGrafikProdi(prodi=""){
  fetch('grafik_prodi.php' + (prodi ? '?prodi=' + encodeURIComponent(prodi) : ''))
    .then(res => res.json())
    .then(data => {
      const ctx = document.getElementById('grafikProdi');

      if(!chartProdi){
        // Buat chart pertama kali
        chartProdi = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: data.labels,
            datasets: [{
              label: 'Mahasiswa per Tahun',
              data: data.data,
              backgroundColor: ['#2b2b9f','#5f54d1','#7a6ff0','#a391f7','#c5b9ff'],
              borderColor: '#fff',
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
              duration: 1000, 
              easing: 'easeOutQuart'
            },
            plugins: {
              legend: { display: true, position: 'bottom' },
              tooltip: { enabled: true }
            }
          }
        });
      } else {
        // Update data chart yang sudah ada
        chartProdi.data.labels = data.labels;
        chartProdi.data.datasets[0].data = data.data;
        chartProdi.update(); // <-- animasi tetap muncul
      }
    })
    .catch(err => console.error('Gagal memuat grafik:', err));
}

// Total Mahasiswa
function tampilkanTotal(){
  const prodi = document.getElementById('prodiSelect').value;
  if(!prodi){
    document.getElementById('hasil').innerHTML = `<div class="alert alert-info">Silakan pilih prodi terlebih dahulu.</div>`;
    return;
  }
  fetch('tampilkan_total.php?prodi=' + encodeURIComponent(prodi))
    .then(res => res.text())
    .then(html => document.getElementById('hasil').innerHTML = html)
    .catch(err => console.error(err));
}

// Daftar Mahasiswa PDF/Halaman Baru
function tampilkanMahasiswa(){
  const prodi = document.getElementById('prodiSelect').value;
  if(!prodi){ alert("Silakan pilih prodi terlebih dahulu!"); return; }
  window.open('cetak_prodi.php?prodi=' + encodeURIComponent(prodi),'_blank');
}

// SK Dropdown & Modal
const skBox = document.getElementById('skBox');
const dropdown = document.getElementById('dropdownSK');
const tahunSelect = document.getElementById('tahunSelect');
const modal = document.getElementById('modalSK');
const listSK = document.getElementById('listSK');
const modalTahun = document.getElementById('modalTahun');

skBox.addEventListener('click', e=>{
  e.stopPropagation();
  dropdown.style.display = (dropdown.style.display==='block') ? 'none' : 'block';
});
document.addEventListener('click', e=>{
  if(!skBox.contains(e.target)) dropdown.style.display='none';
});
dropdown.addEventListener('click', e=>e.stopPropagation());

function openModal(){ modal.style.display='block'; }
function closeModal(){ modal.style.display='none'; }
window.onclick = function(event){ if(event.target == modal) closeModal(); }

tahunSelect.addEventListener('change', function(){
  const tahun = this.value;
  dropdown.style.display = 'none';
  if(!tahun) return;

  fetch('get_sk.php?tahun=' + tahun)
    .then(res => res.json())
    .then(skListTahun => {

      if(skListTahun.length === 0){
        alert('SK tahun ' + tahun + ' belum tersedia');
        return;
      }

      if(skListTahun.length === 1){
        window.open(skListTahun[0].file_url,'_blank');
      } else {
        listSK.innerHTML = '';
        modalTahun.textContent = tahun;

        skListTahun.forEach(sk=>{
          const li = document.createElement('li');
          li.innerHTML = `
            <a href="${sk.file_url}" target="_blank">
              ${sk.nama_sk}
            </a>`;
          listSK.appendChild(li);
        });

        openModal();
      }
    })
    .catch(err=>{
      console.error(err);
      alert('Gagal mengambil data SK');
    });
});

document.addEventListener('DOMContentLoaded', ()=>{ tampilkanGrafikProdi(); });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<?php include('../footer.php'); ?>
</body>
</html>
