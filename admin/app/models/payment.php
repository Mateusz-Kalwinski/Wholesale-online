<?php

require_once 'Database.php';

class payment extends Database{
    public function addShipment($name, $comment, $status){
        $addShipmentSql = "INSERT INTO `shipment` 
                                       ON (`name`, `comment`, status)
                                       VALUES ('$name', '$comment', '$status')";
        return $this->query($addShipmentSql);
    }
    public function editShipment($id, $name, $comment, $status){
        $editShipment = "UPDATE `shipment`
                         SET `name` = '$name', `comment` = '$comment', `status` = '$status' 
                         WHERE `id` ='$id'";
        return $this->query($editShipment);
    }
    public function listDelivery(){
        $listShipmentSql = "SELECT `name` FROM `shipment` WHERE `status` = '1'";
        return $this->query($listShipmentSql);
    }
    public function addPayment($method_payment, $delivery_price_1, $delivery_price_2, $free_delivery, $sort, $stan, $id_parent){
        $addPaymentSql = "INSERT INTO `payment` ON (`method_payment`,
                                                   `delivery_price_1`,
                                                   `delivery_price_2`,
                                                   `free_delivery`),
                                                   `sort`,
                                                   `stan`,
                                                   `id_parent`)
                                                   VALUES ('$method_payment',
                                                           '$delivery_price_1',
                                                           '$delivery_price_2',
                                                           '$free_delivery',
                                                           '$sort',
                                                           '$stan',
                                                           '$id_parent')";
        return $this->query($addPaymentSql);
    }
    public function editPayment($id, $method_payment, $delivery_price_1, $delivery_price_2, $free_delivery, $sort, $stan, $id_parent){
        $editPaymentSql = "UPDATE `payment` SET `method_payment` = '$method_payment',
                                                `delivery_price_1` = '$delivery_price_1',
                                                `delivery_price_2` = '$delivery_price_2',
                                                `free_delivery` = '$free_delivery',
                                                `sort` = '$sort',
                                                `stan` = '$stan',
                                                `id_parent` = '$id_parent'
                                                WHERE `id` = '$id'";
        return $this->query($editPaymentSql);
    }
    public function listPayment(){
        $listPaymentSql = "SELECT * FROM `payment`";
        return $this->query($listPaymentSql);
    }
}