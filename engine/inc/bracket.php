<?php

    if(!isset($this->url_path[1])){
        header("Location: / ");
    }

   $tpl->load_template('bracket.tpl');
   $this->mainTitle = '1oFight.ru';
   $tpl->compile('main-part');
   $tpl->load_template('head.tpl');
   $tpl->set("{DESCRIPTION}", 'oFight.ru');
   $tpl->set("{KEYWORDS}", 'oFight.ru');
   $tpl->compile('head');
?>