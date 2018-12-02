<?php

include_once 'Database.php';

class Shipment extends Database{
    public function address($id){
        $sql = "SELECT nazwa, adres, kod, miasto, telefon FROM shipment WHERE id_user = '$id'";
        return $this->query($sql);
    }
}