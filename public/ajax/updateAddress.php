<?php
ini_set('display_errors',1);
session_name('user');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();
ini_set('display_errors', 1);
require_once dirname(dirname(__FILE__)).'/config.php';
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(!empty($_POST['nazwa']) and (!empty($_POST['adres']) and !empty($_POST['kod']) and !empty($_POST['miasto']) and !empty($_POST['telefon']) or $_POST['option']==='2')){
       
        $name = $_POST['nazwa'];
        $address = $_POST['adres'];
        $code  = $_POST['kod'];
        $city = $_POST['miasto'];
        $phone = $_POST['telefon'];
        $option = $_POST['option'];

        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = $_SESSION['id'];
        if($option === '2'){
            $query2 = "DELETE FROM shipment WHERE nazwa = '$name' and id_user = '$id'";
            $stmt2 = $conn->prepare($query2);
            $error2 = $stmt2->execute();
        }else{
        $query1 = "SELECT nazwa FROM shipment WHERE nazwa = '$name' and id_user = '$id'";
        $stmt1 = $conn->prepare($query1);
        $error1 = $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        
        if(empty($result1) or $option==1){
            if($option === '0'){
            $query = "INSERT INTO shipment (nazwa, adres, kod, miasto, telefon, shipment.id_user)
            VALUES ('$name', '$address', '$code', '$city', '$phone', '$id')";
            echo'0';
            }
            else{
            $query = "UPDATE shipment SET `nazwa` ='$name', `adres` = '$address', `kod` = '$code', `miasto` ='$city', `telefon` = '$phone', `id_user` = '$id' WHERE `nazwa` = '$name' and `id_user` = '$id'";
            echo'0';

            }
            $stmt = $conn->prepare($query);
            $error = $stmt->execute();
        }
        else{
            echo '2';
        }
        
    }}
    else{
           echo '1';
    }
}