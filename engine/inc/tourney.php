<?php

    if(!isset($this->url_path[1]))
    {
        header("Location: / ");
    }


    if($tour->getTourinfo($this->url_path[1]))
    {
        $tData = $tour->getTourinfo($this->url_path[1]);
        $uData = $user->userinfo($_SESSION['username']);
        $tStatus = $tour->tourStatus($_SESSION['username'], $tData);


        /***********************
                               ADMIN's
                                    ***********************/

            $tpl->load_template('tourney-admins.tpl');
            $single = $tpl->copy_template;
            $admins = explode(",", $tData['touradmin']);

            $tplloop = true;
            foreach($admins as $key => $admin){
                if($tplloop === true){
                    $tpl->copy_template = str_ireplace("{TOURADMIN}", $admin, $tpl->copy_template);
                    unset($tplloop);
                } else {
                    $tpl->copy_template .= $single;
                    $tpl->copy_template = str_ireplace("{TOURADMIN}", $admin, $tpl->copy_template);
                }
            }

            $tpl->compile('ADMINBOX');
            $tpl->clear();



        /***********************
                            Registration Form
                                    ***********************/

        if($tStatus == 'fregOpen')
        {
            if($tData['tourgame'] == 'Hearthstone')
            {
                if( $tData['tourtype'] == 'Regular' )
                {
                    $tpl->load_template('module-tourney-reg-from-HS-regular.tpl');
                    $tpl->compile('REGISTRATIONFORM');
                    $tpl->clear();
                }
                if( $tData['tourtype'] == 'Random' )
                {
                    $tpl->load_template('module-tourney-reg-from-HS-random.tpl');
                    $tpl->compile('REGISTRATIONFORM');
                    $tpl->clear();
                }    
            }
            if($tData['tourgame'] == 'Starcraft')
            {
                $tpl->load_template('module- tourney-reg-from.tpl');
                $tpl->compile('REGISTRATIONFORM');
                $tpl->clear();
            }
        }

        $tpl->load_template('tourney.tpl');


        $tpl->set('{TOURID}',  $tData['id']);
        $tpl->set('{TOURNAME}',  $tData['tourname']);
        $tpl->set('{TOURDATE}',  date("d M", strtotime($tData['tourdate'])));
        $tpl->set('{TOURTIMESTART}',   date("H:i", strtotime($tData['tourdate'])));
        $tpl->set('{TOURTIMEREG}',   date("H:i", strtotime($tData['tourdate']) - 60 * 60 * 2));
        $tpl->set('{TOURMOD}',  $tData['tourmod']);
        $tpl->set('{TOURMODINFO}',  $config['tourmod'][$tData['tourmod']]);
        $tpl->set('{TOURPRIZE}',  $tData['tourprize']);
        $tpl->set('{TOURRULES}',  urldecode($tData['tourrules']));
        $tpl->set('{TOURLOGO}',  urldecode($tData['tourlogo']));
        $tpl->set('{ADMINS}', $tpl->result['ADMINBOX']);
        $tpl->set('{TOURBLOCKMID}', $tData['tourtext']);
        $tpl->set('{TOURBLOCKRIGHT}', $tData['tourtext2']);

        $tpl->set('{TOURSTATUS}',  $config['tourPageStatus'][$tStatus]);


    //------> Tour Status

        if(substr($tStatus, 0, 4) != 'freg')
        {
            $playersArrPre = $tour->getPreRegPlayers($tData['id']);
            $players = 'Уже записались ('.count($playersArrPre).'): ';
            foreach($playersArrPre as $key => $val){
               $players = $players.$val.', ';
            }
        }

        if($tStatus == 'started' || substr($tStatus, 0, 4) == 'freg')
        {
            $playersArr = $tour->getRegPlayers($tData);
            $players = 'Участники ('.count($playersArr).'): ';
            foreach($playersArr as $key => $val){
               $players = $players.$val.', ';
            }
        }

        $tpl->set('{TOURPLAYERS}', $players);

        if($tStatus == 'fregOpen')
        {
            $tpl->set('{TOURSTATUSOPTION}', $tpl->result['REGISTRATIONFORM']);   
        } else {
            $tpl->set('{TOURSTATUSOPTION}', $config['tourPageStatusOption'][$tStatus]);
        } 
        
    } else {
        
        if($tour->getPastTourByiD($this->url_path[1]))
        {

    //------> Archive    

            $tData = $tour->getPastTourByiD($this->url_path[1]);
            $uData = $user->userinfo($_SESSION['username']);
            $tStatus = $tour->tourStatus($_SESSION['username'], $tData);

            $tpl->load_template('tourney.tpl');

            $tpl->set('{TOURID}',  $tData['id']);
            $tpl->set('{TOURNAME}',  $tData['tourname']);
            $tpl->set('{TOURDATE}',  date("d M", strtotime($tData['tourdate'])));
            $tpl->set('{TOURTIMESTART}',   date("H:i", strtotime($tData['tourdate'])));
            $tpl->set('{TOURTIMEREG}',   date("H:i", strtotime($tData['tourdate']) - 60 * 60 * 2));
            $tpl->set('{TOURMOD}',  $tData['tourmod']);
            $tpl->set('{TOURMODINFO}',  $config['tourmod'][$tData['tourmod']]);
            $tpl->set('{TOURPRIZE}',  $tData['tourprize']);
            $tpl->set('{TOURRULES}',  urldecode($tData['tourrules']));
            $tpl->set('{TOURLOGO}',  urldecode($tData['tourlogo']));
            $tpl->set('{ADMINS}', $tpl->result['ADMINBOX']);
            $tpl->set('{TOURBLOCKMID}', $tData['tourtext']);
            $tpl->set('{TOURBLOCKRIGHT}', $tData['tourtext2']);
            $tpl->set('{TOURSTATUSOPTION}', '');
            
            $tWinner = $user->getTourWinner($tData);
            $pCount = $tour->getTourPlayersInArchive($tData);
            $pC = max(100, max($pCount['COUNT(*)'], ($pCount['COUNT(*)'] + 35)));
            
            
            $tpl->set('{TOURPLAYERS}', 'Победитель турнира <a href="/user/profile/'.$tWinner['username'].'">'.$tWinner['username'].'</a>, а в эвенте участовало более ' . $pC .  ' игроков');
            
            $tpl->set('{TOURSTATUS}',  $config['tourPageStatus']['tourEnd']);

        } else {
            header("Location: / ");
        }
        
    }













    $this->mainTitle = 'oFight.ru';
    $tpl->compile('main-part');
    $tpl->load_template('head.tpl');
    $tpl->set("{DESCRIPTION}", 'oFight.ru');
    $tpl->set("{KEYWORDS}", 'oFight.ru');
    $tpl->compile('head');
?>