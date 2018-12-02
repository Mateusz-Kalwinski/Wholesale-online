
<?php

include_once 'Database.php';
class Cart extends Database{
    public function getCart() {
        $id = $_SESSION['id'];
        $sql = "SELECT `cart`.*, `products`.*, `units`.`unit` FROM `cart` 
                INNER JOIN `products` ON `cart`.`id_produkt` = `products`.`id`
                INNER JOIN `units` ON `units`.`id`=`products`.`unit`
                WHERE cart.id_user = '$id'";
        return $this->query($sql);
    }
}
