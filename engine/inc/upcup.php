<?php



    $tpl->load_template('page-upcup.tpl');
    $tpl->compile('main-part');
    $tpl->clear();



    //include_once(ROOT_DIR . '/engine/lib/simple_html_dom.php');
    //$html = file_get_html('http://www.upweek.ru/magazine');
    //$html->clear();
    //unset($html);



    $tpl->load_template('head.tpl') ;





    $tpl->set("{DESCRIPTION}", 'Турниры UPCUP от журнала UPgrade.ru | UPweek.ru');
    $tpl->set("{KEYWORDS}", 'Турниры UPCUP от журнала UPgrade.ru | UPweek.ru');

    $tpl->compile('head');

    $tpl->clear();
?>