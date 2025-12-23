<?php
require __DIR__.'/fpdf/fpdf.php';
include $_SERVER['DOCUMENT_ROOT'] . '/KIPWEB/koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    die("ID evaluasi tidak ditemukan");
}

$id = intval($_GET['id']);

// ========================
// 1. Ambil data evaluasi + mahasiswa
// ========================
$query = "
SELECT 
    m.npm,
    m.nama_mahasiswa,
    m.program_studi,
    m.jurusan,
    m.tahun,
    e.id_mahasiswa_kip,
    e.keaktifan,
    e.prestasi,
    e.penerima_bansos,
    e.info_hp,
    e.nomor_wa
FROM evaluasi e
JOIN mahasiswa_kip m ON e.id_mahasiswa_kip = m.id_mahasiswa_kip
WHERE e.id_eval = $id
";

$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data evaluasi tidak ditemukan");
}

$id_mhs = $data['id_mahasiswa_kip'];


// ========================
// 2. Ambil data keluarga
// ========================
$qKeluarga = "SELECT * FROM keluarga WHERE id_mahasiswa_kip = $id_mhs";
$rKeluarga = mysqli_query($koneksi, $qKeluarga);

$keluarga = mysqli_fetch_assoc($rKeluarga) ?: [
    'nm_ayah'=>'-','status_ayah'=>'-','pkerjan_ayah'=>'-','instansi_ayah'=>'-','penghasilan_ayah'=>0,
    'nm_ibu'=>'-','status_ibu'=>'-','pkerjan_ibu'=>'-','instansi_ibu'=>'-','penghasilan_ibu'=>0,
    'jumlah_tgngn'=>0
];


// ========================
// 3. Ambil data transportasi
// ========================
$qTransportasi = "SELECT * FROM transportasi WHERE id_mahasiswa_kip = $id_mhs";
$rTransportasi = mysqli_query($koneksi, $qTransportasi);

$transportasi = mysqli_fetch_assoc($rTransportasi) ?: [
    'alat_transportasi' => '-',
    'detail_transportasi' => '-'
];


// ========================
// 4. Ambil file dokumen
// ========================
$qFile = "SELECT file_eval, uploaded_at 
          FROM file_eval WHERE id_mahasiswa_kip = $id_mhs";

$rFile = mysqli_query($koneksi, $qFile);

$file = mysqli_fetch_assoc($rFile) ?: [
    'file_eval' => '-',
    'uploaded_at' => '-'
];


// ========================
// Bersihkan buffer
// ========================
if (ob_get_length()) ob_end_clean();

// ========================
// FUNGSI FORMAT RANGE PENGHASILAN
// ========================
function formatRangePenghasilan($val){
    if(!$val || $val == '-') return '-';

    // Jika format range: 700000-1000000
    if(strpos($val, '-') !== false){
        [$min, $max] = explode('-', $val);
        return "Rp ".number_format($min,0,',','.').
               " - Rp ".number_format($max,0,',','.');
    }

    // Jika <= atau >=
    if($val == "<=700000") return "<= Rp 700.000";
    if($val == ">=4000000") return ">= Rp 4.000.000";

    // Fallback angka biasa
    return "Rp ".number_format((int)$val,0,',','.');
}



// ========================
// 5. GENERATE PDF
// ========================
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 15);

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Laporan Evaluasi Mahasiswa KIPK',0,1,'C');


// ========================
// Data Mahasiswa
// ========================
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DATA MAHASISWA",0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"NPM: ".$data['npm'],0,1);
$pdf->Cell(0,6,"Nama: ".$data['nama_mahasiswa'],0,1);
$pdf->Cell(0,6,"Program Studi: ".$data['program_studi'],0,1);
$pdf->Cell(0,6,"Jurusan: ".$data['jurusan'],0,1);
$pdf->Cell(0,6,"Tahun Angkatan: ".$data['tahun'],0,1);


// ========================
// Hasil Evaluasi
// ========================
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"HASIL EVALUASI",0,1);

$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,6,"Keaktifan: ".$data['keaktifan']);
$pdf->Ln(3);

$pdf->MultiCell(0,6,"Prestasi Non Akademik: ".$data['prestasi']);
$pdf->Ln(3);

$pdf->MultiCell(0,6,"Keluarga Penerima Bansos: ".$data['penerima_bansos']);
$pdf->Ln(3);

$pdf->MultiCell(0,6,"Info HP: ".$data['info_hp']);
$pdf->Ln(3);

$pdf->MultiCell(0,6,"Nomor WhatsApp: ".$data['nomor_wa']);


// ========================
// Data Keluarga
// ========================
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DATA KELUARGA",0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"Ayah: ".$keluarga['nm_ayah'],0,1);
$pdf->Cell(0,6,"Status Ayah: ".$keluarga['status_ayah'],0,1);
$pdf->Cell(0,6,"Pekerjaan Ayah: ".$keluarga['pkerjan_ayah'],0,1);
$pdf->Cell(0,6,"Instansi Ayah: ".$keluarga['instansi_ayah'],0,1);
$pdf->Cell(0,6,"Penghasilan Ayah: ".formatRangePenghasilan($keluarga['penghasilan_ayah']),0,1);

$pdf->Ln(3);
$pdf->Cell(0,6,"Ibu: ".$keluarga['nm_ibu'],0,1);
$pdf->Cell(0,6,"Status Ibu: ".$keluarga['status_ibu'],0,1);
$pdf->Cell(0,6,"Pekerjaan Ibu: ".$keluarga['pkerjan_ibu'],0,1);
$pdf->Cell(0,6,"Instansi Ibu: ".$keluarga['instansi_ibu'],0,1);
$pdf->Cell(0,6,"Penghasilan Ibu: ".formatRangePenghasilan($keluarga['penghasilan_ibu']),0,1);

$pdf->Cell(0,6,"Jumlah Tanggungan: ".$keluarga['jumlah_tgngn'],0,1);


// ========================
// Transportasi
// ========================
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DATA TRANSPORTASI",0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"Alat Transportasi: ".$transportasi['alat_transportasi'],0,1);
$pdf->Cell(0,6,"Detail Kendaraan: ".$transportasi['detail_transportasi'],0,1);


// ========================
// Dokumen Terunggah
// ========================
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DOKUMEN TERUNGG AH",0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"File Evaluasi: ".$file['file_eval'],0,1);
$pdf->Cell(0,6,"Uploaded At: ".$file['uploaded_at'],0,1);


// ========================
// Output PDF
// ========================
$pdf->Output('I','laporan_evaluasi_'.preg_replace('/[^a-zA-Z0-9]/','',$data['npm']).'.pdf');
exit;
?>
