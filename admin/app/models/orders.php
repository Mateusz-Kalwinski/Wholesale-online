<?php
ini_set('display_errors', 1);

require_once 'Database.php';
require_once 'mail.php';
require_once 'pdfModel.php';

class Orders extends Database{
    public function deleteOrder($id){
        $deleteOrderSql = "DELETE FROM `orders_history` WHERE `id` = '$id'";
        return $this->query($deleteOrderSql);
    }
    public function statusOrder($status ,$id){
        $statusOrderSql = "UPDATE `orders_history` SET `order_status` = '$status'
                           WHERE `id` = '$id'";
        return $this->query($statusOrderSql);
    }
    public function paidOrder($status, $id){
        $paidOrderSql = "UPDATE `orders_history` SET `order_paid` = '$status'
                           WHERE `id` = '$id'";
        return $this->query($paidOrderSql);
    }
    public function listOrder($id=false){
        $listOrderSql = "SELECT
                            *,`orders_history`.`id` AS 'id_order'
                         FROM `orders_history`
                         INNER JOIN `order_status` ON orders_history.order_status = order_status.id_status
                         INNER JOIN `order_paid` ON `orders_history`.`order_paid` = `order_paid`.`id_paid`
                         INNER JOIN `users` ON `orders_history`.`id_user` = `users`.`id`".($id!=false?" WHERE `orders_history`.`id_user`=".$id." ":'')."
                         ORDER BY `orders_history`.`order_date` DESC";
       return $this->query($listOrderSql);
    }
    public function listStatus(){
        $listStatusSql = "SELECT `order_status` FROM `orders_history`";
        return $this->query($listStatusSql);
    }
    public function listPaid(){
        $listPaidSql = "SELECT `order_paid` FROM `orders_history`";
        return $this->query($listPaidSql);
    }
    public function listShipment(){
        $listStatusSql = "SELECT * FROM `transport` INNER JOIN `payment` ON `transport`.`id`=`payment`.`id_parent`";
        return $this->query($listStatusSql);
    }
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Edycja Produktu------Edycja Produktu------Edycja Produktu------Edycja Produktu------Edycja Produktu---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function getProductFromOrder($id){
        //Wybiera produkty z zamówienia
        $getProductFromOrderSql = "SELECT `product` FROM `orders_history` WHERE `id` = '$id'";
        $productsFromOrder = $this->query($getProductFromOrderSql);
        if(!empty($productsFromOrder)) {
            $unserializeProduct = unserialize($productsFromOrder[0]['product']);


            return $unserializeProduct;
        }else{
            echo 'Nie ma takiego zamówienia';
        }
    }

    public function deleteProductFromOrder($id, $id_product){
        $products = $this->getProductFromOrder($id);
        foreach ($products as $key => $value){
            if ($value['id_produkt'] === $id_product){

                unset($products[$key]);
                $serializeProduct = serialize($products);
                $updateProductAfterDelete = "UPDATE `orders_history` SET `product` = '$serializeProduct'
                                             WHERE `id` = '$id'";
                $this->recountOrder($id);
                return $this->query($updateProductAfterDelete);
                die;
            }
        }
    }

