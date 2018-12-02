<?php
ini_set("display_errors", 1);
require_once dirname(dirname(__FILE__)).'/config.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['keywords']) and strlen($_POST['keywords']) > 2) {
        $keywords = $_POST['keywords'];

        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DBNAME . ";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT name, link, id FROM products WHERE name LIKE '%{$keywords}%'
                  OR description LIKE '%{$keywords}%'
                  OR products.kod_produktu LIKE  '%{$keywords}%'";
        $stmt = $conn->prepare($query);
        $error = $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    }
}

