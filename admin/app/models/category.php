<?php
require_once 'Database.php';

class Category extends Database{
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
    public function addCategory($name, $icon, $idParent) {
        $link = $name;
        $this->link($link);
        $addategorySql = "INSERT INTO `main_category`
                          (`name`, `link`, `icon`, `id_parent`)
                          VALUES ('$name', '$link', '$icon', '$idParent')";
        return $this->query($addategorySql);
    }
    public function deleteCategory($id){
        $productsFromCategorySql = "SELECT `id` FROM `products` WHERE `id_parent` = '$id'";
        $productsFromCategory = $this->query($productsFromCategorySql);
        if(empty($productsFromCategory)){
            $deleteCategorySql  = "DELETE FROM `main_category` WHERE `id` = '$id'";
            $isDelete =  $this->query($deleteCategorySql);
        }else{
            $isDelete = 'Nie można usunąć kategorii zawierającej produkty.';
        }
        return $isDelete;

    }
    public function editCategory($name, $icon, $idParent){
        $link = $name;
        $this->link($link);
        $editCategorySql = "UPDATE `main_category` SET `name` = '$name', `icon` = '$icon', `id_parent` = '$idParent'";
        return $this->query($editCategorySql);
    }
    public function listCategory($idParent=0)
    {
        $listCategorySql = "SELECT `id`, `name`, `icon`,`stan`, `id_parent` FROM `main_category` WHERE `id_parent`={$idParent} ORDER BY `sort`";
        $listCategory=$this->query($listCategorySql);

        foreach($listCategory as &$category)
        {
            $category['subcategories']=$this->listCategory($category['id']);
        }

        return $listCategory;
    }
}
