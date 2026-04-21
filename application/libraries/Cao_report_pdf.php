<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

class Cao_report_pdf extends FPDF {

    private $date_from;
    private $date_to;

    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 8, 'DATABASE CAO', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, 'PERIODE: ' . $this->date_from . ' S/D ' . $this->date_to, 0, 1, 'C');
        $this->Ln(3);
    }

    function Footer() {
        $this->SetY(-12);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 6, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function generate($cao_forms, $signatures, $date_from, $date_to) {
        $this->date_from = $date_from;
        $this->date_to   = $date_to;
        $this->AliasNbPages();
        $this->AddPage('L'); // Landscape agar kolom cukup
        $this->SetFont('Arial', '', 9);

        // ── Header tabel ──────────────────────────────────────────
        $this->SetFillColor(52, 73, 94);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);

        // $this->Cell(10,  8, 'NO',                  1, 0, 'C', true);
        $this->Cell(30,  8, 'NO CAO',              1, 0, 'C', true);
        $this->Cell(28,  8, 'TANGGAL',             1, 0, 'C', true);
        $this->Cell(55,  8, 'NAMA PENERIMA',       1, 0, 'C', true);
        $this->Cell(40,  8, 'NO REKENING',         1, 0, 'C', true);
        $this->Cell(40,  8, 'JENIS TRANSAKSI',     1, 0, 'C', true);
        $this->Cell(45,  8, 'CAO PENGAJUAN',       1, 0, 'C', true);
        $this->Cell(40,  8, 'CAO TRANSAKSI (Rp)',  1, 1, 'C', true);

        // ── Baris data ────────────────────────────────────────────
        $this->SetFillColor(240, 240, 240);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 8);

        // $no    = 1;
        // $total = 0;
        $fill  = false;

        foreach ($cao_forms as $row) {
            $amount = (float)($row->total_amount ?? 0);
            $total += $amount;

            // $this->Cell(10,  7, $no,                                                    1, 0, 'C', $fill);
            $this->Cell(30,  7, $row->cao_number,                                       1, 0, 'L', $fill);
            $this->Cell(28,  7, date('d-m-Y', strtotime($row->submission_date)),        1, 0, 'C', $fill);
            $this->Cell(55,  7, $row->payment_receiver_name,                            1, 0, 'L', $fill);
            $this->Cell(40,  7, $row->bank_account_number,                              1, 0, 'L', $fill);
            $this->Cell(40,  7, $row->transaction_type,                                 1, 0, 'L', $fill);
            $this->Cell(45,  7, $row->created_by_name,                                  1, 0, 'L', $fill);
            $this->Cell(40,  7, 'Rp ' . number_format($amount, 0, ',', '.'),            1, 1, 'R', $fill);

            $fill = !$fill;
            $no++;
        }

        // ── Baris total ───────────────────────────────────────────
        // $this->SetFont('Arial', 'B', 9);
        // $this->SetFillColor(52, 73, 94);
        // $this->SetTextColor(255, 255, 255);
        // $this->Cell(238, 8, 'TOTAL', 1, 0, 'R', true);
        // $this->Cell(40,  8, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1, 'R', true);

        // ── Tanda tangan ──────────────────────────────────────────
        // $this->SetTextColor(0, 0, 0);
        // $this->Ln(10);

        // if (empty($signatures)) {
        //     return $this->Output('D', 'CAO_Report_' . date('Ymd') . '.pdf');
        // }

        // $count   = count($signatures);
        // $pageW   = $this->GetPageWidth() - 20; // margin kiri+kanan 10
        // $colW    = $pageW / $count;
        // $startX  = 10;
        // $imgH    = 20; // tinggi area gambar tanda tangan (mm)

        // // Baris label (Yang Mengajukan, Mengetahui, dst)
        // $this->SetFont('Arial', '', 9);
        // foreach ($signatures as $sig) {
        //     $this->Cell($colW, 6, $sig->label, 0, 0, 'C');
        // }
        // $this->Ln();

        // // Baris gambar tanda tangan
        // $yImg = $this->GetY();
        // foreach ($signatures as $i => $sig) {
        //     $x = $startX + ($i * $colW);
        //     if (!empty($sig->image_path)) {
        //         $imgFile = FCPATH . 'uploads/signatures/' . $sig->image_path;
        //         if (file_exists($imgFile)) {
        //             // Hitung posisi tengah dalam kolom
        //             $imgW = $colW * 0.6;
        //             $imgX = $x + ($colW - $imgW) / 2;
        //             $this->Image($imgFile, $imgX, $yImg + 2, $imgW, $imgH - 2);
        //         }
        //     }
        // }
        // $this->SetY($yImg + $imgH);

        // // Baris nama
        // $this->SetFont('Arial', 'B', 9);
        // foreach ($signatures as $sig) {
        //     $this->Cell($colW, 6, $sig->name, 0, 0, 'C');
        // }
        // $this->Ln();

        // // Baris jabatan
        // $this->SetFont('Arial', '', 8);
        // foreach ($signatures as $sig) {
        //     $this->Cell($colW, 5, $sig->position ?? '', 0, 0, 'C');
        // }
        // $this->Ln();

        $this->Output('D', 'CAO_Report_' . date('Ymd') . '.pdf');
    }
}
