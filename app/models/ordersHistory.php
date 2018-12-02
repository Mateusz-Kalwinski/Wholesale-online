<?php

include_once 'Database.php';

class OrdersHistory extends Database {
    public function getOrder($order_number=false){
        $idLimitSql='';
        $id = $_SESSION['id'];
        $nipSql="SELECT `nip` from `users` WHERE `id`={$id}";
        $nip=$this->query($nipSql)[0]['nip'];
        
        if($order_number!==false)
        {
            $idLimitSql=" AND `order_number`='{$nip}/{$order_number}' ";
        }
        
        $sql = "SELECT * FROM orders_history
                INNER JOIN `order_status` ON orders_history.order_status = order_status.id_status
                INNER JOIN `order_paid` ON `orders_history`.`order_paid` = `order_paid`.`id_paid`
                WHERE id_user = '$id' {$idLimitSql} ORDER BY orders_history.order_date DESC";
        return $this->query($sql);
    }
}

