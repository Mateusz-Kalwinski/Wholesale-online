<?php
include_once 'Database.php';

class Menu extends Database{
    public function mainCategory(){
        $sql = "SELECT * FROM main_category";

        $mainCategory = $this->query($sql);
        foreach ($mainCategory as $key => &$value){

            $value['subcategories']=$this->subcategory($value["id"]);
        }
        return $mainCategory;
    }
    public function subcategory($mainCategory){
        $sql = "SELECT * FROM subcategories WHERE id_parent = {$mainCategory}";
        return $this->query($sql);
    }

}