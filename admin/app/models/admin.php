<?php
include_once 'Database.php';

class Admin extends Database{
    public function userData(){
        $sesion_id= $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE id={$sesion_id};";
        return $this->query($sql)[0];
    }
    
    public function checkUserReset($id,$key)
    {
        $sql="SELECT * FROM admin WHERE id={$id} AND `klucz`='{$key}';";
        return !empty($this->query($sql));
    }
    
    public function changePassword($id)
    {
        $getNewPasswordSql="SELECT
                `password_temporary` as `temp`
             FROM
                `admin`
             WHERE
                `id`={$id}
                ";
        $newPassword=$this->query($getNewPasswordSql)[0]['temp'];
        
        $swapPasswordsSql="
            UPDATE `admin` SET `password`='{$newPassword}',`password_temporary`='',`klucz`='' WHERE `id`={$id};
            ";
        $this->query($swapPasswordsSql);
                
    }
    
}
