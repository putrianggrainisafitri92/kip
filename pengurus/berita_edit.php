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
        $stmt = $koneksi->prepare(
        "UPDATE berita 
        SET judul = ?, status = 'pending' 
        WHERE id_berita = ?"
        );
        $stmt->bind_param("si", $judul, $id);
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
/* ===== BODY ===== */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f2e6ff; /* lembut ungu muda */
    margin: 0;
    padding: 0;
}

/* ===== CONTENT CARD ===== */
.content {
    max-width: 900px;
    margin: 50px auto;
    padding: 30px;
    background: #5a2a83; /* ungu terong */
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    color: #fff;
}

/* ===== FORM CARD ===== */
.form-card {
    display: flex;
    flex-direction: column;
}

/* ===== LABELS ===== */
label, h3 {
    margin-top: 15px;
    font-weight: bold;
    color: #f2dfff;
}

/* ===== INPUT ===== */
input[type="text"], textarea {
    width: 100%;
    padding: 10px;
    border-radius: 12px;
    border: none;
    margin-top: 5px;
    margin-bottom: 15px;
    font-size: 1rem;
    resize: vertical;
}

/* input & textarea focus */
input[type="text"]:focus, textarea:focus {
    outline: none;
    box-shadow: 0 0 10px #d699ff;
    background: #fff0ff;
    color: #000;
}

/* ===== GRID GAMBAR ===== */
.grid {
    background: rgba(255,255,255,0.1);
    padding: 15px;
    border-radius: 15px;
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.2s;
}

.grid:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

/* ===== GAMBAR PREVIEW ===== */
.preview-img {
    width: 100%;
    max-height: 220px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 10px;
}

/* ===== BUTTON ===== */
button {
    padding: 10px 20px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s;
}

/* tombol hapus */
.btn-del {
    background: #ff4d6d;
    color: #fff;
    margin-top: 10px;
}

.btn-del:hover {
    background: #ff1a3c;
}

/* tombol tambah & simpan */
button[type="submit"], button[onclick] {
    background: #b64fcf;
    color: #fff;
    margin-top: 10px;
}

button[type="submit"]:hover, button[onclick]:hover {
    background: #933ab5;
}

/* ===== TAMBAHAN ===== */
#rows .grid:last-child {
    margin-bottom: 0;
}

.hint-left {
    text-align: left;
    font-size: 0.85rem;
    color: #ddd;
    margin-top: 3px;
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

<button type="button" onclick="addRow()">+ Tambah</button><br><br>

<button type="submit" onclick="simpan()">Simpan</button>
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
