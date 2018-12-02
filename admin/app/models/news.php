<?php
require_once 'Database.php';

class News extends Database{
    public function addNews($title, $content, $status){
        $date =date('Y-m-d');
        $addNewsSql = "INSERT INTO `news` (`title`, `content`, `news_date`, `status`)
                       VALUES ('$title', '$content', '$date', $status)";
        return $this->query($addNewsSql);
    }
    public function deleteNews($id){
        $deleteNewsSql = "DELETE FROM `news` WHERE `id` = '$id'";
        return $this->query($deleteNewsSql);
    }
    public function editNews($id, $title, $content, $status, $date){

        $date=implode('-',array_reverse(explode('.',$date)));
        $editNewsSql = "UPDATE `news` SET `title` = '$title', `content` = '$content', `news_date` = '$date', `status` = '$status' WHERE `id`={$id}";
        return $this->query($editNewsSql);
    }
    
    public function listNews(){
        $listNewsSql = "SELECT * FROM `news` ORDER BY `news_date`";
        return $this->query($listNewsSql);
    }
    
   public function changeNewsStatus($id,$status){
        $editNewsSql = "UPDATE `news` SET  `status` = '$status' WHERE `id`={$id}";
        return $this->query($editNewsSql);
    }
}