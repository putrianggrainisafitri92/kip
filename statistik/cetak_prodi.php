<?php
require('../FPDF copy/fpdf.php');
include '../koneksi.php';

/* =========================
   VALIDASI AKSES
========================= */
if (!isset($_GET['jurusan']) || !isset($_GET['prodi'])) {
    die("Akses tidak valid. Silakan pilih Jurusan dan Program Studi dari statistik.");
}

$jurusan = urldecode($_GET['jurusan']);
$prodi   = urldecode($_GET['prodi']);

/* =========================
   CLASS PDF
========================= */
class PDF extends FPDF {

    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;

        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);

        if ($nb > 0 && $s[$nb - 1] == "\n") $nb--;

        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;

        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue;
            }
            if ($c == ' ') $sep = $i;
            if (isset($cw[$c])) $l += $cw[$c];

            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else {
                    $i = $sep + 1;
                }
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    function Row($data, $widths, $height, $aligns = []) {
        $nb = 0;
        foreach ($data as $i => $txt) {
            $nb = max($nb, $this->NbLines($widths[$i], $txt));
        }

        $h = $height * $nb;
        $this->CheckPageBreak($h);

        $x = $this->GetX();
        $y = $this->GetY();

        foreach ($data as $i => $txt) {
            $w = $widths[$i];
            $a = $aligns[$i] ?? 'L';

            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, $height, utf8_decode($txt), 0, $a);
            $x += $w;
            $this->SetXY($x, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }
}

/* =========================
   QUERY DATABASE
========================= */
$query = "SELECT npm, nama_mahasiswa, jurusan, tahun, skema
          FROM mahasiswa_kip
          WHERE jurusan = ? AND program_studi = ?
          ORDER BY nama_mahasiswa ASC";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("ss", $jurusan, $prodi);
$stmt->execute();
$result = $stmt->get_result();

/* =========================
   BUAT PDF
========================= */
$pdf = new PDF('L', 'mm', 'A4');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

/* Header */
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 8, utf8_decode("Daftar Mahasiswa KIP-Kuliah"), 0, 1, 'C');
$pdf->Cell(0, 8, utf8_decode("Jurusan $jurusan - $prodi"), 0, 1, 'C');
$pdf->Ln(3);

/* Header tabel */
$pdf->SetFont('Times', 'B', 11);
$pdf->SetFillColor(75, 0, 130);
$pdf->SetTextColor(255);

$w = [10, 28, 70, 60, 25, 40];
$headers = ['No', 'NPM', 'Nama Mahasiswa', 'Jurusan', 'Tahun', 'Skema'];

foreach ($headers as $i => $header) {
    $pdf->Cell($w[$i], 8, $header, 1, 0, 'C', true);
}
$pdf->Ln();

/* Isi tabel */
$pdf->SetFont('Times', '', 10);
$pdf->SetTextColor(0);

$no = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Row(
        [
            $no++,
            $row['npm'],
            $row['nama_mahasiswa'],
            $row['jurusan'],
            $row['tahun'],
            $row['skema']
        ],
        $w,
        6,
        ['C', 'C', 'L', 'L', 'C', 'L']
    );
}

/* Footer */
$pdf->Ln(5);
$pdf->SetFont('Times', 'I', 10);
$pdf->Cell(0, 8, 'Dicetak pada: ' . date('d-m-Y H:i:s'), 0, 1, 'R');

/* Output */
$namaFile = "Mahasiswa_" . preg_replace(
    '/[^A-Za-z0-9_\-]/',
    '_',
    $jurusan . '_' . $prodi
) . ".pdf";

$pdf->Output("I", $namaFile);
?>
