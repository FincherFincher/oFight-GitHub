<?php
    if($user->isAuth()){
        $uinfo = $user->info();
        setcookie('username', $uinfo['username'], 0, '/chat');
        setcookie('img', $uinfo['avatar'], 0, '/chat');
    }

    /***********************
                      Short News Preview
                                ***********************/





// Механика карт

    $data = $news->getGuidesById(2);
    $tpl->load_template('module-guides.tpl');
    $single = $tpl->copy_template;
    $tplloop = true;
    foreach($data as $key => $guides){
        if($tplloop === true){
            $tpl->copy_template = str_ireplace("{GUIDENAME}", $guides['guidename'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{GUIDEIMG}", $guides['guideimg'], $tpl->copy_template);
            unset($tplloop);
        } else {
            $tpl->copy_template .= $single;
            $tpl->copy_template = str_ireplace("{GUIDENAME}", $guides['guidename'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{GUIDEIMG}", $guides['guideimg'], $tpl->copy_template);
        }
    }
    $tpl->compile('cardmechanics');
    $tpl->clear();

    



    $data = $news->getAnyNewsNumbers(0, 2);
    $tpl->load_template('module-shortnews.tpl');
    $single = $tpl->copy_template;
    $tplloop = true;
    foreach($data as $key => $dNews){
        if($tplloop === true){
            $tpl->copy_template = str_ireplace("{IMAGE}", $dNews['picture'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{TITLE}", $dNews['title'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{ATITLE}", $dNews['title'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{AUTHOR}", $dNews['author'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{DATE}", date('d M Y', strtotime($dNews['date'])), $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{PREVTEXT}", $dNews['prevtext'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{VIEWS}", $dNews['views'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{LINK}", $dNews['urlname'], $tpl->copy_template);
            unset($tplloop);
        } else {
            $tpl->copy_template .= $single;
            $tpl->copy_template = str_ireplace("{IMAGE}", $dNews['picture'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{TITLE}", $dNews['title'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{ATITLE}", $dNews['title'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{AUTHOR}", $dNews['author'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{DATE}", date('d M Y', strtotime($dNews['date'])), $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{PREVTEXT}", $dNews['prevtext'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{VIEWS}", $dNews['views'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{LINK}", $dNews['urlname'], $tpl->copy_template);
        }
    }
    $tpl->compile('shortnewspreviewbox');
    $tpl->clear();



    $tpl->load_template('chat.tpl');
    $tpl->set('{SHORTNEWSPREVIEWBOX}', $tpl->result['shortnewspreviewbox']);   
    $tpl->set('{CARDMECHANICS}', $tpl->result['cardmechanics']);   
    $tpl->compile('main-part');
    $tpl->clear();

    $tpl->load_template('head.tpl') ;
    $tpl->set("{DESCRIPTION}", 'oFight.ru');
    $tpl->set("{KEYWORDS}", 'oFight.ru');

    $tpl->compile('head');

    $tpl->clear();
?>