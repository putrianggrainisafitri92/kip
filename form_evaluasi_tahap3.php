<?php
session_start();
include 'koneksi.php';

// --- Cek login NPM ---
if (!isset($_SESSION['npm'])) {
    header("Location: form_evaluasi_validasi.php");
    exit();
}

// Ambil data mahasiswa
$npm = $_SESSION['npm'];
$stmt = $koneksi->prepare("SELECT * FROM mahasiswa_kip WHERE npm = ? LIMIT 1");
$stmt->bind_param("s", $npm);
$stmt->execute();
$res = $stmt->get_result();
$mhs = $res->fetch_assoc();
if (!$mhs) die("Data mahasiswa tidak ditemukan untuk NPM $npm");

$id_mhs = $mhs['id_mahasiswa_kip'];

// --- Ambil data keluarga ---
$qKeluarga = mysqli_query($koneksi, "SELECT * FROM keluarga WHERE id_mahasiswa_kip = $id_mhs LIMIT 1");
$keluarga = mysqli_fetch_assoc($qKeluarga) ?: [
    'nm_ayah'=>'','status_ayah'=>'','pkerjan_ayah'=>'','instansi_ayah'=>'','penghasilan_ayah'=>0,
    'nm_ibu'=>'','status_ibu'=>'','pkerjan_ibu'=>'','instansi_ibu'=>'','penghasilan_ibu'=>0,
    'jumlah_tgngn'=>0
];

// --- Ambil data transportasi ---
$qTransportasi = mysqli_query($koneksi, "SELECT * FROM transportasi WHERE id_mahasiswa_kip = $id_mhs LIMIT 1");
$transportasi = mysqli_fetch_assoc($qTransportasi) ?: ['alat_transportasi'=>'','detail_transportasi'=>''];

// --- Fungsi prefill ---
function old($name, $default=''){
    return $_POST[$name] ?? ($_SESSION['tahap3'][$name] ?? $default);
}

// --- Range penghasilan ---
$range_penghasilan = [
    "<=700000" => "<= Rp. 700.000",
    "700000-1000000" => "Rp. 700.000-Rp. 1.000.000",
    "1000000-1500000" => "Rp. 1.000.000-Rp. 1.500.000",
    "1500000-2000000" => "Rp. 1.500.000-Rp. 2.000.000",
    "2000000-2500000" => "Rp. 2.000.000-Rp. 2.500.000",
    "2500000-3000000" => "Rp. 2.500.000-Rp. 3.000.000",
    "3000000-3500000" => "Rp. 3.000.000-Rp. 3.500.000",
    "3500000-4000000" => "Rp. 3.500.000-Rp. 4.000.000",
    ">=4000000" => ">= Rp. 4.000.000"
];

// --- Fungsi mapping angka ke range ---
function getPenghasilanRange($angka){
    if($angka <= 700000) return "<=700000";
    if($angka <= 1000000) return "700000-1000000";
    if($angka <= 1500000) return "1000000-1500000";
    if($angka <= 2000000) return "1500000-2000000";
    if($angka <= 2500000) return "2000000-2500000";
    if($angka <= 3000000) return "2500000-3000000";
    if($angka <= 3500000) return "3000000-3500000";
    if($angka <= 4000000) return "3500000-4000000";
    return ">=4000000";
}

// --- Prefill variabel ---
$penerima_bansos_val = old('penerima_bansos');
$info_hp_val = old('info_hp');
$nohp_val = old('nomor_wa');

$nama_ayah_val = old('nama_ayah_wali', $keluarga['nm_ayah']);
$status_ayah_val = old('status_ayah', $keluarga['status_ayah']);
$pekerjaan_ayah_val = old('pekerjaan_ayah', $keluarga['pkerjan_ayah']);
$instansi_ayah_val = old('instansi_ayah', $keluarga['instansi_ayah']);
$penghasilan_ayah_val = old('penghasilan_ayah', getPenghasilanRange($keluarga['penghasilan_ayah']));

$nama_ibu_val = old('nama_ibu_wali', $keluarga['nm_ibu']);
$status_ibu_val = old('status_ibu', $keluarga['status_ibu']);
$pekerjaan_ibu_val = old('pekerjaan_ibu', $keluarga['pkerjan_ibu']);
$instansi_ibu_val = old('instansi_ibu', $keluarga['instansi_ibu']);
$penghasilan_ibu_val = old('penghasilan_ibu', getPenghasilanRange($keluarga['penghasilan_ibu']));

