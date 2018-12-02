<?php

require_once dirname(dirname(__FILE__)).'/config.php';
echo 'cokolwiek';
        $mail = 'mateuszkalwinski97@gmail.com';
        $password= 'admin';
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $hashPassword = password_hash("$password", PASSWORD_DEFAULT);
        $SelectAdminSql = "UPDATE `admin` SET `password` = '$hashPassword'";
        $SelectAdminStmt = $conn->prepare($SelectAdminSql);
        $SelectAdminExec = $SelectAdminStmt->execute();
