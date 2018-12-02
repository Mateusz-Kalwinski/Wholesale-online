<?php
ini_set('display_errors', 1);
require_once 'Database.php';

class Clients extends Database{

    public function searchClient(){
        $url = substr($_GET['url'], 21);
        $searchClientSql = "SELECT `id`, `username`, `nip`, `mail`
                FROM `users`
                WHERE `username` LIKE '%$url%' OR `nip` LIKE '%$url%' OR `mail` LIKE '%$url%'";
        return $this->query($searchClientSql);
    }
    public function addClient($username, $discount, $place, $code, $address, $nip, $mail, $phone, $status) {
        $addClientSql = "INSERT INTO `users`
                        (`username`, `discount`, `dane_miejscowosc`, `dane_kod`, `dane_adres`, `nip`, `mail`, `telefon`, `status`)
                        VALUES ('$username', '$discount', '$place', '$code', '$address', '$nip', '$mail', '$phone', '$status')";
        return $this->query($addClientSql);
    }
    public function deleteClient($id){
        $deleteClientSql = "DELETE FROM `users` WHERE `id` = '$id'";
        return $this->query($deleteClientSql);
    }
    public function editClient($id, $username, $discount, $place, $code, $address, $mail, $phone, $status){
        $editClientSql = "UPDATE users SET `username` = '$username', `discount` = '$discount', `dane_miejscowosc` = '$place',
                          `dane_kod` = '$code', `dane_adres` = '$address', `mail` = '$mail', `telefon` = '$phone', `status`='$status'
                          WHERE `id` = $id";
        return $this->query($editClientSql);
    }
    public function banClient($status, $id){
        $banClientSql = "UPDATE users SET `status` = '$status' WHERE `id` = '$id'";
        return $this->query($banClientSql);
    }
    public function listClients(){
        $listClientsSql = "SELECT
                             `dane_adres`,
                             `dane_miejscowosc`,
                             `dane_kod`,
                             `discount`,
                             `status`,`id`,
                             `username`,
                             `nip`,
                             `telefon`,
                             `mail`
                         FROM `users`";
        $listClients=$this->query($listClientsSql);
        
        foreach($listClients as &$client)
        {
            $client['orders']=$this->sumOrders($client['id']);
        }
        return $listClients;
    }
    public function sumOrders($userID){
        $sumOrdersSql = "SELECT SUM(`pay`) as `price`, COUNT(`name`) AS `countOrders` FROM orders_history WHERE `id_user` = '$userID'";
        return $this->query($sumOrdersSql)[0];
    }
    
        public function addressesOfClient($id)
    {
        $addressesSql="SELECT * FROM `shipment` WHERE `id_user`={$id}";
        return $this->query($addressesSql);
    }
}