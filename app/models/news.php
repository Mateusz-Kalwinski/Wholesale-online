<?php

include_once 'Database.php';

class News extends Database{
    public function getNews(){
        $sql = "SELECT title, content, news_date FROM news WHERE `status`=1 ORDER BY news_date DESC";
        return $this->query($sql);
    }
}
