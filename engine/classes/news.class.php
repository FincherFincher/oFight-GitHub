<?php

    class News{
        
        function __construct()
        {
            $this->db = new DB();
            $this->db = $this->db->connect();
        }
        
        function getLastNews()
        {
            $newsSelect = $this->db->query("SELECT * FROM oFight_news ORDER BY id DESC");
            return $newsSelect->fetchAll();
        }
        
        function getAnyNewsNumbers($limStart, $limEnd)
        {
            
            $sql = " SELECT * FROM  oFight_news ORDER BY id DESC LIMIT " . $limStart . " ," . $limEnd ;
            
            
            return $this->db->query($sql)->fetchAll();
        }
        
        function getNews($url)
        {
            $data = $this->db->query(" SELECT * FROM oFight_news WHERE urlname = '$url' ");
            return $data->fetch();
        }
        
        function addView($url)
        {
            $this->db->query(" UPDATE oFight_news SET views = views + 1 WHERE urlname = '$url' ");
        }
        
        
        function updNews($id,$title, $pic, $prevtext, $maintext, $author){
            $nUpdate = $this->db->prepare("UPDATE oFight_news SET title = ?, picture = ?, prevtext = ?, maintext = ?, author = ? WHERE `id` = ?");
            if(!$nUpdate->execute(array($title, $pic, $prevtext, $maintext, $author, $id))){
                return false;
            }
            return true;
        }
        
        function getNewsIdByURL($url)
        {
            $query = $this->db->prepare(" SELECT id FROM oFight_news WHERE urlname = ? ");
            $query->execute(array($url));
            return $query->fetch(PDO::FETCH_COLUMN);       
        }
        
        function addComment($nid, $user, $text){
            $addComment = $this->db->prepare("INSERT INTO oFight_comments (newsid, author, text, date) VALUES (?, ?, ?, NOW())");
            if(!$addComment->execute(array($nid, $user, $text))){
                return false;
            }
            return true;
        }
        
        function getComments($nid){
            $selectAllComments = $this->db->prepare("SELECT * FROM oFight_comments WHERE newsid = ? ORDER BY `id` DESC");
            $selectAllComments->execute(array($nid));
            $comments = $selectAllComments->fetchAll();
            
            return $comments;
            
        }
        
        function getModeratedNews()
        {
            return $this->db->query(" SELECT * FROM oFight_news_M ORDER BY id ASC ")->fetchAll(PDO::FETCH_ASSOC);
        }
        
        function createNews($titlename, $picture, $title, $description, $keywords, $urlname, $prevtext, $maintext, $category, $author)
        {
            $query = $this->db->prepare(" INSERT INTO oFight_news_M (titlename, picture, title, description, keywords, urlname, prevtext, maintext, category, author) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
            $query->execute(array($titlename, $picture, $title, $description, $keywords, $urlname, $prevtext, $maintext, $category, $author));
            return true;
        }
        
        function moderateNews($id, $titlename, $picture, $title, $description, $keywords, $urlname, $prevtext, $maintext, $category, $author)
        {
            $query = $this->db->prepare(" INSERT INTO oFight_news (titlename, picture, title, description, keywords, urlname, prevtext, maintext, category, author) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
            $query->execute(array($titlename, $picture, $title, $description, $keywords, $urlname, $prevtext, $maintext, $category, $author));
            $this->db->query(" DELETE FROM oFight_news_M WHERE id = '".$id."' ");
            return true;
        }
        
        

        function getGuidesById($quantity)
        {
            $sql = " SELECT id FROM oFight_news WHERE guidesgame = 'Hearthstone' order by rand() limit " . $quantity;
            return $this->db->query($sql);  
        }
        

        
    }

?>