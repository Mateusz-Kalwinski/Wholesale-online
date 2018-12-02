<?php
require_once dirname(dirname(dirname(__FILE__))).'/app/models/mail.php';

require_once dirname(dirname(__FILE__)).'/config.php';
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(empty($_POST['password']) and strlen($_POST['password'])<6){
        echo '4';
        exit();
    }
    if(!empty($_POST['mail']) and is_string($_POST['mail']) and !empty($_POST['password']) and is_string($_POST['password']) and strlen($_POST['password']) >=6){
        
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $userMail = $_POST['mail'];
        $password_temporary = $_POST['password'];
        
        if(isset($_POST['currentPassword'])){
        $password_curent = $_POST['currentPassword'];
        $query1 ="SELECT password FROM users WHERE mail = '$userMail'";
        $stmt1 = $conn->prepare($query1);
        $error1 = $stmt1->execute();
      
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result1) or !password_verify($password_curent, $result1[0]['password'])){
                echo '1';
                exit();
            }
        }        
        $password_temporary = password_hash($password_temporary, PASSWORD_DEFAULT);
        
        //randomowy string 
        function randomString($length = 16) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
        }
        //dodanie klucza do baz
        $query1 = "UPDATE users SET klucz = '".randomString()."', password_temporary = '$password_temporary' WHERE mail = '$userMail'";
        $stmt1 = $conn->prepare($query1);
        $error1 = $stmt1->execute();
        
        //pobranie klucza z bazy
        $query2 = "SELECT klucz, mail, id FROM users WHERE mail ='$userMail'";
        $stmt2 = $conn->prepare($query2);
        $error2 = $stmt2->execute();
        $result1 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
       //zmienne do funkcji maila
        if(!empty($result1)){
        $id = $result1[0]['id'];
        $klucz = $result1[0]['klucz'];
        $recipient = $result1[0]['mail'];
        $link = $_SERVER['SERVER_NAME'].'/'.'reset'.'/'.$id.'/'.$klucz;
        
        //sprawdzanie czy mail z posta nie jest rowny z tym z bazy danych
        
        if($recipient !== $userMail){
            echo '1';
        }
        else{
            $mail = new Mail();
            $mail->valueMail(1, $recipient, $link);
            echo '3';
        }
        } else {
            //zapytanie zwraca pusta tablice
            echo'1';
        }
    } else {
        //nie przechodzi walidacji
        //pusty POST
        echo '1';
    }

} else {
    echo '1';
}
