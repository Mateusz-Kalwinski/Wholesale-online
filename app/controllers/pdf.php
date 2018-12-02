<?php

class pdf extends Controller
{
    public function pobierz($orderId){

        $pdf=$this->model('pdfModel');
        $pdf->generatePDF($orderId);
        
    }
}
