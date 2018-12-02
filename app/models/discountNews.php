<?php

include_once 'Database.php';
class DiscountNews extends Database{
    public function newsProducts(){
        $sql = "SELECT products.id, products.name, link, description, price, discount, quanityInStock, units.unit as unit, cart.ilosc
                FROM products
                INNER JOIN units ON products.unit = units.id
                 LEFT JOIN `cart`
                            ON `cart`.`id_produkt`=`products`.`id`
                WHERE news = '1' ORDER BY products.id";
        return $this->query($sql);
    }
    
    public function discountProducts(){
        $sql = "SELECT products.id, products.name, link, description, price, discount, quanityInStock, units.unit as unit, cart.ilosc
                FROM products 
                INNER JOIN units ON products.unit = units.id
                 LEFT JOIN `cart`
                            ON `cart`.`id_produkt`=`products`.`id`
                WHERE discount > '0' ORDER BY discount DESC";

        return $this->query($sql);
    }
}
