<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

class form_pengajuan_image extends FPDF {

    function Header()
    {
        // Title Atas
        $this->SetFont('Arial','B',14);
        $this->Cell(0,7,'FORM PENGAJUAN',0,1,'C');
        
        $this->Ln(8);
    }
    
    public function generate($form, $details, $detail_images, $approvals, $total_amount) {
        $this->AddPage();
        $this->SetFont('Arial','',10);

        // ======================
        // INFORMASI HEADER
        // ======================

        $this->Cell(40,6,'Responsible Name');
        $this->Cell(5,6,':');
        $this->Cell(60,6,$form->created_by_name);

        $this->Cell(30,6,'No CAO');
        $this->Cell(5,6,':');
        $this->Cell(20,6,$form->cao_number);
        $this->Ln();

        $this->Cell(40,6,'Tanggal Pengajuan');
        $this->Cell(5,6,':');
        $this->Cell(60,6,$form->submission_date);

        $this->Cell(30,6,'Jenis Transaksi');
        $this->Cell(5,6,':');
        $this->Cell(20,6,$form->transaction_type);
        $this->Ln(10);

        // ======================
        // KETERANGAN
        // ======================

        // $this->Cell(0,6,$form->project_name,0,1);
        // $this->Cell(0,6,$form->description,0,1);
        // $this->Ln(3);

        // ======================
        // TABLE HEADER
        // ======================

        $this->SetFont('Arial','B',9);

        $this->Cell(10,7,'No',1);
        $this->Cell(55,7,'Keterangan',1);
        $this->Cell(35,7,'Area',1);
        $this->Cell(15,7,'Qty',1);
        $this->Cell(30,7,'Unit Price',1);
        $this->Cell(35,7,'Jumlah',1);
        $this->Ln();

        $this->SetFont('Arial','',9);

        // ======================
        // DATA TABLE
        // ======================

        $no = 1;
        foreach($details as $row)
        {
            $this->Cell(10,7,$no,1);
            $this->Cell(55,7,$row->description,1);
            $this->Cell(35,7,$row->work_area,1);
            $this->Cell(15,7,number_format($row->quantity),1);
            $this->Cell(30,7,'Rp '.number_format($row->unit_price,0,',','.'),1);
            $this->Cell(35,7,'Rp '.number_format($row->total_amount,0,',','.'),1);
            $this->Ln();
            $no++;
        }

        // ======================
        // TOTAL
        // ======================

        $this->SetFont('Arial','B',10);

        $this->Cell(145,8,'TOTAL',1);
        $this->Cell(35,8,'Rp '.number_format($total_amount,0,',','.'),1);
        $this->Ln(15);


        // ======================
        // TANDA TANGAN
        // ======================
        $this->SetFont('Arial','',10);

        $this->Cell(60,6,'Yang Mengajukan',0,0,'C');
        $this->Cell(60,6,'Mengetahui',0,0,'C');
        $this->Cell(60,6,'Menyetujui',0,1,'C');

        $this->Ln(20);

        $this->Cell(60,6,$form->created_by_name,0,0,'C');
        $countReview = 1; 
        $wCell = 60;
        foreach($approvals as $row)
        {
            if($row->category == "mengetahui"){
                if($countReview > 1){
                    $wCell /= 2;
                }
                $countReview++;
            }
        }

        foreach($approvals as $row)
        {
            if($row->category == "mengetahui"){
                $this->Cell($wCell,6,$row->user_name,0,0,'C');
            }
            if($row->category == "menyetujui"){
                $this->Cell(60,6,$row->user_name,0,1,'C');
            }
        }

        $this->addImagePage($detail_images);
        $this->Output('I','form_pengajuan_' . $form->id . '.pdf');
    }

    function addImagePage($detail_images) {
        if (empty($detail_images)) {
            return;
        }

        foreach ($detail_images as $image) {
            $this->AddPage();
            // $this->SetFont('Arial','B',12);
            // $this->Cell(0,10,'Lampiran Gambar',0,1,'C');
            $this->Ln(5);

            if (file_exists($image->file_path)) {
                $this->Image($image->file_path, 10, $this->GetY(), 190);
            }
        }
    }
}
