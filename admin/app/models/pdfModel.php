<?php ob_start();

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;



//require_once 'dompdf/lib/html5lib/Parser.php';
//require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
//require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
//require_once 'dompdf/src/Autoloader.php';

require_once 'OrdersHistoryAdmin.php';
class pdfModel extends OrdersHistoryAdmin
{

    public function generatePDF($orderId, $save = false){

        $orderDetails=$this->getOrder($orderId)[0];
        $products= @unserialize($orderDetails['product']);
        $sql = "SELECT * FROM config";
        $configQuery= $this->query($sql);
        $config=[];
        foreach($configQuery as $configItem)
        {
            $config[$configItem['key_word']]=$configItem['value'];
        }


//        require_once dirname(dirname(__FILE__)).'/assets/dompdf/autoload.inc.php';
        require_once  dirname(dirname(dirname(__FILE__))).'/app/assets2/dompdf/autoload.inc.php';
        $html = '<!DOCTYPE html>
        <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <style>
               body{font-family: \'dejavu sans\', sans-serif!important;} .redBar,.redDiv{background-color:#ff3d2e}*{font-family:Arial;
               margin:0;padding:0}.floatLeft{float:left}.fontSize18{font-size:16px}.fontSize13{font-size:13px}.fontSize12{font-size:12px}
               .fontSize11{font-size:11px}.fontSize8{font-size:8px}.whiteColor{color:#fff}.darkGreyColor{color:#4c5968}.greyColor{color:#8a95a1}
               .container{width:794px;height:auto;margin:auto}.order{padding:30px}.dataContent{width:210px}.orderContent{width:250px}
               .redDiv{height:107px}.orderNumber{height:50px;font-size:18px;}.orderValue{padding:30px 30px 105px 3px}.half{width:50%}
               .imgValue{margin-top:42px;margin-left:28px;margin-right:160px;width:115px;height:30px}.spaceBetweenDataContent{margin-right:48px}
               .justify{padding-top:34px}.textRight{text-align:right}table{margin-top:25px;border-collapse:collapse;width:100%;font-size:12px}
               td,th{font-weight:lighter;text-align:left;padding:8px 0}tr{border-bottom:1px solid #8a95a1}tr:last-child{border-bottom:none}
               .redBar{height:2px;margin-bottom:21px}
            </style>
        </head>
        <body>
           <div class="container">
               <div style="padding-bottom:20px;" class="redDiv">
                  <div class="floatLeft">
                    <img class="imgValue" src="'.$config['logo'].'">
                  </div>
                  <div class="whiteColor fontSize12 justify">
                   <div class="floatLeft dataContent spaceBetweenDataContent">
                       <p><b>'.$config['company_name'].'</b></p>
                       <p>'.$config['dane_adres'].'<br>'.$config['dane_kod'].' '.$config['dane_miejscowosc'].'</p>
                   </div>
                   <div class="floatLeft dataContent">
                       <p>NIP: '.$config['nip'].'</p>
                       <p>tel.: '.$config['dane_telefon'].'</p>
                       <p>e-mail: '.$config['dane_mail'].'</p>
                   </div>
                </div>
               </div>
               <div class="order">
               <div class="orderNumber darkGreyColor">
                   <div class="floatLeft half">
                       <h4 class="fontSize18">Zamówienie nr '.$orderDetails['order_number'].'</h4>    
                   </div>
                   <div class="floatLeft half">
                       <h5 class="textRight fontSize12">Data zamówienia: '.$orderDetails['order_date'].'</h5>
                   </div>
               </div>
               <div class="orderValue darkGreyColor">
                   <div style="width:245px;" class="orderContent fontSize12 floatLeft">
                       <h3>Dane do wysyłki:</h3>
                       <br>
                       <p>'.$orderDetails['name'].'</p>
                       <p>'.$orderDetails['address'].'</p>
                       <p>'.$orderDetails['code'].' '.$orderDetails['place'].'</p>
                   </div>
                   <div style="width:245px; margin-left:50px;" class="orderContent fontSize12 floatLeft">
                       <h3 style="white-space:nowrap;">Wybrana forma dostawy i płatnosci:</h3>
                       <br>
                       <p>'.$orderDetails['shipment'].'</p>
                   </div>
               </div>
               <hr>
                <table style="margin-top:150px;">
                  <tr>
                    <th class ="fontSize11 greyColor">Nazwa produktu</th>
                    <th style="text-align:center; width:120px;" class ="fontSize11 greyColor">Cena</th>
                    <th style="text-align:center; width:120px;" class ="fontSize11 greyColor">Ilość</th>
                    <th style="text-align:center; width:120px;" class ="fontSize11 greyColor">Wartość</th>
                  </tr>';

        $priceAll=0;
        foreach($products as $product)
        {
            $fig = (int) str_pad('1',3, '0');
            $price= (ceil($product['price']*(100-$product['discount'])/100*(100-$orderDetails['user_discount'])/100 * $fig) / $fig);

            $html.='
                  <tr>
                    <td style="border-top:1px solid #8a95a1;" class = "darkGreyColor fontSize13">'.$product['name'].'
                    <p class="greyColor fontSize11">'.$product['kod_produktu'].'</p></td>
                    <td style="border-top:1px solid #8a95a1; text-align:center; width:120px;" class = "darkGreyColor fontSize13">'.number_format($price,2).' zł</td>
                    <td style="border-top:1px solid #8a95a1; text-align:center; width:120px;" class = "darkGreyColor fontSize13">'.$product['ilosc'].' <span class="greyColor">'.$product['unit'].'</span></td>
                    <td style="border-top:1px solid #8a95a1; text-align:center; width:120px;" class = "darkGreyColor fontSize13">'.number_format($product['ilosc']*$price,2).' zł</td>
                  </tr>';
            $priceAll+=number_format($product['ilosc']*$price,2);
        }

        $html.='</table>
                <div class="redBar"></div>
                <p class="fontSize11 greyColor textRight">Razem: <span class="darkGreyColor fontSize18"><b>'.number_format($orderDetails['pay'],2).' zł</b></span></p>
            </div>
           </div>
        </body>
        </html>';

        $options = new Options();
        $options->set('defaultFont', 'dejavu sans');
        $options->set("isPhpEnabled", true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        if($save == false) {
            $dompdf->stream('zamowienie-' . explode('/', $orderDetails['order_number'])[1]);
        }else {
            $output = $dompdf->output();
            file_put_contents(dirname(dirname(dirname(__FILE__))).'/public/temp/'.$save.'', $output);
        }
    }
}