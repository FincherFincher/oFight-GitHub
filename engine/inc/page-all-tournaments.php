<?



    $data = $tour->getFutureTour();
    if(!empty($data))
    {
        $tpl->load_template('page-all-tournaments.tpl');
        $single = $tpl->copy_template;
        $tplloop = true;
        foreach($data as $key => $tData){
            if($tplloop === true){
                $tpl->copy_template = str_ireplace("{TOURNEYNAME}", $tData['tourname'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURNEYLOGO}", urldecode($tData['tourlogo']), $tpl->copy_template);            
                $tpl->copy_template = str_ireplace("{TOURNEYDATE}", date("d M", strtotime($tData['tourdate'])), $tpl->copy_template);            
                $tpl->copy_template = str_ireplace("{TOURNEYPRIZE}", $tData['tourprize'], $tpl->copy_template);     
                $tpl->copy_template = str_ireplace("{TOURNEYID}", $tData['id'], $tpl->copy_template);      
                unset($tplloop);
            } else {
                $tpl->copy_template .= $single;
                $tpl->copy_template = str_ireplace("{TOURNEYNAME}", $tData['tourname'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURNEYLOGO}", urldecode($tData['tourlogo']), $tpl->copy_template);            
                $tpl->copy_template = str_ireplace("{TOURNEYDATE}", date("d M", strtotime($tData['tourdate'])), $tpl->copy_template);            
                $tpl->copy_template = str_ireplace("{TOURNEYPRIZE}", $tData['tourprize'], $tpl->copy_template);     
                $tpl->copy_template = str_ireplace("{TOURNEYID}", $tData['id'], $tpl->copy_template);         
            }
        }
        $tpl->compile('futuretour');
        $tpl->clear();
    }



    $data = $tour->getPastTour();
    $tpl->load_template('page-all-tournaments.tpl');
    $single = $tpl->copy_template;
    $tplloop = true;
    foreach($data as $key => $tData){
        if($tplloop === true){
            $tpl->copy_template = str_ireplace("{TOURNEYNAME}", $tData['tourname'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{TOURNEYLOGO}", urldecode($tData['tourlogo']), $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{TOURNEYDATE}", date("d M", strtotime($tData['tourdate'])), $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{TOURNEYPRIZE}", $tData['tourprize'], $tpl->copy_template);     
            $tpl->copy_template = str_ireplace("{TOURNEYID}", $tData['id'], $tpl->copy_template);          
            unset($tplloop);
        } else {
            $tpl->copy_template .= $single;
            $tpl->copy_template = str_ireplace("{TOURNEYNAME}", $tData['tourname'], $tpl->copy_template);
            $tpl->copy_template = str_ireplace("{TOURNEYLOGO}", urldecode($tData['tourlogo']), $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{TOURNEYDATE}", date("d M", strtotime($tData['tourdate'])), $tpl->copy_template);            
            $tpl->copy_template = str_ireplace("{TOURNEYPRIZE}", $tData['tourprize'], $tpl->copy_template);     
            $tpl->copy_template = str_ireplace("{TOURNEYID}", $tData['id'], $tpl->copy_template);           
        }
    }
    $tpl->compile('pasttour');
    $tpl->clear();


    $tpl->load_template('page-all-tournaments-box.tpl');
    $tpl->set('{FUTURETOURNEY}', $tpl->result['futuretour']);
    $tpl->set('{PASTTOURNEY}', $tpl->result['pasttour']);




    $tpl->compile('main-part');
    $tpl->load_template('head.tpl') ;
    $tpl->set("{DESCRIPTION}", 'oFight.ru');
    $tpl->set("{KEYWORDS}", 'oFight.ru');

    $tpl->compile('head');

    $tpl->clear();
?>