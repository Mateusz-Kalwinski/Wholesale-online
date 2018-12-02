<?php
class pdf extends Controller
{
    public function pobierz($orderId, $mail){
        $pdf=$this->model('pdfModel');
        $pdf->generatePDF($orderId);
        $sendMail = $this->model('mail');
        $sendMail->valueMail(6, $mail, $orderId);

    }
}