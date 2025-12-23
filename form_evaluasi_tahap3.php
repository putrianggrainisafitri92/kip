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
<title>Tahap 3 — Kondisi Ekonomi</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    body {
        background-image: url('assets/bg-pelaporan.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
</style>
</head>

<body class="text-gray-900 flex flex-col relative">
<div class="absolute inset-0 bg-black/50 -z-10"></div>

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>
<body class="text-gray-900 flex flex-col relative">

 <div class="mt-40 flex justify-center">
  <div class="bg-white rounded-2xl shadow-lg px-6 py-4 inline-block">
    <div class="flex items-center gap-6">
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 flex items-center justify-center rounded-full
          bg-gradient-to-br from-purple-700 to-purple-900
          text-white font-bold ring-4 ring-purple-400/50">
          3
        </div>
        <span class="mt-2 text-sm font-semibold text-purple-800 text-center">
          Kondisi Ekonomi<br>&<br>Keluarga
        </span>
      </div>
    </div>
  </div>
</div>

<main class="flex justify-center mt-10 mb-6 px-4">


<div class="bg-white w-full max-w-3xl rounded-2xl shadow-lg p-8 text-purple-900">
<h1 class="text-2xl font-bold mb-6 text-center">Tahap 3 — Kondisi Ekonomi & Keluarga</h1>

<?php if(!empty($errors)): ?>
<div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
    <?php foreach($errors as $e) echo "<div>- ".htmlspecialchars($e)."</div>"; ?>
</div>
<?php endif; ?>

<form method="POST" class="space-y-5">

<div>
    <label class="font-semibold">Apakah keluarga Anda penerima bansos dari pemerintah? *</label>
    <select name="penerima_bansos" required class="mt-2 w-full border rounded p-3">
        <option value="">-- Pilih --</option>
        <option value="Ya" <?= $penerima_bansos_val=='Ya'?'selected':'' ?>>Ya</option>
        <option value="Tidak" <?= $penerima_bansos_val=='Tidak'?'selected':'' ?>>Tidak</option>
    </select>
</div>

<!-- Data Ayah -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label>Nama Ayah/Wali *</label><input name="nama_ayah_wali" value="<?= htmlspecialchars($nama_ayah_val) ?>" required class="w-full border rounded p-3"></div>
    <div><label>Status Ayah *</label>
        <select name="status_ayah" required class="w-full border rounded p-3">
            <option value="">-- Pilih --</option>
            <option value="Hidup" <?= $status_ayah_val=='Hidup'?'selected':'' ?>>Hidup</option>
            <option value="Meninggal" <?= $status_ayah_val=='Meninggal'?'selected':'' ?>>Meninggal</option>
            <option value="Lainnya" <?= $status_ayah_val=='Lainnya'?'selected':'' ?>>Yang lain</option>
        </select>
    </div>
    <div><label>Pekerjaan Ayah/Wali *</label><input name="pekerjaan_ayah" value="<?= htmlspecialchars($pekerjaan_ayah_val) ?>" required class="w-full border rounded p-3"></div>
    <div><label>Nama Instansi/Perusahaan Ayah</label><input name="instansi_ayah" value="<?= htmlspecialchars($instansi_ayah_val) ?>" class="w-full border rounded p-3"></div>
    <div><label>Penghasilan Ayah/Wali *</label>
        <select name="penghasilan_ayah" required class="w-full border rounded p-3">
            <option value="">-- Pilih Penghasilan --</option>
            <?php foreach($range_penghasilan as $key=>$label): ?>
                <option value="<?= $key ?>" <?= $penghasilan_ayah_val==$key?'selected':'' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Data Ibu -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label>Nama Ibu/Wali *</label><input name="nama_ibu_wali" value="<?= htmlspecialchars($nama_ibu_val) ?>" required class="w-full border rounded p-3"></div>
    <div><label>Status Ibu *</label>
        <select name="status_ibu" required class="w-full border rounded p-3">
            <option value="">-- Pilih --</option>
            <option value="Hidup" <?= $status_ibu_val=='Hidup'?'selected':'' ?>>Hidup</option>
            <option value="Meninggal" <?= $status_ibu_val=='Meninggal'?'selected':'' ?>>Meninggal</option>
            <option value="Lainnya" <?= $status_ibu_val=='Lainnya'?'selected':'' ?>>Yang lain</option>
        </select>
    </div>
    <div><label>Pekerjaan Ibu/Wali *</label><input name="pekerjaan_ibu" value="<?= htmlspecialchars($pekerjaan_ibu_val) ?>" required class="w-full border rounded p-3"></div>
    <div><label>Nama Instansi/Perusahaan Ibu</label><input name="instansi_ibu" value="<?= htmlspecialchars($instansi_ibu_val) ?>" class="w-full border rounded p-3"></div>
    <div><label>Penghasilan Ibu/Wali *</label>
        <select name="penghasilan_ibu" required class="w-full border rounded p-3">
            <option value="">-- Pilih Penghasilan --</option>
            <?php foreach($range_penghasilan as $key=>$label): ?>
                <option value="<?= $key ?>" <?= $penghasilan_ibu_val==$key?'selected':'' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Total & Tanggungan -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label>Jumlah Tanggungan Keluarga *</label>
        <input type="number" name="jumlah_tanggungan" value="<?= htmlspecialchars($jumlah_tanggungan_val) ?>" min="0" required class="w-full border rounded p-3">
    </div>
</div>

<!-- Tempat tinggal & HP & Transportasi -->
<div><label>Status Tempat Tinggal Keluarga *</label>
    <select name="status_tempat_tinggal" required class="w-full border rounded p-3">
        <option value="">-- Pilih Status --</option>
        <option value="Rumah Sendiri" <?= $status_rumah_val=='Rumah Sendiri'?'selected':'' ?>>Rumah Sendiri</option>
        <option value="Sewa" <?= $status_rumah_val=='Sewa'?'selected':'' ?>>Sewa</option>
        <option value="Yang lain" <?= $status_rumah_val=='Yang lain'?'selected':'' ?>>Yang lain</option>
    </select>
</div>

<div><label>Tuliskan Merk HP, Harga & Tahun Pembelian *</label>
<input name="info_hp" value="<?= htmlspecialchars($info_hp_val) ?>" required class="w-full border rounded p-3"></div>

<div><label>Alat Transportasi ke Kampus *</label>
<select name="alat_transportasi" required class="w-full border rounded p-3">
    <option value="">-- Pilih --</option>
    <option value="Kendaraan Pribadi" <?= $alat_transportasi_val=='Kendaraan Pribadi'?'selected':'' ?>>Kendaraan Pribadi</option>
    <option value="Kendaraan Umum" <?= $alat_transportasi_val=='Kendaraan Umum'?'selected':'' ?>>Kendaraan Umum</option>
    <option value="Jalan Kaki" <?= $alat_transportasi_val=='Jalan Kaki'?'selected':'' ?>>Jalan Kaki</option>
    <option value="Lainnya" <?= $alat_transportasi_val=='Lainnya'?'selected':'' ?>>Yang lain</option>
</select></div>

<div><label>Jenis, Merek, Tahun Kendaraan *</label>
<input name="detail_kendaraan" value="<?= htmlspecialchars($detail_kendaraan_val) ?>" class="w-full border rounded p-3"></div>

<!-- Nomor HP -->
<div>
<label>No Handphone *</label>
<input type="text" name="nomor_wa" value="<?= htmlspecialchars($nohp_val) ?>" required
pattern="(08[0-9]{8,11}|\+628[0-9]{8,11})"
title="Nomor HP harus dimulai 08 atau +628 dan terdiri dari 10–13 digit"
class="w-full border rounded p-3">
<?php if(isset($errors['nomor_wa'])): ?>
<div class="text-red-600 mt-1"><?= htmlspecialchars($errors['nomor_wa']) ?></div>
<?php endif; ?>
</div>

<div class="flex justify-between items-center mt-6">
    <a href="form_evaluasi_tahap2.php" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg">Kembali</a>
    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-700 to-purple-900 text-white font-semibold rounded-full shadow-md hover:scale-105 transition">
        Lanjut ke tahap 4 →
      </button>
</div>

</form>
</div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
