<?php
//TODO zamienic name na prawdziwa nazwe
require_once dirname(dirname(__FILE__)).'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['idProduct']) and !empty($_POST['idProduct'])
        and isset($_POST['quantity']) and is_numeric($_POST['quantity']) and $_POST['quantity']>0){
        $userID = $_SESSION['id'];
        $productID = $_POST['idProduct'];
        $quantity = $_POST['quantity'];

        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM cart WHERE id_produkt='$productID' and ilosc>0";

        $stmt = $conn->prepare($query);
        $error =$stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $all = $quantity + $result['ilosc'];

        if(!empty($result)){
            $sql = "UPDATE cart SET ilosc = '$all'";
            $stmt = $conn->prepare($sql);
            $error =$query->execute();
        }
        else{
            $sql = "INSERT INTO cart (id_user, id_produkt, id_ilosc) VALUES ('$userID', '$productID', '$quantity')";
            $stmt = $conn->prepare($sql);
            $error =$query->execute();
        }
    }
}