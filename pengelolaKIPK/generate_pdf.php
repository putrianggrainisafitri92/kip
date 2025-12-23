<?php
require __DIR__.'/lib/FPDF/fpdf.php';
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    die("ID evaluasi tidak ditemukan");
}

$id = intval($_GET['id']);

// FIX: ambil data evaluasi berdasarkan id_eval (bukan id_mahasiswa)
$query = "
SELECT 
    m.npm,
    m.nama_mahasiswa,
    m.program_studi,
    m.jurusan,
    m.tahun,

    e.id_mahasiswa_kip,        -- FIX: ini kita ambil jadi variabel
    e.kondisi_aewal,
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

// FIX: definisikan variabel id_mahasiswa_kip yang benar
$id_mhs = $data['id_mahasiswa_kip'];

// FIX: ambil data keluarga sesuai kolom
$qKeluarga = "SELECT * FROM keluarga WHERE id_mahasiswa_kip = $id_mhs";
$rKeluarga = mysqli_query($koneksi, $qKeluarga);
$keluarga = mysqli_fetch_assoc($rKeluarga);

if (!$keluarga) {
    $keluarga = [
        'nm_ayah' => '-',
        'status_ayah' => '-',
        'pkerjan_ayah' => '-',
        'instansi_ayah' => '-',
        'penghasilan_ayah' => 0,
        'nm_ibu' => '-',
        'status_ibu' => '-',
        'pkerjan_ibu' => '-',
        'instansi_ibu' => '-',
        'penghasilan_ibu' => 0,
        'jumlah_tgngn' => 0,
        'total_penghasilan' => 0
    ];
}

// FIX: ambil data transportasi sesuai kolom
$qTransportasi = "SELECT * FROM transportasi WHERE id_mahasiswa_kip = $id_mhs";
$rTransportasi = mysqli_query($koneksi, $qTransportasi);
$transportasi = mysqli_fetch_assoc($rTransportasi);

if (!$transportasi) {
    $transportasi = [
        'alat_transportasi' => '-',
        'detail_transportasi' => '-'
    ];
}

// FIX: ambil data file upload sesuai nama kolom
$qFile = "SELECT * FROM file_eval WHERE id_mahasiswa_kip = $id_mhs";
$rFile = mysqli_query($koneksi, $qFile);
$file = mysqli_fetch_assoc($rFile);

if (!$file) {
    $file = [
        'file_eval' => '-',
        'file_revisi1' => '-',
        'file_revisi2' => '-',
        'uploaded_at' => '-'
    ];
}

// Biar gak corrupt sebelum PDF
if (ob_get_length()) ob_end_clean();

// ---------- GENERATE PDF ----------
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 15);

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Laporan Evaluasi Mahasiswa KIPK',0,1,'C');

// Data Mahasiswa
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DATA MAHASISWA",0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"NPM: ".$data['npm'],0,1);
$pdf->Cell(0,6,"Nama: ".$data['nama_mahasiswa'],0,1);
$pdf->Cell(0,6,"Program Studi: ".$data['program_studi'],0,1);
$pdf->Cell(0,6,"Jurusan: ".$data['jurusan'],0,1);
$pdf->Cell(0,6,"Tahun Angkatan: ".$data['tahun'],0,1);

// Evaluasi
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"HASIL EVALUASI",0,1);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,6,"Kondisi Awal: ".$data['kondisi_aewal']);
$pdf->Ln(3);
$pdf->MultiCell(0,6,"Keaktifan: ".$data['keaktifan']);
$pdf->Ln(3);
$pdf->MultiCell(0,6,"Prestasi Non Akademik: ".$data['prestasi']);
$pdf->Ln(3);
$pdf->MultiCell(0,6,"Keluarga Penerima Bansos: ".$data['penerima_bansos']);
$pdf->Ln(3);
$pdf->MultiCell(0,6,"Info HP: ".$data['info_hp']);
$pdf->Ln(3);
$pdf->MultiCell(0,6,"Nomor WhatsApp: ".$data['nomor_wa']);

// Keluarga
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DATA KELUARGA",0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"Ayah: ".$keluarga['nm_ayah'],0,1);
$pdf->Cell(0,6,"Status Ayah: ".$keluarga['status_ayah'],0,1);
$pdf->Cell(0,6,"Pekerjaan Ayah: ".$keluarga['pkerjan_ayah'],0,1);
$pdf->Cell(0,6,"Instansi Ayah: ".$keluarga['instansi_ayah'],0,1);
$pdf->Cell(0,6,"Penghasilan Ayah: Rp ".number_format($keluarga['penghasilan_ayah'],0,',','.'),0,1);

$pdf->Ln(3);
$pdf->Cell(0,6,"Ibu: ".$keluarga['nm_ibu'],0,1);
$pdf->Cell(0,6,"Status Ibu: ".$keluarga['status_ibu'],0,1);
$pdf->Cell(0,6,"Pekerjaan Ibu: ".$keluarga['pkerjan_ibu'],0,1);
$pdf->Cell(0,6,"Instansi Ibu: ".$keluarga['instansi_ibu'],0,1);
$pdf->Cell(0,6,"Penghasilan Ibu: Rp ".number_format($keluarga['penghasilan_ibu'],0,',','.'),0,1);

$pdf->Ln(3);
$totalGaji = $keluarga['penghasilan_ayah'] + $keluarga['penghasilan_ibu'];
$pdf->Cell(0,6,"Total Penghasilan Keluarga: Rp ".number_format($totalGaji,0,',','.'),0,1);
$pdf->Cell(0,6,"Jumlah Tanggungan: ".$keluarga['jumlah_tgngn'],0,1);

// Transportasi
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DATA TRANSPORTASI",0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"Alat Transportasi: ".$transportasi['alat_transportasi'],0,1);
$pdf->Cell(0,6,"Detail Kendaraan: ".$transportasi['detail_transportasi']);

// Dokumen
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DOKUMEN TERUNGGAH",0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6, "File Evaluasi: ".$file['file_eval'],0,1);
$pdf->Cell(0,6, "File Revisi 1: ".$file['file_revisi1'],0,1);
$pdf->Cell(0,6, "File Revisi 2: ".$file['file_revisi2'],0,1);
$pdf->Cell(0,6, "Uploaded At: ".$file['uploaded_at'],0,1);


// Output
$pdf->Output('I','laporan_evaluasi_'.$data['npm'].'.pdf');
exit;
