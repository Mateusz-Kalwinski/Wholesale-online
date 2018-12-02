<?php
//TODO zamienic name na prawdziwa nazwe
require_once dirname(dirname(__FILE__)).'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['idProduct']) and !empty($_POST['idProduct'])
        and isset($_POST['quantity']) and is_numeric($_POST['quantity']) and $_POST['quantity']>0){
        $id = $_POST['idProduct'];
        $quantity = $_POST['quantity'];
        $userID = $_SESSION['id'];

        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO cart (id_user, id_produkt, id_ilosc)";
        $stmt = $conn->prepare($query);
    }
}