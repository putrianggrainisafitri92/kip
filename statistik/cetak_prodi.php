<?php
require('../FPDF copy/fpdf.php');
include '../koneksi.php';

if (!isset($_GET['prodi'])) {
  die("Program Studi tidak ditentukan.");
}

class PDF extends FPDF {
    // Hitung jumlah baris teks untuk MultiCell
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
            if ($c == "\n") { $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue; }
            if ($c == ' ') $sep = $i;
            if (isset($cw[$c])) $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else $i = $sep + 1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else $i++;
        }
        return $nl;
    }

    // Baris tabel sejajar
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
            $a = isset($aligns[$i]) ? $aligns[$i] : 'L';
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, $height, utf8_decode($txt), 0, $a);
            $x += $w;
            $this->SetXY($x, $y);
        }

        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
}

$prodi = urldecode($_GET['prodi']);
$query = "SELECT npm, nama_mahasiswa, jurusan, tahun, skema 
          FROM mahasiswa_kip 
          WHERE program_studi = ? 
          ORDER BY nama_mahasiswa ASC";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $prodi);
$stmt->execute();
$result = $stmt->get_result();

// Buat PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);

// Header judul
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, utf8_decode("Daftar Mahasiswa KIP-Kuliah - $prodi"), 0, 1, 'C');
$pdf->Ln(3);

// Header tabel
$pdf->SetFont('Times', 'B', 11);
$pdf->SetFillColor(75, 0, 130);
$pdf->SetTextColor(255);

$w = [10, 28, 70, 60, 25, 40];
$headers = ['No', 'NPM', 'Nama Mahasiswa', 'Jurusan', 'Tahun', 'Skema'];
foreach ($headers as $i => $header) {
    $pdf->Cell($w[$i], 8, $header, 1, 0, 'C', true);
}
$pdf->Ln();

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
        ['C', 'C', 'L', 'L', 'C', 'L'] // perataan kolom
    );
}

// Footer cetak
$pdf->Ln(5);
$pdf->SetFont('Times', 'I', 10);
$pdf->Cell(0, 8, 'Dicetak pada: ' . date('d-m-Y H:i:s'), 0, 1, 'R');

$pdf->Output("I", "Mahasiswa_" . preg_replace('/[^A-Za-z0-9_\-]/','_', $prodi) . ".pdf");
?>
