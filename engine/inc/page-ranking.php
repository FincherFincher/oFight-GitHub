<?
    $tpl->load_template('page-ranking.tpl');
    $single = $tpl->copy_template;

    $data = $user->getRanking();
    $c = 1;

    $tplloop = true;
    foreach($data as $key => $pData){
        if($tplloop === true){
            $tpl->copy_template = str_ireplace("{NUMBER}", $c, $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{AVATAR}", $pData['avatar'], $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{NAME}", $pData['username'], $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{WIN}", $pData['wincount'], $tpl->copy_template);     
            $tpl->copy_template = str_ireplace("{DEF}", $pData['defeatcount'], $tpl->copy_template);      
            unset($tplloop);
        } else {
            $tpl->copy_template .= $single;
            $tpl->copy_template = str_ireplace("{NUMBER}", $c, $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{AVATAR}", $pData['avatar'], $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{NAME}", $pData['username'], $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{WIN}", $pData['wincount'], $tpl->copy_template);      
            $tpl->copy_template = str_ireplace("{DEF}", $pData['defeatcount'], $tpl->copy_template);      
        }
        $c++;
    }

    $tpl->compile('BOX');
    $tpl->clear();

    $tpl->load_template('page-ranking-box.tpl');
    $tpl->set('{RANKING}', $tpl->result['BOX']);


    $tpl->compile('main-part');
    $tpl->load_template('head.tpl') ;
    $tpl->set("{DESCRIPTION}", 'oFight.ru');
    $tpl->set("{KEYWORDS}", 'oFight.ru');

    $tpl->compile('head');

    $tpl->clear();
?>