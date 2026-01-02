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

// 4. Ambil file dokumen
$qFile = "SELECT file_eval, uploaded_at FROM file_eval WHERE id_mahasiswa_kip = $id_mhs";
$rFile = mysqli_query($koneksi, $qFile);
$file = mysqli_fetch_assoc($rFile) ?: ['file_eval' => '-', 'uploaded_at' => '-'];

if (ob_get_length()) ob_end_clean();

function formatRangePenghasilan($val){
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
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(78, 10, 138); // Deep Purple
        $this->Cell(0, 10, 'POLITEKNIK NEGERI LAMPUNG', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, 'Sistem Informasi Monitoring KIP-K (KIPWEB)', 0, 1, 'C');
        $this->Ln(5);
        $this->SetDrawColor(123, 53, 212); // Purple Line
        $this->SetLineWidth(1);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' / {nb} - Dicetak secara sistem pada ' . date('d/m/Y H:i'), 0, 0, 'C');
    }

    function SectionTitle($title) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(248, 242, 255); // Very Light Purple
        $this->SetTextColor(78, 10, 138);
        $this->Cell(0, 10, "  " . strtoupper($title), 0, 1, 'L', true);
        $this->Ln(3);
    }

    function InfoRow($label, $value) {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(60, 8, $label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(80, 80, 80);
        $this->MultiCell(0, 8, ": " . $value, 0, 'L');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0, 10, 'FORMULIR EVALUASI PENERIMA KIP KULIAH', 0, 1, 'C');
$pdf->Ln(5);

// DATA MAHASISWA
$pdf->SectionTitle('Data Mahasiswa');
$pdf->InfoRow('NPM', $data['npm']);
$pdf->InfoRow('Nama Mahasiswa', $data['nama_mahasiswa']);
$pdf->InfoRow('Program Studi', $data['program_studi']);
$pdf->InfoRow('Jurusan', $data['jurusan']);
$pdf->InfoRow('Tahun Angkatan', $data['tahun']);
$pdf->Ln(5);

// HASIL EVALUASI
$pdf->SectionTitle('Hasil Evaluasi');
$pdf->InfoRow('Keaktifan Kuliah', $data['keaktifan']);
$pdf->InfoRow('Prestasi Non-Akademik', $data['prestasi']);
$pdf->InfoRow('Status Bansos', $data['penerima_bansos']);
$pdf->InfoRow('Merk/Tipe HP', $data['info_hp']);
$pdf->InfoRow('Nomor WhatsApp', $data['nomor_wa']);
$pdf->Ln(5);

// DATA KELUARGA
$pdf->SectionTitle('Data Orang Tua / Keluarga');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 8, 'A. Ayah', 0, 1);
$pdf->InfoRow('Nama Ayah', $keluarga['nm_ayah']);
$pdf->InfoRow('Status', $keluarga['status_ayah']);
$pdf->InfoRow('Pekerjaan', $keluarga['pkerjan_ayah']);
$pdf->InfoRow('Penghasilan', formatRangePenghasilan($keluarga['penghasilan_ayah']));
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 8, 'B. Ibu', 0, 1);
$pdf->InfoRow('Nama Ibu', $keluarga['nm_ibu']);
$pdf->InfoRow('Status', $keluarga['status_ibu']);
$pdf->InfoRow('Pekerjaan', $keluarga['pkerjan_ibu']);
$pdf->InfoRow('Penghasilan', formatRangePenghasilan($keluarga['penghasilan_ibu']));
$pdf->Ln(2);
$pdf->InfoRow('Jumlah Tanggungan', $keluarga['jumlah_tgngn'] . " orang");
$pdf->Ln(5);

// TRANSPORTASI
$pdf->SectionTitle('Informasi Transportasi');
$pdf->InfoRow('Alat Transportasi', $transportasi['alat_transportasi']);
$pdf->InfoRow('Detail Kendaraan', $transportasi['detail_transportasi']);
$pdf->Ln(5);

// FOOTER SIGNATURE (Formal touch)
$pdf->Ln(10);
$pdf->SetX(130);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60, 5, 'Bandar Lampung, ' . date('d F Y'), 0, 1, 'C');
$pdf->SetX(130);
$pdf->Cell(60, 5, 'Penerima KIP-K,', 0, 1, 'C');
$pdf->Ln(15);
$pdf->SetX(130);
$pdf->SetFont('Arial', 'BU', 10);
$pdf->Cell(60, 5, $data['nama_mahasiswa'], 0, 1, 'C');
$pdf->SetX(130);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60, 5, 'NPM. ' . $data['npm'], 0, 1, 'C');

ob_end_clean();
$pdf->Output('I', 'Evaluasi_KIPK_' . $data['npm'] . '.pdf');
exit;