<?php

require_once 'Database.php';

class units extends Database{
    public function getUnits(){
        $getUnitsSql = "SELECT * FROM `units`";
        return $this->query($getUnitsSql);
    }
}