<?php
session_name('user');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
require_once dirname(dirname(__FILE__)).'/config.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(!empty($_POST['id']  and $_POST['id'] !== 0 )){
        $id = $_POST['id'];
        $userId = $_SESSION['id'];
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query2 = "DELETE FROM cart WHERE id_produkt = '$id' and id_user = '$userId'";
        $stmt2= $conn->prepare($query2);
        $error2 = $stmt2->execute();
        echo '0';
    }
    else {
        echo '1';    
    }
}