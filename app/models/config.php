<?php
include_once 'Database.php';
class Config extends Database{
    public function getConfig($id){
        $sql = "SELECT *FROM config WHERE id = '$id'";
        return $this->query($sql);
    }
}
