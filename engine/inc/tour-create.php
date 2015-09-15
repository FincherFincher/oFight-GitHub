<?php
    $tpl->load_template('tour-create.tpl');
    $tpl->compile('main-part');
    $tpl->clear();

    $tpl->load_template('head.tpl') ;
    $tpl->set("{DESCRIPTION}", 'oFight.ru');
    $tpl->set("{KEYWORDS}", 'oFight.ru');

    $tpl->compile('head');

    $tpl->clear();
?>