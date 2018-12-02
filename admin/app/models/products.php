<?php
require_once 'Database.php';

class Products extends Database{

    public function link($link,$separator='-')
    {
        $link = html_entity_decode($link);
        $link = mb_strtolower($link,'UTF-8');
        $szukaj = array('ż','ź','ć','ń','ą','ś','ł','ę','ó');
        $zamieniaj = array('z','z','c','n','a','s','l','e','o');
        $link = str_replace($szukaj, $zamieniaj, $link);
        preg_match_all('/[a-zA-Z0-9]+/', $link, $out);
        $link2 = null; foreach ($out[0] as $value) $link2 .= $value.$separator;
        return substr($link2, 0, -1);
    }

    public function searchProduct(){
        $url = substr($_GET['url'], 22);
        $searchProductSql = "SELECT `name` FROM `products`
                             WHERE `name` LIKE '%$url%' OR `description` LIKE '%$url%' OR `kod_produktu` LIKE '%$url%'";
        return $this->query($searchProductSql);
    }
    public function addProduct($name, $description, $price, $discount, $quanityInStoct, $reservation, $id_parent, $news, $status, $unit, $product_code){
        $date = date('Y-m-d');
        $link = $name;
        $this->link($link);
        $addProductsSql = "INSERT INTO `products`
                           (`name`, `link`, `description`, `price`, `discount`, `quanityInStock`, `reservation`,
                            `id_parent`, `add_date`, `news`, `status`, `unit`, `kod_produktu`)
                            VALUES ('$name', '$link', '$description', '$price', '$discount', '$quanityInStoct', '$reservation', '$id_parent',
                            $date, '$news', '$status', '$unit', '$product_code')";
        return $this->query($addProductsSql);
    }
    public function deleteProduct($id){
        $deleteProductSql = "DELETE FROM products WHERE `id` = '$id'";
        return $this->query($deleteProductSql);
    }

    public function editProduct($id, $name, $description, $price, $discount, $quanityInStock, $reservation, $id_parent, $news, $status, $unit, $product_code){
        $link = $name;
        $this->link($link);
        $editProductSql = "UPDATE products SET `name` = '$name', `link` = '$link', `description` = '$description', `price` = '$price',
                           `discount` = '$discount', `quanityInStock` = '$quanityInStock', `reservation` = '$reservation', `id_parent` = '$id_parent',
                           `news` = '$news', `status` = '$status', `unit` = '$unit', `kod_produktu` = '$product_code'
                           WHERE `id` = '$id'";
        return $this->query($editProductSql);
    }
    public function addToNewsProduct($id, $news){
        $addToNewsProductsSql = "UPDATE `products` SET `news` = '$news'
                                 WHERE `id` = '$id'";
        return $this->query($addToNewsProductsSql);
    }
    public function addDiscountProduct($id, $discount){
        $addDiscountProductSql = "UPDATE products SET `discount` = '$discount'
                                  WHERE `id` = '$id'";
        return $this->query($addDiscountProductSql);
    }
    public function changeStatus($id, $status){
        $changeStatusSql = "UPDATE `products`
                            SET `status` = '$status'
                            WHERE `id` = '$id'";
        return $this->query($changeStatusSql);
    }
    public function listProducts(){
        $listProductSql = "SELECT 
                            *   
                           FROM `products`";
        return $this->query($listProductSql);
    }

    public function addPhotoForProduct($idProduct, $imageFile, $sort){

        $randomImageFileName = "";
        $characters = array_merge(range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < 7; $i++) {
            $rand = mt_rand(0, $max);
            $randomImageFileName.= $characters[$rand];
        }
        print_r($imageFile);
        $fileExtension = explode('.', $imageFile['name'])[1];
        $randomImageFileName = $randomImageFileName.'.'.$fileExtension;
        move_uploaded_file($imageFile['tmp_name'], dirname(dirname(dirname(dirname(__FILE__)))).'/public/images/products/'.$randomImageFileName);

        $mainPhotoSql = "SELECT `main_photos` FROM `photos` WHERE `id_parent` = '$idProduct'";
        $mainPhoto = $this->query($mainPhotoSql);
        if(empty($mainPhoto)){
            $main = 1;
        }else{
            $main = 0;
        }
        $addPhotoForProductSql = "INSERT INTO `photos`
                                  (`link`, `id_parent`, `sort`, `main_photo`)
                                  VALUES ('$randomImageFileName', $idProduct, $sort, $main);";
        print_r($addPhotoForProductSql);
        return $this->query($addPhotoForProductSql);
    }
    public function sortPhoto($photos)
    {
        foreach($photos as $photo)
        {
           $sortPhotoSql = "UPDATE `photos` SET `sort` = '{$photo['sort']}' WHERE `id` = {$photo['id']}"; 
           print_r($sortPhotoSql);
           $this->query($sortPhotoSql);
        }
    }
    public function setMainPhoto($id ,$idProduct){
        $selectProductSql = "SELECT `link`, `id_parent` FROM `photos` WHERE `id_parent` = '$idProduct'";
        $selectProduct = $this->query($selectProductSql);
        $setMainPhotoOnSql = "UPDATE `photos` SET `main_photo` = '1' WHERE `id` = '$id'";

        if(empty($selectProduct)){
            return $this->query($setMainPhotoOnSql);
        }else{
            foreach ($selectProduct as $value){
                $setMainPhotoOffSql = "UPDATE `photos` SET `main_photos` = '0' WHERE `id_parent` = ".$value['id_parent'].";";
                $this->query($setMainPhotoOffSql);
            }
            return $this->query($setMainPhotoOnSql);
        }
    }
    public function deletePhoto($id){
        $selectPhotoSql = "SELECT `link` FROM `photos` WHERE `id` = '$id'";
        $selectPhoto = $this->query($selectPhotoSql)[0];

        $fileName = $selectPhoto['link'];
        unlink(dirname(dirname(dirname(dirname(__FILE__)))).'/public/images/products/'.$fileName);

        $deletePhotoSql = "DELETE FROM `photos` WHERE `id` = '$id'";
        $this->query($deletePhotoSql);
    }
    
    public function listPhotos($idProduct)
    {
        $photosListSql="SELECT * FROM `photos` WHERE `id_parent`={$idProduct} ORDER BY `sort`";
        $photosList=$this->query($photosListSql);
        return $photosList;
    }

}