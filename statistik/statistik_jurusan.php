<?php
include('../koneksi.php');

// =========================
// Total mahasiswa approved
// =========================
$totalQuery = $koneksi->query("SELECT COUNT(*) AS total FROM mahasiswa_kip WHERE status='approved'");
$totalMahasiswa = $totalQuery->fetch_assoc()['total'];

// Ambil daftar jurusan approved
$jurusanStmt = $koneksi->prepare("SELECT DISTINCT jurusan FROM mahasiswa_kip WHERE status='approved' ORDER BY jurusan ASC");
$jurusanStmt->execute();
$jurusanResult = $jurusanStmt->get_result();
$jurusanList = [];
while($row = $jurusanResult->fetch_assoc()){
    $jurusanList[] = $row['jurusan'];
}

// Ambil daftar tahun SK approved
$skStmt = $koneksi->prepare("SELECT DISTINCT tahun FROM sk_kipk WHERE status='approved' ORDER BY tahun ASC");
$skStmt->execute();
$skResult = $skStmt->get_result();
$skTahunList = [];
while($row = $skResult->fetch_assoc()){
    $skTahunList[] = $row['tahun'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistik Perjurusan - KIP-Kuliah POLINELA</title>
<!-- TAILWIND WAJIB UNTUK FOOTER -->
<script src="https://cdn.tailwindcss.com"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
/* ========================
   Body & Layout
======================== */
body {
    background: url("../assets/bgpolinela.jpeg") no-repeat center center;
    background-size: cover;  
    font-family: 'Poppins', sans-serif;
    color: #333;
    min-height: 100vh;        
}

.main-content {
    margin-left: 250px;
    margin-top: 70px;
    padding: 20px;
    transition: 0.3s;
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
.select-box {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;       /* Agar padding tdk bikin lebar berlebih */
    border-radius: 12px;          
    padding: 10px 12px;          
    border: 2px solid #3d3d4582;   
    background-color: #fff;       
    font-weight: 600;             
    cursor: pointer;              
    appearance: none;             
    -webkit-appearance: none;
    -moz-appearance: none;
}

.select-box:hover {
    border-color: #5f54d1;        
}
.select-box:focus {
    outline: none;
    border-color: #7a6ff0;        
    box-shadow: 0 0 5px rgba(122,111,240,0.5);
}


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

/* ========================
   Hasil / Box Tambahan
======================== */
#hasil {
    margin-top: 30px;
}

/* ========================
   Modal
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
    background: #f8f6ff;
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
        margin-top: 80px;
        padding: 15px;
    }

    .modal-content {
        width: 90%;
    }
    
    .container-statistik {
        width: 95%;
        padding: 25px;
    }
}

@media (max-width: 768px) {
    .main-content {
        margin-top: 75px;
        padding: 10px;
    }
    
    .container-statistik {
        padding: 20px;
        border-radius: 12px;
    }
    
    h2 {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }
    
    .chart-container {
        height: 220px;
        width: 100%;
    }
    
    .row.text-center.mt-4 {
        flex-direction: column;
    }
    
    .col-md-4 {
        width: 100%;
        margin-bottom: 15px;
    }
    
    .info-box {
        padding: 20px;
    }
    
    .select-box, #prodiSelect {
        font-size: 14px;
        padding: 8px 10px;
    }
}

@media (max-width: 480px) {
    .main-content {
        padding: 8px;
        margin-top: 70px;
    }
    
    .container-statistik {
        padding: 15px;
        border-radius: 10px;
    }
    
    h2 {
        font-size: 1.25rem;
    }
    
    .chart-container {
        height: 180px;
    }
    
    .info-box {
        padding: 15px;
        font-size: 14px;
    }
    
    .dropdown-tahun {
        width: 95%;
    }
}

#prodiSelect {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 2px solid #3d3d4582;
    background-color: #fff;
    font-weight: 600;
    white-space: normal;
    word-wrap: break-word;
}

</style>
</head>
<body>

<?php include('../sidebar.php'); ?>

<div class="main-content">
  <div class="container-statistik">
    <h2>Statistik Perjurusan</h2>

    <!-- Dropdown Jurusan -->
    <div class="text-center mb-4">
      <label for="jurusanSelect" class="fw-bold me-2">Pilih Jurusan:</label>
      <select id="jurusanSelect" class="select-box" onchange="tampilkanGrafikJurusan(this.value)">
        <option value="">-- Pilih Jurusan --</option>
        <?php foreach ($jurusanList as $j): ?>
          <option value="<?= htmlspecialchars($j) ?>"><?= htmlspecialchars($j) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Grafik -->
    <div class="chart-container mb-4">
      <canvas id="grafikJurusan"></canvas>
    </div>

    <!-- 3 Box Bawah -->
    <div class="row text-center mt-4">
      <div class="col-md-4">
        <div class="info-box" onclick="tampilkanTotal()">
          Total Mahasiswa<br>
          <span class="fs-4 text-primary"><?= $totalMahasiswa; ?></span>
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box">
          <label>Nama Prodi</label><br>
          <select id="prodiSelect" onchange="tampilkanProdi(this.value)">
            <option value="">-- Pilih Prodi --</option>
            
          </select>
        </div>
      </div>

      <div class="col-md-4 position-relative">
        <div class="info-box" id="skBox">
          SK KIP-K<br>
          <span class="text-muted">Klik untuk pilih tahun</span>
          <div class="dropdown-tahun" id="dropdownSK">
            <label for="tahunSelect" class="fw-semibold mb-2 d-block">Pilih Tahun:</label>
            <select id="tahunSelect" class="form-select">
              <option value="">-- Pilih Tahun --</option>
              <?php foreach($skTahunList as $tahun): ?>
                <option value="<?= $tahun ?>"><?= $tahun ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div id="hasil"></div>
  </div>
</div>

<!-- Modal SK -->
<div id="modalSK" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h4>Daftar SK</h4>
    <ul id="listSK" style="list-style:none; padding-left:0;"></ul>
  </div>
</div>

<script>
let chartJurusan;

function createChartIfNotExists(ctx, labels, values, labelText) {
  const config = {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: labelText,
        data: values,
        borderColor: '#2b2b9f',
        borderWidth: 3,
        tension: 0.3,
        pointBackgroundColor: '#2b2b9f',
        pointRadius: 4,
        fill: false
      }]
    },
    options: {
      responsive: true,
      animation: {
        duration: 900,
        easing: 'easeOutQuart'
      },
      transitions: {
        show: {
          animations: {
            x: { from: 0 },
            y: { from: 0 }
          }
        },
        active: {
          animations: {
            x: { duration: 600 },
            y: { duration: 600 }
          }
        }
      },
      scales: {
        y: { beginAtZero: true }
      },
      plugins: {
        legend: { display: true, position: 'bottom' }
      }
    }
  };

  if (!chartJurusan) {
    chartJurusan = new Chart(ctx, config);
  } else {
    // update existing chart's dataset and labels (do not destroy)
    chartJurusan.data.labels = labels;
    // ensure dataset exists
    if (!chartJurusan.data.datasets[0]) chartJurusan.data.datasets[0] = {};
    chartJurusan.data.datasets[0].label = labelText;
    chartJurusan.data.datasets[0].data = values;
    chartJurusan.data.datasets[0].borderColor = '#2b2b9f';
    chartJurusan.data.datasets[0].borderWidth = 3;
    chartJurusan.data.datasets[0].tension = 0.3;
    chartJurusan.data.datasets[0].pointBackgroundColor = '#2b2b9f';
    chartJurusan.update({ duration: 900, easing: 'easeOutQuart' });
  }
}

function tampilkanGrafikJurusan(jurusan = "") {
  let url = 'grafik_jurusan.php?status=approved';
  if (jurusan) url += '&jurusan=' + encodeURIComponent(jurusan);

  fetch(url)
    .then(res => res.json())
    .then(data => {
      if (data.error) { alert(data.message); return; }

      const labels = [];
      const values = [];
      data.labels.forEach((lbl, i) => {
        if (data.data[i] > 0) { labels.push(lbl); values.push(data.data[i]); }
      });

      // Update prodi dropdown
      const prodiSelect = document.getElementById('prodiSelect');
      prodiSelect.innerHTML = '<option value="">-- Pilih Prodi --</option>';
      if (data.prodi) {
        data.prodi.forEach(p => {
          const opt = document.createElement('option');
          opt.value = p;
          opt.textContent = p;
          prodiSelect.appendChild(opt);
        });
      }

      // Render or update Chart (no destroy)
      const ctx = document.getElementById('grafikJurusan');
      const labelText = jurusan ? 'Mahasiswa ' + jurusan : 'Total Mahasiswa Semua Jurusan';
      createChartIfNotExists(ctx, labels, values, labelText);
    })
    .catch(err => console.error('Gagal memuat grafik:', err));
}

function tampilkanProdi(prodi) {
  if (!prodi) return;
  fetch('get_grafik_prodi.php?prodi=' + encodeURIComponent(prodi) + '&status=approved')
    .then(res => res.json())
    .then(data => {
      const labels = [], values = [];
      data.labels.forEach((lbl, i) => {
        if (data.data[i] > 0) { labels.push(lbl); values.push(data.data[i]); }
      });

      const ctx = document.getElementById('grafikJurusan');
      const labelText = 'Mahasiswa Prodi ' + data.prodi;
      createChartIfNotExists(ctx, labels, values, labelText);
    })
    .catch(err => console.error('Error grafik prodi:', err));
}



function tampilkanTotal(){
  fetch('tampilkan_total.php?status=approved')
    .then(res=>res.text())
    .then(data=>document.getElementById('hasil').innerHTML=data);
}

// SK KIP-K
const skBox = document.getElementById('skBox');
const dropdown = document.getElementById('dropdownSK');
const tahunSelect = document.getElementById('tahunSelect');
const modal = document.getElementById('modalSK');
const listSK = document.getElementById('listSK');

skBox.addEventListener('click', e=>{ e.stopPropagation(); dropdown.style.display=(dropdown.style.display==='block')?'none':'block'; });
document.addEventListener('click', e=>{ if(!skBox.contains(e.target)) dropdown.style.display='none'; });
dropdown.addEventListener('click', e=>e.stopPropagation());

function openModal(){ modal.style.display='block'; }
function closeModal(){ modal.style.display='none'; }
window.onclick=function(e){ if(e.target==modal) closeModal(); }

tahunSelect.addEventListener('change', function(){
  const tahun=this.value;
  if(!tahun) return;
  fetch('get_sk.php?tahun='+encodeURIComponent(tahun)+'&status=approved')
    .then(res=>res.json())
    .then(data=>{
      if(!data || data.length===0) { alert('SK untuk tahun '+tahun+' tidak ditemukan.'); return; }
      if(data.length===1) { window.open(data[0].file_url,'_blank'); }
      else {
        listSK.innerHTML='';
        data.forEach(sk=>{
          const li=document.createElement('li');
          li.innerHTML=`<a href="${sk.file_url}" target="_blank">${sk.nama_sk}</a>`;
          listSK.appendChild(li);
        });
        openModal();
      }
      dropdown.style.display='none';
    })
    .catch(err=>console.error('Gagal fetch SK:',err));
});

document.addEventListener('DOMContentLoaded', ()=> tampilkanGrafikJurusan());
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>


<?php include '../footer.php'; ?>


</html> 