<?php

include_once 'Database.php';

class OrdersHistoryAdmin extends Database {
    public function getOrder($orderNumber=false){



        $sql = "SELECT * FROM orders_history
                INNER JOIN `order_status` ON orders_history.order_status = order_status.id_status
                WHERE `id`={$orderNumber} ORDER BY orders_history.order_date DESC";
        return $this->query($sql);
    }
}