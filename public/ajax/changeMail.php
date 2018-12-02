<?php
ini_set('display_errors',1);
session_name('user');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
require_once dirname(dirname(dirname(__FILE__))).'/app/models/mail.php';
require_once dirname(dirname(__FILE__)).'/config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['mail']) and is_string($_POST['mail']) and !empty($_POST['phone']) and strlen($_POST['phone']) >=9){
        $userMail = $_POST['mail'];
        $phone = $_POST['phone'];
        $id = $_SESSION['id'];
        
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query1 = "SELECT mail FROM users WHERE id = '$id'";
        $stmt1 = $conn->prepare($query1);
        $error1 = $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        if(empty($result1)){
            echo"1";
        }else{
        $currentMail = $result1[0]['mail'];
        $phone = $result1[0]['telefon'];
        
        $query2 = "UPDATE users SET telefon = '$phone', mail = '$userMail' WHERE id = '$id'";
        $stmt = $conn->prepare($query2);
        $error = $stmt->execute();
//        wysyłanie maila przy jego zmianie
//        $mail = new Mail();
//        $mail->valueMail(2, $currentMail, $userMail);
//        $mail1 = new Mail();
//        $mail1->valueMail(2, $userMail, $userMail);
        }
    }else{
        //nie przechodzi walidacji
        //pusty string
        echo '0';
    }
}
