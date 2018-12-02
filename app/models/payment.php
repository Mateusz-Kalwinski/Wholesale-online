<?php

require_once 'Database.php';

class Payment extends Database{
    public function getPayment(){
        $sql = "SELECT *,`payment`.`id` AS `paymentId`,
            `transport`.`id` AS `transportId`
            FROM payment
            INNER JOIN transport ON payment.id_parent = transport.id
            WHERE id_parent = transport.id ORDER BY payment.sort";
        return $this->query($sql);
    }
}
