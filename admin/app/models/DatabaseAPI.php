<?php


class DatabaseAPI
{
    protected $userName='api';
    protected $dbName='api';
    protected $password='igj@oww2r6';
    protected $host='localhost';
    protected $db=false;

    private function connect()
    {
        if(!$this->db)
        {
            $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName.';charset=utf8', $this->userName, $this->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
