<?php
include_once 'Database.php';

class Notifications extends Database{
    public function notifications(){
        $sql= "SELECT title, text FROM notifications ORDER BY `id`;";
        return $this->query($sql);
    }
}