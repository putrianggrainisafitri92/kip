<?php
ob_start();

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/FPDF/fpdf.php';
require_once __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    die("ID evaluasi tidak ditemukan");
}

$id = intval($_GET['id']);

// 1. Ambil data evaluasi + mahasiswa
$query = "
SELECT 
    m.npm, m.nama_mahasiswa, m.program_studi, m.jurusan, m.tahun,
    e.id_mahasiswa_kip, e.keaktifan, e.prestasi, e.penerima_bansos, e.info_hp, e.nomor_wa, e.submitted_at
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

// 2. Ambil data keluarga
$qKeluarga = "SELECT * FROM keluarga WHERE id_mahasiswa_kip = $id_mhs";
$rKeluarga = mysqli_query($koneksi, $qKeluarga);
$keluarga = mysqli_fetch_assoc($rKeluarga) ?: [
    'nm_ayah'=>'-','status_ayah'=>'-','pkerjan_ayah'=>'-','instansi_ayah'=>'-','penghasilan_ayah'=>0,
    'nm_ibu'=>'-','status_ibu'=>'-','pkerjan_ibu'=>'-','instansi_ibu'=>'-','penghasilan_ibu'=>0,
    'jumlah_tgngn'=>0
];

// 3. Ambil data transportasi
$qTransportasi = "SELECT * FROM transportasi WHERE id_mahasiswa_kip = $id_mhs";
$rTransportasi = mysqli_query($koneksi, $qTransportasi);
$transportasi = mysqli_fetch_assoc($rTransportasi) ?: [
    'alat_transportasi' => '-',
    'detail_transportasi' => '-'
];

if (ob_get_length()) ob_end_clean();

function formatRange($val){
    if(!$val || $val == '-') return '-';
    if(strpos($val, '-') !== false){
        [$min, $max] = explode('-', $val);
        return "Rp ".number_format($min,0,',','.')." - Rp ".number_format($max,0,',','.');
    }
    if($val == "<=700000") return "<= Rp 700.000";
    if($val == ">=4000000") return ">= Rp 4.000.000";
    return "Rp ".number_format((int)$val,0,',','.');
}

// 5. GENERATE PDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(78, 10, 138); 
        $this->Cell(0, 8, 'POLITEKNIK NEGERI LAMPUNG', 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 4, 'Sistem Informasi Monitoring KIP-K (KIPWEB)', 0, 1, 'C');
        $this->Ln(2);
        $this->SetDrawColor(123, 53, 212);
        $this->SetLineWidth(0.6);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' - Dokumen Digital KIPWEB Polinela', 0, 0, 'C');
    }

    function SectionTitle($title) {
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(78, 10, 138);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 7, "  " . strtoupper($title), 0, 1, 'L', true);
        $this->Ln(1);
    }

    function TableRow($label, $value) {
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(245, 245, 255);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(55, 7, " " . $label, 1, 0, 'L', true);
        
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(0, 7, " " . $value, 1, 1, 'L');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Matikan auto break sementara untuk kontrol manual kalau diperlukan, 
// tapi di sini kita hanya kecilkan margin bawah
$pdf->SetAutoPageBreak(true, 10);

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(50, 50, 50);
$pdf->Cell(0, 8, 'FORMULIR HASIL EVALUASI MAHASISWA PENERIMA KIP KULIAH', 0, 1, 'C');
$pdf->Ln(2);

// 1. DATA MAHASISWA
$pdf->SectionTitle('I. Identitas Mahasiswa');
$pdf->TableRow('NPM', $data['npm']);
$pdf->TableRow('Nama Lengkap', $data['nama_mahasiswa']);
$pdf->TableRow('Program Studi', $data['program_studi']);
$pdf->TableRow('Jurusan', $data['jurusan']);
$pdf->TableRow('Tahun Angkatan', $data['tahun']);
$pdf->Ln(2);

// 2. HASIL EVALUASI
$pdf->SectionTitle('II. Hasil Evaluasi Mandiri');
$pdf->TableRow('Keaktifan Kuliah', $data['keaktifan']);
$pdf->TableRow('Prestasi / Kegiatan Akademik', $data['prestasi']);
$pdf->TableRow('Status Penerima Bansos', $data['penerima_bansos']);
$pdf->TableRow('Spesifikasi Perangkat (HP)', $data['info_hp']);
$pdf->TableRow('Nomor WhatsApp Aktif', $data['nomor_wa']);
$pdf->Ln(2);

// 3. DATA KELUARGA
$pdf->SectionTitle('III. Data Kondisi Keluarga');
$pdf->TableRow('Nama Ayah', $keluarga['nm_ayah'] . " (" . $keluarga['status_ayah'] . ")");
$pdf->TableRow('Pekerjaan Ayah', $keluarga['pkerjan_ayah']);
$pdf->TableRow('Penghasilan Ayah', formatRange($keluarga['penghasilan_ayah']));
$pdf->TableRow('Nama Ibu', $keluarga['nm_ibu'] . " (" . $keluarga['status_ibu'] . ")");
$pdf->TableRow('Pekerjaan Ibu', $keluarga['pkerjan_ibu']);
$pdf->TableRow('Penghasilan Ibu', formatRange($keluarga['penghasilan_ibu']));
$pdf->TableRow('Jumlah Tanggungan', $keluarga['jumlah_tgngn'] . " orang");
$pdf->Ln(2);

// 4. TRANSPORTASI
$pdf->SectionTitle('IV. Sarana Transportasi');
$pdf->TableRow('Alat Transportasi Utama', $transportasi['alat_transportasi']);
$pdf->TableRow('Detail / Merk Kendaraan', $transportasi['detail_transportasi']);
$pdf->Ln(10);

// SIGNATURE (Lebih padat)
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(130);
$pdf->Cell(0, 4, 'Bandar Lampung, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(130);
$pdf->Cell(0, 4, 'Mahasiswa Bersangkutan,', 0, 1, 'C');
$pdf->Ln(12);
$pdf->Cell(130);
$pdf->SetFont('Arial', 'BU', 9);
$pdf->Cell(0, 4, $data['nama_mahasiswa'], 0, 1, 'C');
$pdf->Cell(130);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 4, 'NPM. ' . $data['npm'], 0, 1, 'C');

ob_end_clean();
$pdf->Output('I', 'Evaluasi_KIPK_' . $data['npm'] . '.pdf');
exit;