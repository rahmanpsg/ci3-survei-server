<?php
class Cetak extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('Pdf');
    }

    public function index()
    {
        $triwulan = $this->input->get('triwulan');

        $query = $this->Model->query("SELECT jawaban FROM tbl_survei WHERE QUARTER(ditambahkan_pada) = '$triwulan'");

        $dataSurvei = array_map(function ($v) {
            $jawaban = json_decode($v['jawaban']);
            return $jawaban;
        }, $query);

        $totalUnsur = $this->Model->query("SELECT COUNT(b.no) total FROM tbl_unsur a LEFT JOIN tbl_pertanyaan b ON a.id = b.id_unsur GROUP BY a.id ORDER BY b.no");
        $totalPertanyaan = $this->Model->ambilTotalData('tbl_pertanyaan');

        $pdf = new Pdf('L', 'mm', 'LEGAL');

        $pdf->setFontSubsetting(true);

        $pdf->AddPage();

        $image_file = base_url('assets/images/logo.png');

        $pdf->Image($image_file, 80, 6, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        // Set font
        $pdf->SetFont('helvetica', 'B', 25);
        // Title
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 25, 'Kantor Kecamatan Lembang', 0, false, 'C', 0);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 40, 'Taddokong, Lembang, Kabupaten Pinrang,', 0, false, 'C', 0);
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 50, 'Sulawesi Selatan 91254, Indonesia', 0, false, 'C', 0);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 350, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 350, 32);

        $pdf->ln(35);

        $pdf->SetFont('helvetica', 'B', 12, '', true);
        $pdf->cell(0, 0, 'LAPORAN SURVEI KEPUASAN MASYARAKAT', 0, 1, 'C');
        $pdf->cell(0, 0, 'TRIWULAN ' . $this->Model->getRomawi($triwulan) . ' TAHUN ' . date('Y'), 0, 1, 'C');

        $pdf->ln();

        $pdf->SetFont('Times', 'B', 12);

        $pdf->Cell(20, 30, 'NO', 1, 0, 'C');
        $x = $pdf->GetX();
        $pdf->Cell(300, 10, 'NILAI PER UNSUR PELAYANAN', 1, 0, 'C');
        $pdf->Cell(20, 10, '', 'LTR', 1, 'C'); //Kolom total
        $pdf->SetX($x);

        $lebarUnsur = 300 / $totalPertanyaan;

        foreach ($totalUnsur as $k => $val) {
            $pdf->Cell(($lebarUnsur * $val['total']), 10, "U" . ($k + 1), 1, 0, 'C');
        }

        // ---------------
        $pdf->Cell(20, 10, 'TOTAL', 'R', 1, 'C');

        $pdf->SetX($x);

        $lebarPertanyaan = 300 / $totalPertanyaan;
        for ($i = 1; $i <= $totalPertanyaan; $i++) {
            $pdf->Cell($lebarPertanyaan, 10, "P$i", 1, 0, 'C');
        }
        // ---------------
        $pdf->Cell(20, 10, '', 'BR', 1, 'C'); //Kolom total

        $pdf->SetFont('Times', '', 12);

        $total = [];

        foreach ($dataSurvei as $key => $value) {
            $pdf->Cell(20, 10, $key + 1, 1, 0, 'C');
            $t = 0;
            foreach ($value as $k => $val) {
                $pdf->Cell($lebarPertanyaan, 10, $val, 1, 0, 'C');
                $t += $val;

                $total[$k][] = $val;
            }
            $pdf->Cell(20, 10, $t, 1, 1, 'C'); //Kolom total
        }

        // --------------------
        $pdf->Cell(20, 10, 'TOTAL', 1, 0, 'C');

        $t = 0;
        foreach ($total as $value) {
            $v = array_sum($value);
            $pdf->Cell($lebarPertanyaan, 10, $v, 1, 0, 'C');
            $t += $v;
        }

        $pdf->Cell(20, 10, $t, 1, 1, 'C');

        // --------------------
        $pdf->Cell(20, 10, 'NRR', 1, 0, 'C');

        $t = 0;
        foreach ($total as $value) {
            $v = number_format(array_sum($value) / count($dataSurvei), 3);
            $pdf->Cell($lebarPertanyaan, 10, $v, 1, 0, 'C');
            $t += $v;
        }

        $pdf->Cell(20, 10, $t, 1, 1, 'C');

        // --------------------
        $pdf->Cell(20, 10, 'NRR *', 1, 0, 'C');

        $t = 0;
        foreach ($total as $value) {
            $b_nrr = number_format(1 / count($totalUnsur), 3);
            $v = number_format(((array_sum($value) / count($dataSurvei)) * $b_nrr), 3);
            $pdf->Cell($lebarPertanyaan, 10, $v, 1, 0, 'C');
            $t += $v;
        }

        $pdf->Cell(20, 10, $t, 1, 1, 'C');

        //  -----------------------
        $rangeHasilIKM = [
            'TIDAK BAIK' => [25, 43.75],
            'KURANG BAIK' => [43.76, 62.50],
            'BAIK' => [62.51, 81.25],
            'SANGAT BAIK' => [81.26, 100]
        ];

        $ikm = ($t * 25);
        $pdf->Cell(270, 10, 'NILAI IKM', 'LTB');

        foreach ($rangeHasilIKM as $key => $val) {
            if ($ikm >= $val[0] && $ikm <= $val[1]) {
                $hasil = $key;
                break;
            }
        }

        $pdf->Cell(50, 10, $hasil, 'BT', 0, 'R');

        $pdf->Cell(20, 10, $ikm, 1, 1, 'C');

        $pdf->ln();
        $pdf->cell(0, 0, 'Keterangan :', 0, 1);
        $pdf->ln();
        $pdf->cell(0, 0, 'TOTAL = Jumlah keseluruhan tabulasi per pertanyaan', 0, 1);
        $pdf->cell(0, 0, 'NRR = Nilai rata-rata per unsur IKM (TOTAL / Jumlah Responden)', 0, 1);
        $pdf->cell(0, 0, "NRR* = Nilai IKM perunsur pelayanan (NRR x $b_nrr)", 0, 1);
        $pdf->cell(0, 0, 'NILAI IKM = Nilai Index Kepuasan Masyarakat (NRR* x 25)', 0, 1);


        $pdf->Output("Data SKM", 'I');
    }
}
