<?php
    
    if(!isset($this->url_path[1])){
        header("Location: / ");
    }

    if(!isset($_COOKIE['viewed'])){
        setcookie("viewed", "yes", time()+3600*24, "/news/".$this->url_path[1]);
        $news->addView($this->url_path[1]);
    }



    $nInfo = $news->getNews($this->url_path[1]);
    $allComments = $news->getComments($this->url_path[1]);
    if($allComments[0] != '') {
        $tpl->load_template('comments.tpl');
        $singleComment = $tpl->copy_template;
        $new = 1;
        foreach($allComments as $key => $val){
            $getUserInfo = $user->ainfo($val['author']);
            if($new === 1){
                $tpl->copy_template = str_ireplace("{AVATAR}", $getUserInfo['avatar'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{NAME}", $val['author'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{COMMENT}", $val['text'], $tpl->copy_template);
                $new = 2;
            } else {
                $tpl->copy_template .= $singleComment;
                $tpl->copy_template = str_ireplace("{AVATAR}", $getUserInfo['avatar'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{NAME}", $val['author'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{COMMENT}", $val['text'], $tpl->copy_template);
            }
        }
    }

    $tpl->compile('comments');
    $tpl->clear();
    
    $tpl->load_template('full-news.tpl');
    $this->mainTitle = $nInfo['title'];
    $tpl->set("{UNAME}", $_SESSION['username']);
    $tpl->set("{IMAGE}", $nInfo['picture']);
    $tpl->set("{TITLE}", $nInfo['titlename']);
    $tpl->set("{AUTHOR}", $nInfo['author']);
    $tpl->set("{DATE}", $nInfo['date']);
    $tpl->set("{VIEWS}", $nInfo['views']);
    $tpl->set("{FULLSTORY}", $nInfo['maintext']);
    $tpl->set("{COMMENTS}", $tpl->result['comments']);
    $tpl->set("{AVATAR}", $_SESSION['uinfo']['avatar']);
    $tpl->compile('main-part');

    $tpl->clear();

    $tpl->load_template('head.tpl');
    $tpl->set("{DESCRIPTION}", $nInfo['description']);
    $tpl->set("{KEYWORDS}", $nInfo['keywords']);

    $tpl->compile('head');

    $tpl->clear();



?>