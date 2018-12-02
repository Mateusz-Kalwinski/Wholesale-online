<?php

class Database
{
    protected $userName='dev-10';
    protected $dbName='dev-10';
    protected $password='ztxpmup9CVTrLbSK';
    protected $host='localhost';
    protected $db=false;

    private function connect()
    {
        if(!$this->db)
        {
            $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName.';charset=utf8', $this->userName, $this->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $this->db->exec("set names utf8;");
        }
    }

    public function query($sql)
    {
        $this->connect();
        $query=$this->db->prepare($sql);
        $query->execute();
        $queryResult=$query->fetchAll(PDO::FETCH_ASSOC);

        return $queryResult;
    }
}