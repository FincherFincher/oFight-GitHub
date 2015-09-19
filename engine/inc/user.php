<?php

    if(empty($_SESSION['username']) && empty($this->url_path[1])){
        header("Location: / ");
    }


    if(empty($this->url_path[1])){
        header("Location: /user/profile ");
    }

    if(!in_array($this->url_path[1], array("profile", "CreateTourney", "AdminTourney", "ModerationTourney", "Admin" , "CreateNews", "ModerNews"))){
        header("Location: /user/profile ");
    }

    /***********************
                       User Profile
                                ***********************/
    if($this->url_path[1] == 'profile'){
        
        if(empty($_SESSION['username']) && empty($this->url_path[2])){
            header("Location: / ");
        }

        $this->mainTitle = 'Профайл на oFight';
        if(empty($this->url_path[2]) || ($_SESSION['username'] == $this->url_path[2])){
            
            $tpl->load_template('user-personal.tpl');
            $tpl->compile('USERBLOCK1');
            $tpl->clear();
            $tpl->load_template('user.tpl');
            $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
            $tpl->set('{USERBLOCK2}', '');
            $tpl->set('{USERBLOCK3}', '');            
            $tpl->set('{USERBLOCK4}', '');
            
            $uName = $_SESSION['username'];
            $uDate = $user->userinfo($uName);
            $tpl->set('{AVATAR}',  '/uploads/avatars/'.$uDate['avatar']);
            $tpl->set('{BTAG}',  $uDate['bnettag']);
            $tpl->set('{VKCOM}',  $uDate['vkcom']);
        }else{
            
            $tpl->load_template('user-other.tpl');
            $tpl->compile('USERBLOCK1');
            $tpl->clear();
            $tpl->load_template('user.tpl');
            $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
            $tpl->set('{USERBLOCK2}', '');
            $tpl->set('{USERBLOCK3}', '');            
            $tpl->set('{USERBLOCK4}', '');
            
            
            $uName = $this->url_path[2];  
            $uDate = $user->userinfo($uName);
            
            if(empty($uDate['bnettag'])){
                $uDate['bnettag'] = 'Не указан';
            }
            
            if(empty($uDate['vkcom'])){
                $uDate['vkcom'] = 'Не указан';
            }
            
            $tpl->set('{AVATAR}',  '/uploads/avatars/'.$uDate['avatar']);
            $tpl->set('{BTAG}',  $uDate['bnettag']);
            $tpl->set('{VKCOM}',  $uDate['vkcom']);
        }
        
        $tpl->set('{HSRANK}',  $user->getRankingByUser($uName)[1]); 
        
        $tpl->set('{HSGAMECOUNT}',  ($uDate['wincount'] + $uDate['defeatcount'])); 
        $tpl->set('{HSWINRATE}', ((round($user->divisionInt($uDate['wincount'], ($uDate['wincount'] + $uDate['defeatcount']))*100, 0)).'%') ); 

        
        $user->getRankingByUser($uName);
      
        
    }











    /***********************
                      Create news
                                ***********************/

    if($this->url_path[1] == 'CreateNews')
    {
        $this->mainTitle = 'Турниры на oFight';
        
        $tpl->load_template('user-create-news.tpl');
        $tpl->compile('USERBLOCK1');
        $tpl->clear();

        $tpl->load_template('user-upload.tpl');
        $tpl->compile('USERBLOCK2');
        $tpl->clear();
        
        $tpl->load_template('user.tpl');
        $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
        $tpl->set('{USERBLOCK2}', $tpl->result['USERBLOCK2']); 
        $tpl->set('{USERBLOCK3}', '');            
        $tpl->set('{USERBLOCK4}', '');
    }





    /***********************
                      Moder news
                                ***********************/

    if($this->url_path[1] == 'ModerNews')
    {
        $this->mainTitle = 'Турниры на oFight';
        

        
        $arr = $news->getModeratedNews();
        
        if(!empty($arr))
        {
            $tpl->load_template('user-moder-news.tpl');
            $single = $tpl->copy_template;

            $tplloop = true;
            foreach($arr as $key => $elem){
                if($tplloop === true){
                    $tpl->copy_template = str_ireplace("{ID}", $elem['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{NAME}", $elem['titlename'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{PIC}",  urldecode($elem['picture']), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TITLE}", $elem['title'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{DESCR}", $elem['description'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{KEYW}", $elem['keywords'], $tpl->copy_template);      
                    $tpl->copy_template = str_ireplace("{URL}", $elem['urlname'], $tpl->copy_template);       
                    $tpl->copy_template = str_ireplace("{PREV}", $elem['prevtext'], $tpl->copy_template);     
                    $tpl->copy_template = str_ireplace("{MAIN}", $elem['maintext'], $tpl->copy_template);          
                    $tpl->copy_template = str_ireplace("{CATEGORY}", $elem['category'], $tpl->copy_template);  
                    $tpl->copy_template = str_ireplace("{AUTHOR}", $elem['author'], $tpl->copy_template);     
                    unset($tplloop);
                } else {
                    $tpl->copy_template .= $single;
                    $tpl->copy_template = str_ireplace("{ID}", $elem['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{NAME}", $elem['titlename'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{PIC}", urldecode($elem['picture']), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TITLE}", $elem['title'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{DESCR}", $elem['description'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{KEYW}", $elem['keywords'], $tpl->copy_template);      
                    $tpl->copy_template = str_ireplace("{URL}", $elem['urlname'], $tpl->copy_template);       
                    $tpl->copy_template = str_ireplace("{PREV}", $elem['prevtext'], $tpl->copy_template);     
                    $tpl->copy_template = str_ireplace("{MAIN}", $elem['maintext'], $tpl->copy_template);          
                    $tpl->copy_template = str_ireplace("{CATEGORY}", $elem['category'], $tpl->copy_template);  
                    $tpl->copy_template = str_ireplace("{AUTHOR}", $elem['author'], $tpl->copy_template);   
                }
            }

            $tpl->compile('NEWSBOX');
            $tpl->clear();   
        }
        

        
        $tpl->load_template('user-moder-news-box.tpl');
        $tpl->set('{BOX}', $tpl->result['NEWSBOX']);
        $tpl->compile('USERBLOCK1');
        $tpl->clear();

        $tpl->load_template('user-upload.tpl');
        $tpl->compile('USERBLOCK2');
        $tpl->clear();
        
        $tpl->load_template('user.tpl');
        $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
        $tpl->set('{USERBLOCK2}', $tpl->result['USERBLOCK2']); 
        $tpl->set('{USERBLOCK3}', '');            
        $tpl->set('{USERBLOCK4}', '');
    }












    /***********************
                      Create tourney
                                ***********************/

    if($this->url_path[1] == 'CreateTourney'){
        $this->mainTitle = 'Турниры на oFight';
        
        $tpl->load_template('user-create-tourney.tpl');
        $tpl->compile('USERBLOCK1');
        $tpl->clear();
        
        
        $tpl->load_template('user-upload.tpl');
        $tpl->compile('USERBLOCK2');
        $tpl->clear();
        
        $tpl->load_template('user.tpl');
        $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
        $tpl->set('{USERBLOCK2}', $tpl->result['USERBLOCK2']); 
        $tpl->set('{USERBLOCK3}', '');            
        $tpl->set('{USERBLOCK4}', '');
    }






    /***********************
                     Moderate twtich streams
                                ***********************/
    if($this->url_path[1] == 'Admin'){
        $this->mainTitle = 'Турниры на oFight';
        
        
        $tpl->load_template('user-admin-twitch.tpl');
        $single = $tpl->copy_template;
        
        $streams = $tour->getTwitch();
        
        $tplloop = true;
        foreach($streams as $key => $twitch){
            if($tplloop === true){
                $tpl->copy_template = str_ireplace("{TWITCH}", $twitch, $tpl->copy_template);
                unset($tplloop);
            } else {
                $tpl->copy_template .= $single;
                $tpl->copy_template = str_ireplace("{TWITCH}", $twitch, $tpl->copy_template);
            }
        }
        
        $tpl->compile('TWITCHBOX');
        $tpl->clear();
        

        $tpl->load_template('user-admin-twitch-box.tpl');
        $tpl->set('{BOX}', $tpl->result['TWITCHBOX']);
        $tpl->compile('USERBLOCK1');
        $tpl->clear();
        
        $tpl->load_template('user-admin-mainstream.tpl');
        $streamer = $tour->getTourMainStream()[0];
        if(!empty($streamer)){
            $tpl->set('{MAINSTREM}', $streamer); 
        } else {
            $tpl->set('{MAINSTREM}', 'Основой стрим выключен'); 
        }
        $tpl->compile('USERBLOCK2');
        $tpl->clear();
            
        
        
        $tpl->load_template('user.tpl');
        $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
        $tpl->set('{USERBLOCK2}', $tpl->result['USERBLOCK2']); 
        $tpl->set('{USERBLOCK3}', '');            
        $tpl->set('{USERBLOCK4}', '');
    }







    /***********************
                      Admin tourney
                                ***********************/
    if($this->url_path[1] == 'AdminTourney'){
        $this->mainTitle = 'Турниры на oFight';
        
        $tpl->load_template('user-admin-tourney.tpl');
        $singleTour = $tpl->copy_template;
        $arrid = $user->getAdminTour($_SESSION['username']);
        if(!empty($arrid)){

            $tplloop = true;
            foreach($arrid as $key => $id){
                $tData = $tour->getTourinfo($id['tourid']);
                if(strtotime($tData['tourdate']) < strtotime('now')){
                    $status = 'Show';
                    $statusclass = 'unit-btn-green pointer';
                    $statusclick = 'PP_tour_push(this);';
                }else{
                    $status = 'Inactive';
                    $statusclass = 'unit-tclose';
                    $statusclick = '';
                }

                if($tplloop === true){
                    $tpl->copy_template = str_ireplace("{ID}", $tData['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{NAME}", $tData['tourname'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{STATUSCLASS}", $statusclass, $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{STATUS}", $status, $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{STATUSCLICK}", $statusclick, $tpl->copy_template);
                    unset($tplloop);
                } else {
                    $tpl->copy_template .= $singleTour;
                    $tpl->copy_template = str_ireplace("{ID}", $tData['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{NAME}", $tData['tourname'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{STATUSCLASS}", $statusclass, $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{STATUS}", $status, $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{STATUSCLICK}", $statusclick, $tpl->copy_template);
                }
            }

            $tpl->compile('TOURADMIN');
            $tpl->clear();

            $tpl->load_template('user-admin-tourneybox.tpl');
            $tpl->set('{BOX}', $tpl->result['TOURADMIN']);
            $tpl->compile('USERBLOCK1');
            $tpl->clear();
            
        }
        


        
        $tpl->load_template('user.tpl');
        $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
        $tpl->set('{USERBLOCK2}', '');
        $tpl->set('{USERBLOCK3}', '');            
        $tpl->set('{USERBLOCK4}', '');
        
    }











    /* http://xdsoft.net/jqplugins/datetimepicker/ */

    /***********************
                     Moderation tourney
                                ***********************/
    if($this->url_path[1] == 'ModerationTourney'){
        $this->mainTitle = 'Турниры на oFight';
        
        $tpl->load_template('user-moder-tourney.tpl');
        $singleTour = $tpl->copy_template;
        $tDataM = $tour->getTourModerate();
        
        if(!empty($tDataM)){
          
            $tplloop = true;
            foreach($tDataM as $key => $tData){
                if($tplloop === true){
                    $tpl->copy_template = str_ireplace("{ID}", $tData['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{NAME}", $tData['tourname'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{PRIZE}", $tData['tourprize'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{LOGO}", urldecode($tData['tourlogo']), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{GAME}", $tData['tourgame'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{MOD}", $tData['tourmod'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TYPE}", $tData['tourtype'], $tpl->copy_template); 
                    $tpl->copy_template = str_ireplace("{DATE}", date('d.m.Y H:i', strtotime($tData['tourdate'])), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{RULES}", urldecode($tData['tourrules']), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{MIDBLOCK}", $tData['tourtext'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{RIGHTBLOCK}", $tData['tourtext2'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{ADMIN}", $tData['touradmin'], $tpl->copy_template);
                    unset($tplloop);
                } else {
                    $tpl->copy_template .= $singleTour;
                    $tpl->copy_template = str_ireplace("{ID}", $tData['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{NAME}", $tData['tourname'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{PRIZE}", $tData['tourprize'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{LOGO}", urldecode($tData['tourlogo']), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{GAME}", $tData['tourgame'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{MOD}", $tData['tourmod'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TYPE}", $tData['tourtype'], $tpl->copy_template); 
                    $tpl->copy_template = str_ireplace("{DATE}", date('d.m.Y H:i', strtotime($tData['tourdate'])), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{RULES}", urldecode($tData['tourrules']), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{MIDBLOCK}", $tData['tourtext'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{RIGHTBLOCK}", $tData['tourtext2'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{ADMIN}", $tData['touradmin'], $tpl->copy_template);
                }
            }

            $tpl->compile('TOURMODERATE');
            $tpl->clear();

            $tpl->load_template('user-moder-tourneybox.tpl');
            $tpl->set('{BOX}', $tpl->result['TOURMODERATE']);
            $tpl->compile('USERBLOCK1');
            $tpl->clear();
            
        }

        $tpl->load_template('user-upload.tpl');
        $tpl->compile('USERBLOCK2');
        $tpl->clear();

        $tpl->load_template('user.tpl');
        $tpl->set('{USERBLOCK1}', $tpl->result['USERBLOCK1']);
        $tpl->set('{USERBLOCK2}', $tpl->result['USERBLOCK2']); 
        $tpl->set('{USERBLOCK3}', '');            
        $tpl->set('{USERBLOCK4}', '');
        
    }





    $tpl->compile('main-part');
    $tpl->load_template('head.tpl');
    $tpl->set("{DESCRIPTION}", 'oFight.ru');
    $tpl->set("{KEYWORDS}", 'oFight.ru');
    $tpl->compile('head');
?>