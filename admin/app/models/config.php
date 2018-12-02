<?php

require_once 'Database.php';

class Config extends Database{
    
    public function getAll()
    {
        $sql = "SELECT *FROM config WHERE `key_word` != 'mail_kolor'";
        return $this->query($sql);
    }
    
    public function editConfig($id, $value)
    {
        $editConfigSql = "UPDATE `config` SET `value` = '$value' WHERE `id` = '$id'";
        return $this->query($editConfigSql);

    }
    public function getConfig($id)
    {
        $sql = "SELECT *FROM config WHERE id = '$id'";
        return $this->query($sql);
        }
}