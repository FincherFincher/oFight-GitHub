<?php

    define("OFIGHTENGINE", true);
    define ( 'ROOT_DIR', dirname ( __FILE__ ) );

    include_once('engine/configs/dbconfig.php');
    include_once('engine/classes/database.class.php');
    
    $type = $_POST['type'];
    $mod = $_POST['mod'];

    include_once(ROOT_DIR . '/engine/classes/users.class.php');
    $user = new Users();
    
    switch($type){
        case 'user':
            switch($mod){
                case 'login':
                    $uname = $_POST['uname'];
                    $upass = $_POST['upass'];
                    if($user->login($uname, $upass)){
                        echo 'ok';
                        break;
                    }
                    return false;
                    break;

                case 'reg':
                    $uname = $_POST['uname'];
                    $uemail = $_POST['uemail'];
                    $upass = $_POST['upass'];
                    $usubsc = $_POST['usubsc'];
                    if($user->register($uname, $upass, $uemail, $usubsc)){
                        echo 'ok';
                        break;
                    }
                    return false;
                    break;
                
                case 'preset':
                    $uemail = $_POST['uemail'];
                    if($user->passReset($uemail)){
                        echo 'ok';
                        break;
                    }
                    return false;
                    break;

                case 'streamers':
                    echo $user->getStreamers();
                    return $user->getStreamers();
            
                    break;
                
                case 'userparam':
                    $uName = $_SESSION['username']; session_write_close();
                    $attrName = $_POST['attrName'];
                    $attrValue = $_POST['attrValue'];
                    if($attrName == 'password')
                    {
                        $attrValue = md5($attrValue);
                    }
                
                    if($user->userAttr($uName, $attrName, $attrValue)){
                        echo 'ok';
                        break;
                    }
                    break;
                
                case 'userinfo':
                    $uData = $user->userinfo($_SESSION['username']);
                    echo json_encode($uData);
                    break;
                
                case 'usersession':
                    if($_SESSION['username']){
                        echo 'ok';
                        break;
                    }
                    break;

                case 'sendVacancy':
                    $realName = $_POST['realName'];
                    $email = $_POST['eMail'];
                    $topic = $_POST['topic'];
                    $textInfo = $_POST['textInfo'];
                    $user->sendVacancy($realName, $email, $topic, $textInfo);
                    break;

                case 'sendTourCreateFrom':
                    $realName = $_POST['realName'];
                    $email = $_POST['eMail'];
                    $textInfo = $_POST['textInfo'];
                    $user->sendTourCreateFrom($realName, $email, $textInfo);
                    break;
                

                case 'getPlayerRanking':
                    $uName = $_POST['name'];
                    echo json_encode($user->getRankingByUser($uName));
                    break;
                
            }
            break;
        
        
        
        
        
        
        case 'tour':
            include_once(ROOT_DIR . '/engine/classes/tournament.class.php');
            include_once(ROOT_DIR . '/engine/classes/simpleSHM.class.php');
            $tour = new Tournament();
            include_once(ROOT_DIR . '/engine/classes/users.class.php');
            $user = new Users();
        
            switch($mod){
                case 'login':
                    $uname = $_POST['uname'];
                    break;


    /***********************
            Создание турнира
                                ***********************/
                case 'create':
                    $name = $_POST['name'];
                    $prize = $_POST['prize'];
                    $img = urlencode($_POST['img']);
                    $game = $_POST['game'];
                    $tourmod = $_POST['tourmod'];
                    $tourtype = $_POST['tourtype'];
                    $date = date("Y-m-d H:i:s", strtotime($_POST['date']));
                    $rule = urlencode('http://ofight.ru/uploads/rules/'. $game .'/'. $_POST['rule'] . '.pdf');
                    $admin = $_POST['admin'];
                    $mblock = $_POST['mblock'];
                    $rblock = $_POST['rblock'];
                    $author = $_SESSION['username'];
                    
                    echo $tour->createTour($name, $prize, $img, $game, $tourmod, $tourtype, $date, $rule, $admin, $mblock, $rblock, $author);
                    break;

    /***********************
            Подтверждение турнира
                                ***********************/
                case 'accept':
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $prize = $_POST['prize'];
                    $img = urlencode($_POST['img']);
                    $game = $_POST['game'];
                    $tourmod = $_POST['tourmod'];
                    $tourtype = $_POST['tourtype'];
                    $date = date("Y-m-d H:i:s", strtotime($_POST['date']));
                    $rule = urlencode($_POST['rule']);
                    $admin = $_POST['admin'];
                    $mblock = $_POST['mblock'];
                    $rblock = $_POST['rblock'];
                    $author = $_POST['author'];
                
                    echo $tour->acceptTour($id, $name, $prize, $img, $game, $tourmod, $tourtype, $date, $rule, $admin, $mblock, $rblock, $author);
                    break;


                case 'gettourinfo':
                    $id = $_POST['id'];
                    echo json_encode($tour->getTourinfoModerate($id));
                    break;
        
                case 'tourInfoByID':
                    $id = $_POST['id'];
                    echo json_encode($tour->getTourinfo($id));
                    break;
                
    /***********************
                            BRACKET
                                ***********************/
                case 'getBracket':
                    $id = $_POST['id'];
                    $uName = $_SESSION['username']; session_write_close();
                    $tData = $tour->getTourinfo($id); 

                    if( empty($tData) || empty($tData['tourtechstart']) )
                    {
                        break;
                    }
                
                    $tBracket = $tour->getBracket($tData);
                    $tStatus = $tour->tourStatus($uName, $tData);
                    
                    if($tStatus == 'started')
                    {
                        $data = array();
                        $data['tData'] = new stdClass();
                        $data['bracket'] = new stdClass();
                        $data['group'] = new stdClass();
                        $data['tData'] = $tData;
                        $data['bracket'] = $tBracket['winners'];
                        $data['group'] = $tBracket['group'];
                        $data['status'] = $tStatus;
                    } else {
                        $data = '';
                    }

                    echo json_encode($data);
                    break;
        
                
                    
                    
    /***********************
                  Основной стрим турнира
                                ***********************/
                    
                case 'setTourMainStream':
                    $streamer = $_POST['streamer'];
                    echo $tour->setTourMainStream($streamer);
                    break;
                    
                case 'getTourMainStream':
                    echo $tour->getTourMainStream()[0];
                    break;
                    
                case 'delTourMainStream':
                    $tour->delTourMainStream();
                    break;
                    
                    
                    
                
    /***********************
                  Запуск турнира
                                ***********************/
                case 'tourstart':
                    $id = $_POST['tourid'];
                    $tData = $tour->getTourinfo($id); 
                    if($tour->tourStart($tData)){
                //----> shared memory
/*
                        $semaphore = sem_get($id, 1, 0666, 0);
                        sem_acquire($semaphore);
                        shmop_delete($id);
                        sem_release($semaphore); 
                        
                        $SHMTourney = $tour->tourGetSHM($id); 
                        $semaphore = sem_get($id, 1, 0666, 0);
                        sem_acquire($semaphore);
                        $SHM = new Block($id);
                        $SHM->write(json_encode($SHMTourney, true));
                        sem_release($semaphore); 
*/
                        echo 'ok';
                        break;
                    }
                    break;
                
                case 'tourEnd':
                    $id = $_POST['id'];
                $id = '1';
                    $tData = $tour->getTourinfo($id); 
                    if($tour->tourEnd($tData)){      
                        break;
                    }
                    break;
        

    /***********************
                Пререгистрация
                                ***********************/
                
                case 'tourPreReg':
                //----> get data
                    $uName = $_SESSION['username']; session_write_close();
                    $id = $_POST['id'];
                    if(empty($uName)){
                        echo '1';
                        break;
                    }
                
                    $tData = $tour->getTourinfo($id); 
                
                //----> main function
                    if($tour->tourPreReg($uName, $tData)){
                        echo '0';
                        break;
                    }
                    break;           
        

    /***********************
             Регистрация на турнир
                                ***********************/
                
                case 'tourReg':
                    $uName = $_SESSION['username']; session_write_close();
                    $id = $_POST['id'];
                    $arg1 = $_POST['arg1'];
                    $arg2 = $_POST['arg2'];
                    $arg3 = $_POST['arg3'];
                    $VK = $_POST['VK'];
                    $Btag = $_POST['Btag'];

                    if(empty($uName))
                    {
                        echo '1'; break;
                    }

                    $tData = $tour->getTourinfo($id);
                    if($tData['tourgame'] == 'Hearthstone' && $tData['tourtype'] == 'Regular')
                    {
                        if(empty($arg1) || empty($arg2) || empty($arg3))
                        {
                            echo '3'; break;
                        }
                        if($arg1 == $arg2 || $arg1 == $arg3 ||$arg2 == $arg3)
                        {
                            echo '4'; break;
                        }
                    }
                    
                    if($tData['tourgame'] == 'Hearthstone' && $tData['tourtype'] == 'Random')
                    {
                        $r_Race = Array("Hunter", "Paladin", "Warrior", "Shaman", "Priest", "Druid", "Warlock", "Rogue");
                        while($i <= 3){
                            $rnd = array_rand($r_Race, 1);
                            ${'arg'.$i} = $r_Race[$rnd];
                            unset($r_Race[$rnd]); $i++;
                        }
                    }
                    if(!empty($tData['tourtechstart']))
                    {
                        echo '5'; break; 
                    }
                    
                    $attrName = 'vkcom';
                    $user->userAttr($uName, $attrName, $VK);
                    $attrName = 'bnettag';
                    $user->userAttr($uName, $attrName, $Btag);
 
                    echo $tour->tourRegNormal($uName, $tData, $arg1, $arg2, $arg3);
                    
                    break;   
        
                
    /***********************
                            ADMIN
                                ***********************/
                
            //------>  Set Winner by admin
                
                case 'setWinnerByAdmin':
                    $id = $_POST['id'];
                    $winner_a = $_POST['winner'];
                    $loser_a = $_POST['loser'];
                    $round = $_POST['round'];
                    
                    $tData = $tour->getTourinfo($id); 
                    $tUser = $tour->tourUser($tData, $winner_a); 
                    $tEnemy = $tour->tourEnemy($tData, $tUser, $round);
                    
                    if($loser_a != $tEnemy['username'])
                    {
                        echo '2';
                        break;
                    }
                    
                    echo $tour->setWinnerByAdmin($tData, $tUser, $tEnemy, $round);
                    
                    $SHM = new Block($tData['id']);
                    $obj = json_decode($SHM->read(), true);
                    $obj[$winner_a] = 1;
                    $obj[$loser_a] = 1;
                    $SHM->write(json_encode($obj));   

                    $tUser = $tour->tourUser($tData, $winner_a);                                                                         
                    $round = $tour->tourUserRound($tUser, $tData);                                                                         
                    $New_tEnemy = $tour->tourEnemy($tData, $tUser, $round); 

                    $SHM = new Block($tData['id']);
                    $obj = json_decode($SHM->read(), true);
                        $obj[$winner_a] = 1;
                        $obj[$loser_a] = 1;
                        $obj[$New_tEnemy['username']] = 1;
                    $SHM->write(json_encode($obj));

                    break;  
                    
            //------>  Дисквалификация
                    
                case 'setDisqualifyByAdmin':
                    $uName = $_POST['user'];  
                    $id = $tour->tourUserCheck($uName);
                    if($id == 'noTour'){echo '1'; break;}
                    $tData = $tour->getTourinfo($id); 
                    $tUser = $tour->tourUser($tData, $uName); 
                    $round = $tour->tourUserRound($tUser, $tData);  
                    $tEnemy = $tour->tourEnemy($tData, $tUser, $round);
                    $tEnemy_next = $tour->tourEnemy($tData, $tUser, min(($round + 1),3));
                    $tour->Kick_user_from_tourney($tData, $tUser, $round, $tEnemy); echo 0;

                    $SHM = new Block($tData['id']);
                    $obj = json_decode($SHM->read(), true);
                    $obj[$tEnemy['username']] = 1;
                    $obj[$tEnemy_next['username']] = 1;  
                    $SHM->write(json_encode($obj));

                    break;  
                    
                    
            //------>  Удалить результат
                    
                case 'delete_result':
                    $uName = $_SESSION['username']; session_write_close();
                    $id = $tour->tourUserCheck($uName);
                    $tData = $tour->getTourinfo($id); 
                    $tUser = $tour->tourUser($tData, $uName); 
                    $round = $tour->tourUserRound($tUser, $tData);  
                    $tmpRez= ''; $result = '';
                    
                    $tour->tourResult($uName, $tData, $tUser, $round, $tmpRez, $result);

                    break;  
                    
                    
            //------>  Get Info Player
                
                case 'getInfoAboutUser':
                    $id = $_POST['id'];
                    $uName = $_POST['user'];
                    $tData = $tour->getTourinfo($id); 
                    $tUser = $tour->tourUser($tData, $uName); 
                    if(empty($tUser))
                    {
                        echo '1';
                        break;
                    }
                    $round = $tour->tourUserRound($tUser, $tData); 
                    $uData = $user->userinfo($uName);
                    $tEnemy = $tour->tourEnemy($tData, $tUser, $round);
                
                    $data = array();
                    array_push($data, $tUser);
                    array_push($data, $round);
                    array_push($data, $uData);
                    array_push($data, $tEnemy);
                    echo json_encode($data);
                    break;
                
            //------> Round 1 Status Players
                
                case 'getRoundOneAnalytic': 
                    $id = $_POST['id'];
                    $round = $_POST['round'];
                    $tData = $tour->getTourinfo($id); 
                    echo $tour->getRoundOneAnalytic($tData, $round);
                    break;
                
            //------> Delete twitch
                
                case 'delTwitch': 
                    $twitch = $_POST['twitch'];
                    $tour->delTwitch($twitch);
                    break;
                
            //------> Add twitch
                
                case 'addTwitch': 
                    $twitch = $_POST['twitch'];
                    $tour->addTwitch($twitch);
                    break;
                
                
                
                
    /***********************
            Подтверждение участия
                                ***********************/
                case 'accDuel':
                    $uName = $_SESSION['username']; session_write_close();
                    $id = $tour->tourUserCheck($uName);
                    $tData = $tour->getTourinfo($id); 
                    $tUser = $tour->tourUser($tData, $uName);   
                
                    if($id == 'noTour'){
                        break;  
                    }
                    $tour->tourAccDuel($uName, $tData, $tUser);
                    break;  
                
                
    /***********************
              Первичный результат
                                ***********************/
                case 'tourSetResult':

                    $uName = $_SESSION['username']; session_write_close();
                    $id = $tour->tourUserCheck($uName);
                    $result = $_POST['result']; 
                    $scoreMy = $_POST['scoreMy']; 
                    $scoreEn = $_POST['scoreEn']; 
                    $tmpRez = implode(':',array($scoreMy,$scoreEn));
                
                    $tData = $tour->getTourinfo($id);                                                                               
                    $tUser = $tour->tourUser($tData, $uName);                                                                         
                    $round = $tour->tourUserRound($tUser, $tData);                                                                         
                    $tEnemy = $tour->tourEnemy($tData, $tUser, $round);
                    
                    $tour->tourResult($uName, $tData, $tUser, $round, $tmpRez, $result);

                    $tUser = $tour->tourUser($tData, $uName);   
                    
                    if( !empty($tEnemy['r'.$round.'rez']) && !empty($tUser['r'.$round.'rez']) )
                    {

                        if( $tEnemy['r'.$round.'rez'] != $tUser['r'.$round.'rez'] )
                        {
                            
                        //------> Финальный результат  

                            $tour->tourResultFinal($uName, $tData, $tUser, $round, $tEnemy);

                            $tUser = $tour->tourUser($tData, $uName);                                                                         
                            $round = $tour->tourUserRound($tUser, $tData);                                                                         
                            $New_tEnemy = $tour->tourEnemy($tData, $tUser, $round); 

                            $SHM = new Block($tData['id']);
                            $obj = json_decode($SHM->read(), true);
                                   $obj[$uName] = 1;
                                   $obj[$tEnemy['username']] = 1;
                                   $obj[$New_tEnemy['username']] = 1;
                            $SHM->write(json_encode($obj));
                        } else {
                            $SHM = new Block($tData['id']);
                            $obj = json_decode($SHM->read(), true);
                                   $obj[$uName] = 1;
                                   $obj[$tEnemy['username']] = 1;
                            $SHM->write(json_encode($obj));  
                        }
                    } 
                    break;  
                    
                

    /***********************
                      Get user Group Data
                                ***********************/
      
                case 'tourGetGroupEnemy':
                    $uName = $_SESSION['username']; session_write_close();
                    $id = $tour->tourUserCheck($uName);
                    $tData = $tour->getTourinfo($id);
                    $tUser = $tour->tourUser($tData, $uName);
                    $round = $tour->tourUserRound($tUser, $tData);  
                    $tEnemy = $tour->tourEnemy($tData, $tUser, $round);
                    echo json_encode($tour->tourGetGroupEnemy($tData, $tUser));
                    break; 
                
 
        

    /***********************
          Аякс учстника в турнире
                                ***********************/

                case 'tourPlayerData':

                    $uName = $_SESSION['username']; session_write_close();   
                    
                    if(empty($uName))
                    {
                        echo 'notRegistr';
                        break;   
                    }

                    $uTourStatus = $tour->tourUserCheck($uName);
                    
                    if($uTourStatus != 'noTour')
                    {
 
                        lblReload: // Label
                    
                        $tData = $tour->getTourinfo($uTourStatus);
                        
                        $SHM = new Block($tData['id']);
                        $obj = json_decode($SHM->read(), true);
                        if( $obj[$uName] > 0 )
                        {
                            $obj[$uName] = 0;
                            $SHM->write(json_encode($obj, true));  
                        }
                        
                        $tUser = $tour->tourUser($tData, $uName);
                        $round = $tour->tourUserRound($tUser, $tData); 
                        $tEnemy = $tour->tourEnemy($tData, $tUser, $round);
                        $tUserStatus = $tour->tourUserStatus($tData, $tUser, $tEnemy, $round);
                        $tEnemyData = $user->userinfo($tEnemy['username']);
                        
                  //  print_r($tUserStatus); break;
                    /*
                        $tConfirmTime = strtotime('now') - strtotime($tData['tourdate']);
                        $tConfirmTime = 900 - $tConfirmTime;
                        
                   */     
                        $tConfirmTime = 900 - (strtotime('now') - strtotime($tUser['tConfirm']));
                        

                        if($tConfirmTime < 0)
                        {
                            $tConfirmTime = 0;
                        }
                        
                        if($tUserStatus == 'Reload')
                        {
                            goto lblReload;
                        }   
                        
                        if($tUserStatus == 'ReloadFreeSlot')
                        {
                            $New_round = $round + 1;
                            if($tData['tourmod'] == 'Spartan'){
                                $New_round = min($New_round, 3);
                            }
                            $New_tEnemy = $tour->tourEnemy($tData, $tUser, $New_round);
                            $SHM = new Block($tData['id']);
                            $obj = json_decode($SHM->read(), true);
                                   $obj[$New_tEnemy['username']] = 1;
                            $SHM->write(json_encode($obj));
                            goto lblReload;
                        }  
                        
                        if($tUserStatus == 'ReloadEndGroup')
                        {
                            $allEnemy = $tour->getAllEnemyInGroup($tUser, $tData);
                            $SHM = new Block($tData['id']);
                            $obj = json_decode($SHM->read(), true);
                            foreach($allEnemy as $key => $enemy)
                            {
                                $obj[$enemy] = 1;
                                $SHM->write(json_encode($obj));   
                            }
                            goto lblReload;
                        }
                        
/*
                        if( $tUserStatus == 'TourEndForUser' )
                        {
                            $tour->tourEndForUser($uName);
                        }  
*/                        
                        if( $tUserStatus == 'TourEnd' || $tUserStatus == 'UserWinPlace_1' )
                        {
                            $tour->tourEnd($tData);
                        }
                        
                        $data = array();
                        $data['tourData'] = new stdClass();
                        $data['tourUser'] = new stdClass();
                        $data['tourRound'] = new stdClass();    
                        $data['tourEnemy'] = new stdClass(); 
                        $data['tourEnemyData'] = new stdClass(); 
                        $data['tourStatus'] = new stdClass();
                        $data['tourConfirmTime'] = new stdClass(); 
                        $data['tourData'] = $tData;
                        $data['tourUser'] = $tUser;
                        $data['tourRound'] = $round;    
                        $data['tourEnemy'] = $tEnemy;  
                        $data['tourEnemyData'] = $tEnemyData; 
                        $data['tourStatus'] = $tUserStatus; 
                        $data['tourConfirmTime'] = $tConfirmTime; 
                        $data = json_encode($data);
                        echo $data;
                        break;
                        
                    } else {
                        
                        echo $uTourStatus;  
                        
                    }
                    break;

            }
            break;
        case 'news':
            include_once(ROOT_DIR . '/engine/classes/news.class.php');
            $news = new News();
            switch($mod){
                case 'addComment':
                    $username = $_POST['uname'];
                    $comment = $_POST['comment'];
                    $id = $news->getNewsIdByURL($_POST['url']);

                    $uinfo = $user->ainfo($username);
                    if($uinfo['username'] != $username){
                        return false;
                        break;
                    }
                    if(!$news->addComment($id, $username, $comment)){
                        return false;
                        break;
                    }
                    $data = array('ok', $uinfo);
                    echo json_encode($data);
                    break;
                
                case 'create':
                    $titlename  = $_POST['titlename'];
                    $picture = urlencode($_POST['picture']);
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $keywords = $_POST['keywords'];
                    $urlname = $_POST['urlname'];
                    $prevtext = $_POST['prevtext'];
                    $maintext = $_POST['maintext'];
                    $author = $_POST['author'];
                    $category = $_POST['category'];
                    $news->createNews($titlename, $picture, $title, $description, $keywords, $urlname, $prevtext, $maintext, $category, $author);
                    echo 'ok';
                    break;
                
                case 'moderate':
                    $id  = $_POST['id'];
                    $titlename  = $_POST['titlename'];
                    $picture = urlencode($_POST['picture']);
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $keywords = $_POST['keywords'];
                    $urlname = $_POST['urlname'];
                    $prevtext = $_POST['prevtext'];
                    $maintext = $_POST['maintext'];
                    $author = $_POST['author'];
                    $category = $_POST['category'];
                    $news->moderateNews($id, $titlename, $picture, $title, $description, $keywords, $urlname, $prevtext, $maintext, $category, $author);
                    echo 'ok';
                    break;

            }
            break;
    }
    

?>