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
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST)){
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_SESSION['id'];
        $data =json_decode($_POST['products'], true);
        for($i = 0; $i<sizeof($data); $i++){
        $productID = $data[$i]['id'];
        $quantity = $data[$i]['quanity'];
            if(!empty($quantity) and $quantity>0){
            $query = "SELECT * FROM cart WHERE id_produkt='$productID' and ilosc>0 and id_user = '$id'";

                $stmt = $conn->prepare($query);
                $error =$stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


                if(!empty($result)){

                    $sql = "UPDATE cart SET ilosc = '$quantity' WHERE id_produkt = '$productID' and id_user = '$id'";
                    $stmt = $conn->prepare($sql);
                    $error =$stmt->execute();
                }
                else{
                    $sql = "INSERT INTO cart (id_user, id_produkt, ilosc) VALUES ('$id', '$productID', '$quantity')";
                    $stmt = $conn->prepare($sql);
                    $error =$stmt->execute();
                }
            }
       }
   }
}