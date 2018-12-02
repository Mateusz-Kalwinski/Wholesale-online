
<?php
//ini_set('display_errots', 1);
require_once dirname(dirname(__FILE__)).'/assets/PHPMailer-master/src/Exception.php';
require_once dirname(dirname(__FILE__)).'/assets/PHPMailer-master/src/PHPMailer.php';
require_once dirname(dirname(__FILE__)).'/assets/PHPMailer-master/src/SMTP.php';
require_once 'Database.php';
require_once 'config.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail extends Database{
    
    public function valueMail($id, $recipient, $value = false, $atachment = false){
        
        //Dane z tabeli config do maila
        $configSql = "SELECT * FROM config";
        $configVal = $this->query($configSql);
        $configColorMail  = $configVal[12]['value'];
        $companyName = $configVal[9]['value'];
        $nip = $configVal[7]['value'];
        $address = $configVal[5]['value'];
        $place = $configVal[4]['value'];
        $code = $configVal[3]['value'];
        $mail = $configVal[2]['value'];
        $phone = $configVal[1]['value'];
        $logo = $configVal[0]['value'];
        
        //dane z tabeli messages do obsługi maila
        $sql = "SELECT `text`, `topic`, `isHTML` FROM `messages` WHERE id = $id";
        $val = $this->query($sql)[0];
        $subject = $val['topic'];
        $textMail = $val['text'];
        $html = $val['isHTML'];
        
        if($value !== false){
            $text = str_replace("%value%", $value, $textMail);
        }
        else {
            $text = $textMail;
        }
        
        $css = "<head><style>*{font-family: Arial;}.container {width: 100%;height: auto;margin:auto;}
            .redDiv {background-color: $configColorMail;width: 100%;height: 65px;}.logo{width: 115px;margin-top: 20px;margin-left: 20px;}
            .space{margin-bottom: 60px;}.darkGrayColor {color: #232e3d !important;}.content{margin-top:50px;margin-left: 50px;}
            .bar{width: 100%;height: 4px;background-color: #d3d5d8;}.dataContent{width: 250px;}
            .floatLeft{float: left;}h3{font-size: 18px;color: $configColorMail;margin-bottom: 25px;}p{font-size: 14px;color: #4c5968;}</style></head>";
        
//        if($body2 !== null){
//            $val['text'] .= '<br>'.$body2;
//        }
        if($html == 1){
            $body = '<html>'.$css.'<body>
	<div class="container">
		<div class="redDiv">
			<img src='.$logo.' class="logo" alt="">
		</div>
		<div class="content space">
			'.$text.'
		</div>
		<div class="bar"></div>
		<div class="content">
			<div class="dataContent floatLeft">
				<p class="darkGrayColor"><b>'.$companyName.'</b><p>
				<p>ul.'.$address.'<br>'.$code.' '.$place.'</p>
			</div>
			<div class="dataContent floatLeft">
				<p>NIP: '.$nip.'</p>
				<p>tel.: '.$phone.'<br>e-mail: '.$mail.'</p>
			</div>
		</div>
	</div>
</body>
</html>';
            $html = true;
        }else{
            $body = $text;
            $html = false;
            $breaks = array("<br />","<br>","<br/>");
            $body = str_ireplace($breaks, "\r\n", $body); 
            $body = strip_tags($body);
        }

        if($atachment == false) {
            $this->sendMail($recipient, $subject, $body, $html);
        }else{
            $this->sendMail($recipient,$subject, $body, $html, $atachment);
        }
    }
    
    public function sendMail($recipient, $subject, $body, $html, $atachment = false){
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        //$mail->isSMTP();
        $mail->Host = 'mail.test.pl';
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->Username = 'kontotest@test.pl';
        $mail->setFrom('kontotest@test.pl', 'TEST');
        $mail->Password = 'UjAPCFRQAq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->addAddress($recipient);
        $mail->Subject  = $subject;
//        Body wielką literą
        $mail->Body = $body;
        $mail->isHTML($html);
        if($atachment == true) {
            $mail->addAttachment(dirname(dirname(dirname(__FILE__))).'/public/temp/'.$atachment.'');
            $mail->send();
            unlink(dirname(dirname(dirname(__FILE__))).'/public/temp/'.$atachment.'');
        }else{
            $mail->send();
        }
    }
}
//$mail = new Mail();
//$mail->sendMail("mateuszkalwinski97@gmail.com", "Subject", "Content", true);
