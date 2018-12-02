<?php
require_once 'Database.php';

class Categories extends Database{
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
    public function addCategory($name, $idParent) {
        $link = $name;
        $this->link($link);
        $addategorySql = "INSERT INTO `main_category`
                          (`name`, `link`,  `id_parent`)
                          VALUES ('$name', '$link',  '$idParent')";
        return $this->query($addategorySql);
    }
    public function deleteCategory($id){
        $deleteCategorySql  = "DELETE FROM `main_category` WHERE `id` = '$id'";
        return $this->query($deleteCategorySql);
    }
    public function editCategory($name,$id,$state,$idParent){
        $link = $name;
        $this->link($link);
        $editCategorySql = "UPDATE `main_category` SET `name` = '$name',`id_parent`={$idParent}, `stan`={$state} WHERE `id`={$id}";
        return $this->query($editCategorySql);
    }
    public function listCategory(){
        $listCategorySql = "SELECT `id`, `name`, `icon`, `id_parent` FROM `main_category` ORDER BY `sort` ASC";
        return $this->query($listCategorySql);
    }
    
    public function reorderCategories($categoryListJson)
    {
        ini_set('display_errors',1);
        $categoryListDecoded= json_decode($categoryListJson, true);
        
        $sql='';
        foreach($categoryListDecoded as $categoryParent=>$categoriesInOrder)
        {

            foreach($categoriesInOrder as $order=>$category)
            {
                $sort=$order+1;
                $sql.="UPDATE `main_category` SET `id_parent`={$categoryParent}, `sort`={$sort} WHERE `id`={$category};";
            }
        }
        
        print_r($sql);
        
        $this->query($sql);
        
    }
}