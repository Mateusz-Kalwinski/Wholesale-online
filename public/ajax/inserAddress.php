<?php

ini_set('display_errors',1);
session_name('user');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
require_once dirname(dirname(__FILE__)).'/config.php';

if('REQUEST_METHOD' ==="POST"){
    if(!empty($_POST['nazwa']) and !empty($_POST['adres']) and! empty($_POST['kod']) and !empty($_POST['miasto']) and !empty($_POST['telefon']) and
        is_string($_POST['nazwa']) and is_string($_POST['miasto'])){

        $name = $_POST['nazwa'];
        $address = $_POST['adres'];
        $code  = $_POST['kod'];
        $city = $_POST['miasto'];
        $phone = $_POST['telefon'];

        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = $_SESSION['id'];
        $query = "UPDATE shipment SET nazwa ='$name', adres = '$address', kod = '$code', miasto ='$city', telefon = '$phone'";
        $stmt = $conn->prepare($query);
        $error = $stmt->execute();
       }else{
           echo '0';
       }
}