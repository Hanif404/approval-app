<?php
// Minimal FPDF implementation for PDF generation
class FPDF {
    protected $page = 0;
    protected $y = 0;
    protected $x = 0;
    protected $buffer = '';
    protected $pages = array();
    protected $fonts = array();
    protected $font_family = '';
    protected $font_size = 12;
    protected $font_style = '';
    
    function __construct($orientation='P', $unit='mm', $size='A4') {
        $this->buffer = '%PDF-1.3' . "\n";
    }
    
    function AddPage() {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->y = 10;
        $this->x = 10;
    }
    
    function SetFont($family, $style='', $size=12) {
        $this->font_family = $family;
        $this->font_style = $style;
        $this->font_size = $size;
    }
    
    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='') {
        $this->pages[$this->page] .= $txt . ' ';
        if($ln == 1) $this->Ln();
    }
    
    function Ln($h=5) {
        $this->y += $h;
    }
    
    function Output($name='', $dest='I') {
        if($dest == 'I') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $name . '"');
        } elseif($dest == 'D') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $name . '"');
        }
        echo $this->buffer;
        foreach($this->pages as $page) {
            echo $page;
        }
    }
}