    public function addProductFromOrder($id, $id_product, $quantity)
    {
        $getProductFromOrder = $this->getProductFromOrder($id);

        foreach($getProductFromOrder as $productFromOrder){
        if($productFromOrder['id_produkt'] == $id_product){
            $this->changeQuanity($id, $id_product, $quantity);
            exit();
        }
        }

        $getProductFromProductsSql = "SELECT
                                          *
                                          FROM `products`
                                          
                                          WHERE `id` = '$id_product'";


        $getProductFromProducts = $this->query($getProductFromProductsSql);
        if (!empty($getProductFromProducts)) {


            //zamiana klucza id na id_produkt
            //To jest potrzebne do usuwania produktów z zamówienia - metoda 'deleteProductFromOrder'

            $getProductFromProducts[0]['id_produkt'] = $getProductFromProducts[0]['id'];


            //dodanie klucza ilosc
            $quantityArr = ['ilosci' => $quantity];
            array_push($getProductFromProducts[0], $quantityArr['ilosci']);

            //usunięcie klucza 0 i zastąpienie go wcześniej utworzonym kluczem ilosc
            $getProductFromProducts[0]['ilosc'] = $getProductFromProducts[0]['0'];
            unset($getProductFromProducts[0][0]);
            echo'getProductFromProducts';


            //połączenie tablic w formie umożliwiającej ich późniejsze usuwanie i wyciąganie danych
            $getProductFromOrder[] = $getProductFromProducts[0];

            //serializacja tablicy
            $serializeProduct  = serialize($getProductFromOrder);

            //zapis zserializowanej tablicy do tabeli orders_history
            $updateProduct = "UPDATE `orders_history` SET `product` = '$serializeProduct'
                                             WHERE `id` = '$id'";
            $this->recountOrder($id);
            return $this->query($updateProduct);
            die;
        }else{
            echo 'Nie ma takiego produktu';
        }
    }

    public function recountOrder($id)
    {
        $pay=0;
        $order=$this->listOrder($id)[0];
        $products = $this->getProductFromOrder($id);
        $fig = (int) str_pad('1',3, '0');
        foreach ($products as $key => $product){
            $pay+=(ceil($product['price']*(100-$product['discount'])/100*(100-$order['user_discount'])/100 * $fig) / $fig)*$product['ilosc'];
             print_r($pay);
        }
       
        $shipmentPrice=0;
        preg_match_all('/\d+/', $order['shipment'], $shipmentPrice);
        print_r($shipmentPrice);
        $pay+=(int)$shipmentPrice[0];
        
        $updateProduct = "UPDATE `orders_history` SET `pay` = '$pay'
                                             WHERE `id` = '$id'";
            return $this->query($updateProduct);
    }
    
    public function changeQuanity($id, $id_product, $quanity){
        $getProductFromOrder = $this->getProductFromOrder($id);
        foreach ($getProductFromOrder as $key => &$value){
            if($value['id_produkt'] == $id_product){
                $value['ilosc'] =$quanity;
            }
        }
        $serializeProduct= serialize($getProductFromOrder);
        $updateProduct = "UPDATE `orders_history` SET `product` = '$serializeProduct'
                                             WHERE `id` = '$id'";
        $this->query($updateProduct);
        $this->recountOrder($id);
    }
    public function orderCorrection($id_order){
        $orderNumberSql = "SELECT `order_number`,`id_user` FROM `orders_history` WHERE `id` = '$id_order' LIMIT 1";
        $orderNumber = $this->query($orderNumberSql);
        $idUser=$orderNumber[0]['id_user'];
        $userMailSql = "SELECT `mail` FROM `users` WHERE `id` = '$idUser'";
        $userMail = $this->query($userMailSql);

        if(!empty($orderNumber && !empty($userMail))){
            $orderNumber = $orderNumber[0]['order_number'];
            $userMail = $userMail[0]['mail'];

            $explodeNumber = explode('/', $orderNumber);
            $savePFD = 'zamowienie-' . $explodeNumber[1] . '.pdf';
            $pdf = new pdfModel();
            $pdf->generatePDF($orderNumber, $savePFD);

            $mail = new Mail();
            $mail ->valueMail(6, $userMail, $orderNumber, $savePFD);
        }else{
            echo 'Nie ma takiego zamówienia';
        }
    }
    public function editOrder($id, $name, $place, $address, $code, $comment, $stanStatus, $stanPaid, $shipment){
        if (empty($comment)){
            $comment = ' - ';
        }
        $editOrderSql = "UPDATE `orders_history` SET
                                                `name` = '$name',
                                                `place` = '$place',
                                                `address` = '$address',
                                                `code` = '$code',
                                                `comment` = '$comment',
                                                `order_status` = '$stanStatus',
                                                `order_paid` = '$stanPaid',
                                                `shipment`='$shipment'
                                                WHERE `id` = '$id'";
        return $this->query($editOrderSql);
    }
}

