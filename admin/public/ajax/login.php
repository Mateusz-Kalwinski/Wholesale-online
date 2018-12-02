<?php
session_name('admin');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
require_once dirname(dirname(__FILE__)).'/config.php';

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['mail']) and strlen($_POST['mail'])>0 and
       isset($_POST['password']) and strlen($_POST['password'])>0)
    {
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query1 = "SELECT * FROM users WHERE mail = '$mail'";
        $stmt1 = $conn->prepare($query1);
        $error1 = $stmt1->execute();
        
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)[0];
        $hash = $result1['password'];
        $passwordHash = password_verify($password, $hash);        
       
        if (!$passwordHash){
            echo"0"; // nie ma użykownika
        }
        else{
            $_SESSION['id'] = $result1['id'];
            if ($result1['status'] == '1'){
                echo '1';
                $_SESSION['status'] = 1;
                $url = $result1['url'];
                $url =  substr($url,3);
                echo $url;
            }
            else{
                echo "2";
                $_SESSION['status'] = 2;
            }
        }
    }
    
    else {
        echo '0';
    }
}