$jumlah_tanggungan_val = old('jumlah_tanggungan', $keluarga['jumlah_tgngn']);
$status_rumah_val = old('status_tempat_tinggal');
$alat_transportasi_val = old('alat_transportasi', $transportasi['alat_transportasi']);
$detail_kendaraan_val = old('detail_kendaraan', $transportasi['detail_transportasi']);

$errors = [];

// --- Proses submit ---
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Validasi nomor HP
    $nohp_clean = preg_replace('/[^0-9+]/','',$_POST['nomor_wa']);
    if(!preg_match('/^(08[0-9]{8,11}|\+628[0-9]{8,11})$/',$nohp_clean)){
        $errors['nomor_wa'] = "Format nomor WA salah. Gunakan format 08xxxxxxxxxx atau +628xxxxxxxxx";
    }

    if(empty($errors)){

    // =============================
    // SIMPAN DATA KELUARGA
    // =============================
    mysqli_query($koneksi, "
        INSERT INTO keluarga (
            id_mahasiswa_kip,
            nm_ayah, status_ayah, pkerjan_ayah, instansi_ayah, penghasilan_ayah,
            nm_ibu, status_ibu, pkerjan_ibu, instansi_ibu, penghasilan_ibu,
            jumlah_tgngn
        ) VALUES (
            '$id_mhs',
            '{$_POST['nama_ayah_wali']}',
            '{$_POST['status_ayah']}',
            '{$_POST['pekerjaan_ayah']}',
            '{$_POST['instansi_ayah']}',
            '{$_POST['penghasilan_ayah']}',
            '{$_POST['nama_ibu_wali']}',
            '{$_POST['status_ibu']}',
            '{$_POST['pekerjaan_ibu']}',
            '{$_POST['instansi_ibu']}',
            '{$_POST['penghasilan_ibu']}',
            '{$_POST['jumlah_tanggungan']}'
        )
        ON DUPLICATE KEY UPDATE
            nm_ayah=VALUES(nm_ayah),
            status_ayah=VALUES(status_ayah),
            pkerjan_ayah=VALUES(pkerjan_ayah),
            instansi_ayah=VALUES(instansi_ayah),
            penghasilan_ayah=VALUES(penghasilan_ayah),
            nm_ibu=VALUES(nm_ibu),
            status_ibu=VALUES(status_ibu),
            pkerjan_ibu=VALUES(pkerjan_ibu),
            instansi_ibu=VALUES(instansi_ibu),
            penghasilan_ibu=VALUES(penghasilan_ibu),
            jumlah_tgngn=VALUES(jumlah_tgngn)
    ");
            mysqli_query($koneksi, "
        INSERT INTO transportasi (
            id_mahasiswa_kip, alat_transportasi, detail_transportasi
        ) VALUES (
            '$id_mhs',
            '{$_POST['alat_transportasi']}',
            '{$_POST['detail_kendaraan']}'
        )
        ON DUPLICATE KEY UPDATE
            alat_transportasi=VALUES(alat_transportasi),
            detail_transportasi=VALUES(detail_transportasi)
    ");
    }
    if(empty($errors)){
        $_SESSION['tahap3'] = $_POST;
        header("Location: form_evaluasi_tahap4.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Tahap 3 — Kondisi Ekonomi</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-image: url('assets/bg-pelaporan.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* Main Layout */
    .main-content {
      transition: margin-left 0.3s ease;
      padding-top: 90px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-bottom: 50px;
    }
    .main-content.shifted {
      margin-left: 260px;
    }
    
    @media (max-width: 768px) {
      .main-content.shifted { margin-left: 0; }
      .main-content { padding-top: 80px; padding-left: 1rem; padding-right: 1rem; }
    }
</style>
</head>

<body class="text-gray-900 relative">

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>

  <div class="main-content" id="main-content">

      <!-- STEP INDICATOR -->
      <div class="mb-8 w-full max-w-3xl flex justify-center">
        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-lg px-8 py-4 inline-block border border-purple-100">
            <div class="flex flex-col items-center">
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-700 to-purple-900 text-white font-bold ring-4 ring-purple-400/50 text-lg shadow">3</div>
              <span class="mt-2 text-sm font-bold text-purple-800 text-center uppercase tracking-wide">Kondisi Ekonomi<br>& Keluarga</span>
            </div>
        </div>
      </div>

     <!-- FORM CONTENT -->
     <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-8 md:p-10 relative z-10 border border-purple-100">
      <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 text-transparent bg-clip-text bg-gradient-to-r from-purple-800 to-purple-600">
        Tahap 3 — Kondisi Ekonomi
      </h2>

      <?php if(!empty($errors)): ?>
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
            <div class="font-bold mb-1"><i class="bi bi-exclamation-triangle-fill mr-2"></i>Terjadi Kesalahan:</div>
            <?php foreach($errors as $e) echo "<div class='ml-6'>- ".htmlspecialchars($e)."</div>"; ?>
        </div>
      <?php endif; ?>

      <form method="POST" class="space-y-8">
        
        <!-- BANSOS -->
        <div class="bg-purple-50 p-6 rounded-xl border border-purple-100">
           <label class="font-bold text-purple-900 block mb-2"><i class="bi bi-cash-coin mr-2"></i>Apakah keluarga Anda penerima bansos dari pemerintah? <span class="text-red-500">*</span></label>
            <select name="penerima_bansos" required class="w-full border border-purple-200 rounded-lg p-3 focus:ring-2 focus:ring-purple-400 outline-none bg-white">
                <option value="">-- Pilih --</option>
                <option value="Ya" <?= $penerima_bansos_val=='Ya'?'selected':'' ?>>Ya</option>
                <option value="Tidak" <?= $penerima_bansos_val=='Tidak'?'selected':'' ?>>Tidak</option>
            </select>
        </div>

        <!-- DATA ORANG TUA -->
        <div class="space-y-6">
            <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Data Orang Tua / Wali</h3>
            
            <!-- AYAH -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h4 class="font-bold text-gray-700 mb-4 uppercase text-sm tracking-wider"><i class="bi bi-person-fill mr-1"></i> Data Ayah</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-sm">Nama Ayah/Wali <span class="text-red-500">*</span></label>
                        <input name="nama_ayah_wali" value="<?= htmlspecialchars($nama_ayah_val) ?>" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-purple-400 outline-none">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Status Ayah <span class="text-red-500">*</span></label>
                        <select name="status_ayah" required class="w-full border rounded-lg p-3 mt-1 bg-white focus:ring-2 focus:ring-purple-400 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="Hidup" <?= $status_ayah_val=='Hidup'?'selected':'' ?>>Hidup</option>
                            <option value="Meninggal" <?= $status_ayah_val=='Meninggal'?'selected':'' ?>>Meninggal</option>
                            <option value="Lainnya" <?= $status_ayah_val=='Lainnya'?'selected':'' ?>>Yang lain</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Pekerjaan Ayah/Wali <span class="text-red-500">*</span></label>
                        <input name="pekerjaan_ayah" value="<?= htmlspecialchars($pekerjaan_ayah_val) ?>" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-purple-400 outline-none">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Nama Instansi Ayah</label>
                        <input name="instansi_ayah" value="<?= htmlspecialchars($instansi_ayah_val) ?>" class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-purple-400 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold text-sm">Penghasilan Ayah/Wali <span class="text-red-500">*</span></label>
                        <select name="penghasilan_ayah" required class="w-full border rounded-lg p-3 mt-1 bg-white focus:ring-2 focus:ring-purple-400 outline-none">
                            <option value="">-- Pilih Penghasilan --</option>
                            <?php foreach($range_penghasilan as $key=>$label): ?>
                                <option value="<?= $key ?>" <?= $penghasilan_ayah_val==$key?'selected':'' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- IBU -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h4 class="font-bold text-gray-700 mb-4 uppercase text-sm tracking-wider"><i class="bi bi-person-fill mr-1"></i> Data Ibu</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-sm">Nama Ibu/Wali <span class="text-red-500">*</span></label>
                        <input name="nama_ibu_wali" value="<?= htmlspecialchars($nama_ibu_val) ?>" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-purple-400 outline-none">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Status Ibu <span class="text-red-500">*</span></label>
                        <select name="status_ibu" required class="w-full border rounded-lg p-3 mt-1 bg-white focus:ring-2 focus:ring-purple-400 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="Hidup" <?= $status_ibu_val=='Hidup'?'selected':'' ?>>Hidup</option>
                            <option value="Meninggal" <?= $status_ibu_val=='Meninggal'?'selected':'' ?>>Meninggal</option>
                            <option value="Lainnya" <?= $status_ibu_val=='Lainnya'?'selected':'' ?>>Yang lain</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Pekerjaan Ibu/Wali <span class="text-red-500">*</span></label>
                        <input name="pekerjaan_ibu" value="<?= htmlspecialchars($pekerjaan_ibu_val) ?>" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-purple-400 outline-none">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Nama Instansi Ibu</label>
                        <input name="instansi_ibu" value="<?= htmlspecialchars($instansi_ibu_val) ?>" class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-purple-400 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold text-sm">Penghasilan Ibu/Wali <span class="text-red-500">*</span></label>
                        <select name="penghasilan_ibu" required class="w-full border rounded-lg p-3 mt-1 bg-white focus:ring-2 focus:ring-purple-400 outline-none">
                            <option value="">-- Pilih Penghasilan --</option>
                            <?php foreach($range_penghasilan as $key=>$label): ?>
                                <option value="<?= $key ?>" <?= $penghasilan_ibu_val==$key?'selected':'' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- ASET & LAINNYA -->
        <div class="bg-white p-6 rounded-xl border-2 border-dashed border-gray-300">
             <h3 class="text-lg font-bold text-gray-800 mb-4">Aset & Informasi Lainnya</h3>
             <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="font-semibold block mb-1">Jumlah Tanggungan Keluarga <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_tanggungan" value="<?= htmlspecialchars($jumlah_tanggungan_val) ?>" min="0" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-purple-400 outline-none">
                </div>
                
                <div>
                    <label class="font-semibold block mb-1">Status Tempat Tinggal Keluarga <span class="text-red-500">*</span></label>
                    <select name="status_tempat_tinggal" required class="w-full border rounded-lg p-3 bg-white focus:ring-2 focus:ring-purple-400 outline-none">
                        <option value="">-- Pilih Status --</option>
                        <option value="Rumah Sendiri" <?= $status_rumah_val=='Rumah Sendiri'?'selected':'' ?>>Rumah Sendiri</option>
                        <option value="Sewa" <?= $status_rumah_val=='Sewa'?'selected':'' ?>>Sewa</option>
                        <option value="Yang lain" <?= $status_rumah_val=='Yang lain'?'selected':'' ?>>Yang lain</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold block mb-1">Tuliskan Merk HP, Harga & Tahun Pembelian <span class="text-red-500">*</span></label>
                    <input name="info_hp" value="<?= htmlspecialchars($info_hp_val) ?>" placeholder="Contoh: Samsung A50, Rp 3.000.000, 2021" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-purple-400 outline-none">
                </div>

                <div>
                    <label class="font-semibold block mb-1">Alat Transportasi ke Kampus <span class="text-red-500">*</span></label>
                    <select name="alat_transportasi" required class="w-full border rounded-lg p-3 bg-white focus:ring-2 focus:ring-purple-400 outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="Kendaraan Pribadi" <?= $alat_transportasi_val=='Kendaraan Pribadi'?'selected':'' ?>>Kendaraan Pribadi</option>
                        <option value="Kendaraan Umum" <?= $alat_transportasi_val=='Kendaraan Umum'?'selected':'' ?>>Kendaraan Umum</option>
                        <option value="Jalan Kaki" <?= $alat_transportasi_val=='Jalan Kaki'?'selected':'' ?>>Jalan Kaki</option>
                        <option value="Lainnya" <?= $alat_transportasi_val=='Lainnya'?'selected':'' ?>>Yang lain</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold block mb-1">Jenis, Merek, Tahun Kendaraan <span class="text-red-500">*</span></label>
                    <input name="detail_kendaraan" value="<?= htmlspecialchars($detail_kendaraan_val) ?>" placeholder="Contoh: Honda Beat, 2019" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-purple-400 outline-none">
                </div>

                <div>
                    <label class="font-semibold block mb-1">No Handphone (WhatsApp) <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_wa" value="<?= htmlspecialchars($nohp_val) ?>" required
                    pattern="(08[0-9]{8,11}|\+628[0-9]{8,11})"
                    placeholder="08xxxxxxxxxx"
                    class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-purple-400 outline-none">
                    <?php if(isset($errors['nomor_wa'])): ?>
                    <div class="text-red-600 mt-1 text-sm"><i class="bi bi-x-circle mr-1"></i><?= htmlspecialchars($errors['nomor_wa']) ?></div>
                    <?php endif; ?>
                </div>
             </div>
        </div>

        <!-- TOMBOL NAVIGASI -->
        <div class="flex flex-col-reverse sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-100">
            <a href="form_evaluasi_tahap2.php" class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition text-center">
                <i class="bi bi-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-purple-700 to-purple-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-purple-500/30 hover:scale-[1.02] transition duration-300 flex items-center justify-center gap-2">
                Lanjut Tahap 4 <i class="bi bi-arrow-right"></i>
            </button>
        </div>

      </form>
    </div>

  </div> <!-- End Main Content -->

<!-- SCRIPT -->
<script>
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            if (sidebar) sidebar.classList.toggle('active');
            if (mainContent) mainContent.classList.toggle('shifted');
        });
    }
</script>

<?php include 'footer.php'; ?>

</body>
</html>
