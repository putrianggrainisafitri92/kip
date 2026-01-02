<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != '11') {
    die("Akses ditolak!");
}

include "../koneksi.php";
include "sidebar.php";

/* ===============================
   AMBIL ID BERITA
================================ */
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("ID tidak valid");

/* ===============================
   AMBIL DATA BERITA
================================ */
$stmt = $koneksi->prepare("SELECT * FROM berita WHERE id_berita=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$berita = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$berita) die("Berita tidak ditemukan");

/* ===============================
   AMBIL GAMBAR
================================ */
$gambarList = [];
$res = $koneksi->query("SELECT * FROM berita_gambar WHERE id_berita=$id ORDER BY sortorder ASC");
while ($r = $res->fetch_assoc()) $gambarList[] = $r;

/* =================================================
   AKSI FORM (HAPUS GAMBAR / SIMPAN)
================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ====== HAPUS GAMBAR ====== */
    if ($_POST['aksi'] === 'hapus_gambar') {

        $gid = intval($_POST['hapus_gambar_id']);

        $q = $koneksi->query("SELECT file FROM berita_gambar WHERE id_gambar=$gid")->fetch_assoc();
        if ($q && $q['file']) {
            $path = "../uploads/berita/" . $q['file'];
            if (file_exists($path)) unlink($path);
        }

        $koneksi->query("UPDATE berita_gambar SET file=NULL WHERE id_gambar=$gid");

        header("Location: edit_berita.php?id=$id");
        exit;
    }

    /* ====== SIMPAN BERITA ====== */
    if ($_POST['aksi'] === 'simpan') {

        /* Judul */
        $judul = trim($_POST['judul']);
        $tgl_kegiatan = $_POST['tanggal_kegiatan'];
        $stmt = $koneksi->prepare(
        "UPDATE berita 
        SET judul = ?, tanggal_kegiatan = ?, status = 'pending' 
        WHERE id_berita = ?"
        );
        $stmt->bind_param("ssi", $judul, $tgl_kegiatan, $id);
        $stmt->execute();
        $stmt->close();

        /* Caption lama */
        if (!empty($_POST['old_caption'])) {
            foreach ($_POST['old_caption'] as $gid => $cap) {
                $stmt = $koneksi->prepare("UPDATE berita_gambar SET caption=? WHERE id_gambar=?");
                $stmt->bind_param("si", $cap, $gid);
                $stmt->execute();
                $stmt->close();
            }
        }

        /* Replace gambar lama */
        if (!empty($_FILES['replace_image'])) {
            $dir = "../uploads/berita/";
            foreach ($_FILES['replace_image']['name'] as $gid => $name) {

                if (!$name) continue;

                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg','jpeg','png','webp'])) continue;

                $old = $koneksi->query("SELECT file FROM berita_gambar WHERE id_gambar=$gid")->fetch_assoc();
                if ($old && $old['file']) {
                    $oldPath = $dir.$old['file'];
                    if (file_exists($oldPath)) unlink($oldPath);
                }

                $new = time()."_".rand(100,999).".".$ext;
                if (move_uploaded_file($_FILES['replace_image']['tmp_name'][$gid], $dir.$new)) {
                    $stmt = $koneksi->prepare("UPDATE berita_gambar SET file=? WHERE id_gambar=?");
                    $stmt->bind_param("si", $new, $gid);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        /* Upload gambar baru */
        if (!empty($_FILES['gambar_files']['name'][0])) {

            $dir = "../uploads/berita/";
            $m = $koneksi->query("SELECT COALESCE(MAX(sortorder),0) AS m FROM berita_gambar WHERE id_berita=$id")->fetch_assoc();
            $order = $m['m'] + 1;

            foreach ($_FILES['gambar_files']['name'] as $i => $name) {

                if ($_FILES['gambar_files']['error'][$i] !== 0) continue;

                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg','jpeg','png','webp'])) continue;

                $file = time()."_".rand(100,999).".".$ext;
                if (move_uploaded_file($_FILES['gambar_files']['tmp_name'][$i], $dir.$file)) {

                    $cap = $_POST['captions'][$i] ?? null;

                    $stmt = $koneksi->prepare(
                        "INSERT INTO berita_gambar (id_berita,file,caption,sortorder)
                         VALUES (?,?,?,?)"
                    );
                    $stmt->bind_param("issi", $id, $file, $cap, $order++);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        echo "<script>alert('Berhasil disimpan');location='berita_list.php'</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Berita</title>
    <style>
        :root {
            --primary-purple: #6a11cb;
            --secondary-purple: #2575fc;
            --deep-purple: #4e0a8a;
            --glass-purple: rgba(78, 10, 138, 0.9);
        }

        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-pelaporan.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .content {
            margin-left: 230px;
            padding: 40px 20px;
            transition: all 0.3s ease;
        }

        .form-card {
            width: 100%;
            max-width: 900px;
            margin: auto;
            padding: 40px;
            border-radius: 24px;
            background: var(--glass-purple);
            backdrop-filter: blur(12px);
            color: white;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        label, h3 {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 20px;
            font-size: 15px;
            color: #f1e4ff;
        }

        input[type=text], input[type=date], input[type=file], textarea {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            outline: none;
            background: rgba(255,255,255,0.2);
            border-color: #ba68ff;
            box-shadow: 0 0 15px rgba(186, 104, 255, 0.3);
        }

        /* ===== GRID GAMBAR ===== */
        .grid {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 18px;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.1);
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
        }

        .preview-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid rgba(255,255,255,0.2);
        }

        /* ===== BUTTONS ===== */
        button {
            padding: 12px 18px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-del {
            background: #ff4d4d;
            color: white;
            margin-top: 10px;
        }
        .btn-del:hover { background: #ff1a1a; transform: scale(1.02); }

        .btn-add {
            background: rgba(255,255,255,0.1);
            border: 2px dashed rgba(255,255,255,0.3);
            color: white;
            padding: 18px;
            width: 100%;
            border-radius: 16px;
            margin-top: 15px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-add:hover { 
            background: rgba(255,255,255,0.2); 
            border-color: rgba(255,255,255,0.5);
        }

        .btn-save {
            background: linear-gradient(135deg, #ba68ff, #7b35d4);
            color: white;
            width: 100%;
            padding: 15px;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(123, 53, 212, 0.3);
        }
        .btn-save:hover { filter: brightness(1.1); transform: translateY(-2px); box-shadow: 0 15px 25px rgba(123, 53, 212, 0.4); }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            margin-top: 15px;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        .hint {
            font-size: 12px;
            color: #ccc;
            margin-top: 5px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 80px 15px 40px 15px;
            }
        }
    </style>
</head>

<body>
<div class="content">
<div class="form-card">

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="aksi" id="aksi">
<input type="hidden" name="hapus_gambar_id" id="hapus_gambar_id">

<label>Judul</label>
<input type="text" name="judul" value="<?= htmlspecialchars($berita['judul']) ?>">

<label>Tanggal Kegiatan</label>
<input type="date" name="tanggal_kegiatan" value="<?= $berita['tanggal_kegiatan'] ?>" style="width: 100%; padding: 10px; border-radius: 12px; border: none; margin-top: 5px; margin-bottom: 15px; font-size: 1rem;">

<h3>Gambar</h3>

<?php foreach ($gambarList as $g): ?>
<div class="grid">
<?php if ($g['file'] && file_exists("../uploads/berita/".$g['file'])): ?>
<img src="../uploads/berita/<?= $g['file'] ?>" class="preview-img">
<?php else: ?>
<div>(Gambar sudah dihapus)</div>
<?php endif; ?>

<textarea name="old_caption[<?= $g['id_gambar'] ?>]" placeholder="Caption..."><?= htmlspecialchars($g['caption']) ?>
</textarea>
<div style="font-size: 0.85rem; color: #ddd; margin-top: 3px; align-self: flex-start;">
    Geser pojok untuk memperbesar kotak teks
</div>



<input type="file" name="replace_image[<?= $g['id_gambar'] ?>]" accept="image/*">

<button type="button" class="btn-del"
onclick="hapusGambar(<?= $g['id_gambar'] ?>, this)">Hapus Gambar</button>
</div>
<?php endforeach; ?>

<h3>Tambah Gambar</h3>
<div id="rows">
<div class="grid">
<input type="file" name="gambar_files[]" accept="image/*">
<textarea name="captions[]" placeholder="Caption..."></textarea>
</div>
</div>

<button type="button" class="btn-add" onclick="addRow()">
    <i class="fas fa-plus"></i> Tambah Slot Gambar
</button>

<button type="submit" class="btn-save" onclick="simpan()">
    <i class="fas fa-save"></i> Simpan Perubahan Berita
</button>

<a href="berita_list.php" class="btn-back">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
</a>
</form>

</div>
</div>

<script>
function hapusGambar(id, btn){
    if(!confirm('Hapus gambar ini?')) return;
    document.getElementById('hapus_gambar_id').value = id;
    document.getElementById('aksi').value = 'hapus_gambar';
    btn.closest('form').submit();
}
function simpan(){
    document.getElementById('aksi').value = 'simpan';
}
function addRow(){
    let d=document.createElement('div');
    d.className='grid';
    d.innerHTML=`<input type="file" name="gambar_files[]" accept="image/*">
                 <textarea name="captions[]" placeholder="Caption..."></textarea>`;
    document.getElementById('rows').appendChild(d);
}
</script>

</body>
</html>
