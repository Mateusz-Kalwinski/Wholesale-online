<?php


class Database
{
    protected $userName='dataapplication';
    protected $dbName='dataapplication';
    protected $password='VIXDXBt08M';
    protected $host='localhost';
    protected $db=false;
    protected $mysql = null;
    private  $logTable = 'cms_log';
    
    private function connect()
    {  
        if(!$this->db)
        {
               $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName.';charset=utf8', $this->userName, $this->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
               $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $this->db->exec("set names utf8;");
        }
    }
    
    protected function updateUserLocation()
    {
        if(isset($_SESSION['url'])&& isset($_SESSION['id']))
        {
             $sql="
                UPDATE
                    `users`
                SET
                    `url`='{$_SESSION['url']}'
                WHERE
                    `id`={$_SESSION['id']}
             ";
            $this->db->query($sql);
        }
      
    }
    
    public function query($sql)
    {
        $this->connect();
        //$query=$this->db->prepare($sql);
        //$query->execute();
        //$queryResult=$query->fetchAll(PDO::FETCH_ASSOC);
        //$this-> mysql("SELECT test");
        $this->updateUserLocation();
        return $this-> mysql($sql);
       //  $queryResult;
    }

    /**
     * Kontener globalny dla zapytań SQL.
     * @param string $sql
     * @param string|int|null &$lastId
     * @return PDO
     */

    public function mysql($sql, &$lastId = null)
    {
        
        try {
            if (strpos($sql, 'SELECT') !== FALSE) {
                $r = $this->db->query($sql);
            } else {
                $r = $this->db->exec($sql);
            }

            if (!$r) {
                $this->db->errorInfo();
            }

            $lastId = $this->db->lastInsertId();

            if (strpos($sql, 'SELECT') !== 0 && strpos($sql, 'cms_log') === false) {
                $backtrace = debug_backtrace();
                $idUser=isset($_SESSION['id'])?$_SESSION['id']:'-2';
                $logStmt = $this->db->prepare("INSERT INTO `".$this->logTable."` SET `id_user` = '{$idUser}', `file` = :file, `line` = '{$backtrace[0]['line']}', `zapytanie` = :sql, `ip` = '{$_SERVER['REMOTE_ADDR']}', `data` = NOW()");
                $logStmt->execute(array(':sql' => $sql, ':file' => $backtrace[0]['file']));
            }
            else
            {
              if($r)
              {
                return $r->fetchAll(PDO::FETCH_ASSOC);   
              }
              else
              {
                  return $r;
              }
              
            }

            

        } catch (PDOException $e) {
            $backtrace = debug_backtrace();
            $logStmt = $this->db->prepare("INSERT INTO `".$this->logTable."` SET `id_user` = '-1', `file` = :file, `line` = '0', `zapytanie` = :sql, `ip` = '{$_SERVER['REMOTE_ADDR']}', `data` = NOW()");
            $logStmt->execute(array(':sql' => $sql, ':file' => $backtrace[0]['file']));
            
        }
    }

}




