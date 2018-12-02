<?php
session_name('admin');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
require_once dirname(dirname(__FILE__)).'/config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['mail']) && !empty($_POST['password'])){
        $mail = $_POST['mail'];
        $password= $_POST['password'];

        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SelectAdminSql = "SELECT `id`, `username`, `password`, `mail`, `url` FROM `admin` WHERE `mail` = '$mail'";
        $SelectAdminStmt = $conn->prepare($SelectAdminSql);
        $SelectAdminExec = $SelectAdminStmt->execute();
        $SelectAdminResult = $SelectAdminStmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($SelectAdminResult)){
            $hash = $SelectAdminResult[0]['password'];
            $passwordVerify = password_verify($password, $hash);
            if(!$passwordVerify){
                echo '0';
            }else{
                $_SESSION['id'] = $SelectAdminResult[0]['id'];
                echo '1';
                $url = $SelectAdminResult[0]['url'];
                $url =  substr($url,3);
                echo $url;
            }
        }

    }
}