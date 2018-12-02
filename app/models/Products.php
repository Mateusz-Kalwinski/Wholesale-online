<?php
include_once 'Database.php';

class Products extends Database{
    
   
    private function getPath($categoryId)
    {
        $categorySql="SELECT * FROM `main_category` WHERE `id`={$categoryId}";
        $category=$this->query($categorySql)[0];
        
        
        if($category['id_parent']==0)
        {
            return $category;
        }
        else
        {
            $category[]=$this->getPath($category['id_parent']);
        }
        
        return $category;
    }
    
    protected function getProductPhotos($productId)
    {
        $photosSql="SELECT * FROM `photos` WHERE `id_parent`={$productId} ORDER BY `main_photo` DESC, `sort` ASC";
        return $this->query($photosSql);
    }
    
    public function getProduct($productId)
    {
        $productSql="SELECT
                        `products`.*,
                        `units`.`unit` as `unit`,
                        `cart`.`ilosc` as `quanity`
                      FROM 
                        `products`
                         INNER JOIN `units` ON `products`.`unit`=`units`.`id`
                         
                        LEFT JOIN `cart`
                            ON `cart`.`id_produkt`=`products`.`id`
                       WHERE `products`.`id`={$productId}";
        $product=$this->query($productSql)[0];
        $product['path']=$this->getPath($product['id_parent']);
        $product['photos']=$this->getProductPhotos($productId);
        
        return $product; 
    }
    
    private function getProducts($categoryId)
    {
                $id = $_SESSION['id'];
        $categoryChildrenSql="SELECT `id` FROM `main_category` WHERE `id_parent`={$categoryId}";
        $categoryChildren=$this->query($categoryChildrenSql);
        
        $categories=$categoryId;
        
        foreach($categoryChildren as $categoryChild)
        {
            $categories.=', '.$categoryChild['id'];
        }
        
        $productsSql="SELECT
                        `products`.*,
                        `units`.`unit` as `unit`,
                        `cart`.`ilosc` as `quanity`
                      FROM `products`
                      INNER JOIN `units` ON `products`.`unit`=`units`.`id`
                      INNER JOIN `main_category` ON `products`.`id_parent` = `main_category`.`id`
                      LEFT JOIN `cart` ON `cart`.`id_produkt`=`products`.`id`
                      WHERE `products`.`id_parent` IN ({$categories}) and `main_category`.`stan` = '1' and (`cart`.`id_user` = '$id' OR `cart`.`id_user` IS NULL)";

        $products=$this->query($productsSql);

        foreach($products as &$product)
        {
            $product['photos']=$this->getProductPhotos($product['id']);
        }
        return $products;
    }

    public function newsProducts()
    {
        $id = $_SESSION['id'];
        $newsProductsSql = "SELECT products.id, products.name, products.kod_produktu, products.link, description, price, discount, quanityInStock,
                            reservation, units.unit as unit, cart.ilosc
                            FROM products
                            INNER JOIN units ON products.unit = units.id
                            INNER JOIN `main_category` ON `products`.`id_parent` = `main_category`.`id`
                            LEFT JOIN `cart`
                                        ON `cart`.`id_produkt`=`products`.`id`
                            WHERE news = '1' and `main_category`.`stan` = '1' and (`cart`.`id_user` = '$id' OR `cart`.`id_user` IS NULL) ORDER BY products.id";

        $products = $this->query($newsProductsSql);

        foreach($products as &$product)
        {
            $product['photos']=$this->getProductPhotos($product['id']);
        }
        return $products;
    }

    public function  discountProducts(){
        $id = $_SESSION['id'];
        $discountProductsSql = "SELECT products.id, products.name, products.kod_produktu, products.link, description, price, discount, quanityInStock, reservation, units.unit as unit, cart.ilosc
                FROM products 
                INNER JOIN units ON products.unit = units.id
                INNER JOIN `main_category` ON `products`.`id_parent` = `main_category`.`id`
                LEFT JOIN `cart`
                            ON `cart`.`id_produkt`=`products`.`id`
                WHERE discount > '0' and `main_category`.`stan` = '1' and (`cart`.`id_user` = '$id' OR `cart`.`id_user` IS NULL) ORDER BY discount DESC ";
        $products = $this->query($discountProductsSql);

        foreach($products as &$product)
        {
            $product['photos']=$this->getProductPhotos($product['id']);
        }
        return $products;
    }

    public function getSearch(){
        $id = $_SESSION['id'];
        $url = $_GET['url'];
        $url = substr($url,12);
        $searchSql = "SELECT products.id, products.name, products.kod_produktu, link, description, price, discount, quanityInStock, reservation, units.unit as unit, cart.ilosc
                FROM products
                INNER JOIN units ON products.unit = units.id
                LEFT JOIN `cart`
                            ON `cart`.`id_produkt`=`products`.`id`
                WHERE products.name LIKE '%$url%'and (`cart`.`id_user` = '$id' OR `cart`.`id_user` IS NULL) ORDER BY products.id";
        $products = $this->query($searchSql);

        foreach ($products as &$product){
            $product['photos']= $this->getProductPhotos($product['id']);
        }
        return $products;
    }

    
    public function getProductsByCategory($categoryId,$categoryLink=FALSE)
    {
        $mainCategorySql="SELECT * FROM main_category WHERE id='{$categoryId}' ORDER BY id ASC";
        
        $mainCategory=$this->query($mainCategorySql)[0];
        
        $subCategoriesSql = "SELECT * FROM main_category WHERE id_parent = '{$categoryId}' ORDER BY id ASC";
        $subCategories =  $this->query($subCategoriesSql);
        
        if(empty($subCategories))
        {
            $mainCategory['products']=$this->getProducts($categoryId);
        }
        else
        {
            foreach($subCategories as $subCategory)
            {
                $mainCategory['subcategories'][]=$subCategory+['products'=>$this->getProducts($subCategory['id'])];
            }
        }
        
        return $mainCategory;
    }
}