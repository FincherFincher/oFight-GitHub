<?php

    class Tournament {
        
        function __construct() {
            
            $this->db = new DB();
            $this->db = $this->db->connect();
            
        }
        
        
    /***********************
                       Create tourney
                                ***********************/
        
        function createTour($name, $prize, $img, $game, $tourmod, $tourtype, $date, $rule, $admin, $mblock, $rblock, $author)
        {
            $admin = $admin.','.$author;
            $tourPrepare = $this->db->prepare("
                            INSERT INTO oF_tour_cPanel_M (id, tourname, tourprize, tourlogo, tourgame, tourmod, tourtype, tourdate, tourrules, touradmin, tourtext, tourtext2, tourauthor) 
                            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            try
            {
               $tourPrepare->execute(array($name, $prize, $img, $game, $tourmod, $tourtype, $date, $rule, $admin, $mblock, $rblock, $author));
               return 'ok';
            } 
            
            catch (PDOException $e)
            {
               if ($e->errorInfo[1] == 1062)
               { 
                  return '2';
               }
            }
        }

        
    /***********************
                    Одобрить турнир
                                ***********************/
        
        function acceptTour($id, $name, $prize, $img, $game, $tourmod, $tourtype, $date, $rule, $admin, $mblock, $rblock, $author)
        {
            $tourPrepare = $this->db->prepare(" INSERT INTO oF_tour_cPanel (id, tourname, tourprize, tourlogo, tourgame, tourmod, tourtype, tourdate, tourrules, touradmin, tourtext, tourtext2, tourauthor) 
                                                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
            try
            {
               $tourPrepare->execute(array($name, $prize, $img, $game, $tourmod, $tourtype, $date, $rule, $admin, $mblock, $rblock, $author));
            } 
            catch (PDOException $e)
            {
               if ($e->errorInfo[1] == 1062)
               { 
                  return '3';
               }
            }
            
            $lastid = $this->db->query("SELECT LAST_INSERT_ID()")->fetch(PDO::FETCH_NUM);
            $lastid = $lastid[0];
            $query = $this->db->prepare(" CREATE TABLE ".'oF_tour_table_'.$lastid." LIKE oF_tour_table_template;
                                          CREATE TABLE ".'oF_tour_pretable_'.$lastid." LIKE oF_tour_pretable_template;
                                          CREATE TABLE ".'oF_tour_brackettable_'.$lastid." LIKE oF_tour_brackettable_template ")->execute();

            $admin = explode(",", $admin);
            for($i = 0; $i <= (count($admin)-1); $i++)
            {
                $query = $this->db->prepare(" INSERT INTO oF_tour_admin (username, tourid) VALUES ('".$admin[$i]."', '".$lastid."') ")->execute();  
            }

            $query = $this->db->prepare("DELETE FROM oF_tour_cPanel_M WHERE id = '".$id."'")->execute(); 

            return 'ok';
        }
        
        

    /***********************
                    Турнир по iD
                                ***********************/
        
        public function getTourinfo($id)
        {  
            $query = $this->db->prepare("SELECT * FROM oF_tour_cPanel WHERE id = ?");
            $query->execute(array($id));
            $data = $query->fetch();
            return $data;
        }
        
        
        
    /***********************
                    Турнир по iD
                                ***********************/
        
        public function getTourinfoModerate($id)
        {  echo 'd';
         echo $id;
            $query = $this->db->prepare("SELECT * FROM oF_tour_cPanel_M WHERE id = ?");
            $query->execute(array($id));
            return $query->fetch();
        }
        
        
        
        
    /***********************
              Турниры на Модерацию
                                ***********************/
        
        public function getTourModerate()
        {  
            $query = $this->db->prepare("SELECT * FROM oF_tour_cPanel_M");
            $query->execute();
            $data = $query->fetchAll();
            return $data;
        }
        
        

    /***********************
             Удаляем АФК из турнира
                                ***********************/
        
        function tourKickAfk($tData)
        {  
            $tUpdate = array();
            
            if($tData['tourmod'] == 'Spartan')
            { 
                $data = $this->db->query(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE tConfirm + 900 < NOW() AND tConfirm != 0 ")->fetchAll(PDO::FETCH_COLUMN);  
            }
            if($tData['tourmod'] == 'Olympia')
            {
                $data = $this->db->query(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE tConfirm + 900 < NOW() AND tConfirm != 0 ")->fetchAll(PDO::FETCH_COLUMN);
            } 
            if(empty($data))
            {
                exit();
            }
    
            foreach($data as $key => $uName)
            {
                $tUser = $this->tourUser($tData, $uName);
                $round = $this->tourUserRound($tUser, $tData); 
                $tEnemy = $this->tourEnemy($tData, $tUser, $round);

                $this->Kick_user_from_tourney($tData, $tUser, $round, $tEnemy);  
            }  
            return $tUpdate;
        }
        

        
        
        function Kick_user_from_tourney($tData, $tUser, $round, $tEnemy)
        {
            if($tData['tourmod'] == 'Spartan')
            {
                if(empty($tUser['MoveTo_SE']))
                { 

                    $sql = " UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                             SET username = 'Free Slot', r1rez = 'D', r1finalrez  = 'D', r2rez = 'D', r2finalrez  = 'D', r3rez = 'D', r3finalrez  = 'D', points = -6 
                             WHERE username = '".$tUser['username']."' "; 
                    $this->db->query($sql);
                    $FS_br_query = $this->db->query(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username = 'Free Slot' AND r2 = '".$tUser['r2']."' ")->fetchAll(PDO::FETCH_ASSOC);
                    if(count($FS_br_query) > 2)
                    {
                        $data_TF = $this->db->query(" SELECT id, r1 FROM ".'oF_tour_table_'.$tData['id']." WHERE Backet = '".$tUser['r2']."' ORDER BY r0 LIMIT 1 ")->fetchAll(PDO::FETCH_ASSOC);
                        $enemy_TF = $this->db->query(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE r1 = '".$data_TF[0]['r1']."' AND id != '".$data_TF[0]['id']."' ")->fetchAll(PDO::FETCH_COLUMN);
                        if($enemy_TF[0] == 'Free Slot')
                        {
                            $this->db->query(" UPDATE ".'oF_tour_table_'.$tData['id']." 
                                               SET username = 'Free Slot', r1rez = 'W', r1finalrez = 'W', r2rez = 'D', r2finalrez = 'D', r3rez = 'D', r3finalrez = 'D', FreeSlotHide = 'y', r1score = '2'
                                               WHERE Backet = '".$tUser['r2']."' AND username = '' ORDER BY r0 LIMIT 1 "); 
                        } else {
                            $this->db->query(" UPDATE ".'oF_tour_table_'.$tData['id']." 
                                               SET username = 'Free Slot', r1rez = 'D', r1finalrez = 'D', r2rez = 'D', r2finalrez = 'D', r3rez = 'D', r3finalrez = 'D', FreeSlotHide = 'y' 
                                               WHERE Backet = '".$tUser['r2']."' AND username = '' ORDER BY r0 LIMIT 1 "); 
                        }
                    }  
                } else {
                    goto Kick_user_from_tourney_LEBEL;
                }
            }
            if($tData['tourmod'] == 'Olympia')
            {
                Kick_user_from_tourney_LEBEL:
                if($tEnemy['username'] == 'Free Slot' || $tEnemy['FreeSlotHide'] == 'y')
                {
                    $sql = " UPDATE ".'oF_tour_table_'.$tData['id']." 
                             SET ".'r'.$round.'rez'." = 'W',".'r'.$round.'finalrez'." = 'W', ".'r'.($round).'score'." = '2', ".'r'.($round+1).'rez'." = 'D',".'r'.($round+1).'finalrez'." = 'D', FreeSlotHide = 'y' 
                             WHERE id = '".$tUser['id']."' ";    
                } else {
                    $sql = " UPDATE ".'oF_tour_table_'.$tData['id']." 
                             SET ".'r'.$round.'rez'." = 'D',".'r'.$round.'finalrez'." = 'D', FreeSlotHide = 'y' 
                             WHERE id = '".$tUser['id']."' ";  
                }
                $this->db->query($sql);
            } 
            $this->db->query(" DELETE FROM oF_tour_users WHERE username = '".$tUser['username']."' and tourid = '".$tData['id']."' ");
        }
        
        
        
        
  
    /***********************
                   Завершить турнир
                                ***********************/
        function tourEnd($tData, $cron){
            
            $query = $this->db->query("SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE ".'r'.$tData['tourrounds'].'finalrez'." = 'W' ")->fetchAll(PDO::FETCH_COLUMN);
            if( count($query) < 2 )
            {   
                if($cron != 'yes')
                {
                    return false;
                } 
            }
            
            $query = $this->db->query(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." 
                                        WHERE ".'r'.$tData['tourrounds'].'finalrez'." = 'W' AND ".'r'.($tData['tourrounds'] - 1).'finalrez'." = 'W' ")->fetchAll(PDO::FETCH_COLUMN); 
            if(count($query) < 1)
            {
                return false;
            }
            
            
            $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." ");
            $query->execute();
            $maxPlayer = $query->rowCount();
            $maxRound = log(($maxPlayer),2);

            $query = $this->db->prepare("SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE ".'r'.$maxRound.'finalrez'." = 'W' ");
            $query->execute();
            $winnerName = $query->fetch();  

            if(empty($winnerName)){
                return false;	
            }
            
            $query = $this->db->prepare(" UPDATE ".'oF_tour_table_'.$tData['id']." SET tourname = '".$tData['tourname']."' ")->execute();
            $query = $this->db->prepare(" INSERT INTO oF_tour_archive SELECT * FROM ".'oF_tour_table_'.$tData['id']." ")->execute();
            $query = $this->db->prepare(" INSERT INTO oF_tour_archive_backet SELECT * FROM ".'oF_tour_brackettable_'.$tData['id']." ")->execute();
            
            $query = $this->db->prepare(" INSERT INTO oF_tour_winners (username, tourname, tourgame) VALUES ('".$winnerName['username']."', '".$tData['tourname']."', '".$tData['tourgame']."') ")->execute();
            $query = $this->db->prepare(" INSERT INTO oF_tour_cPanel_Past SELECT * FROM oF_tour_cPanel WHERE id = '".$tData['id']."' ")->execute();
            
            $query = $this->db->prepare(" DELETE FROM oF_tour_cPanel WHERE id = '".$tData['id']."' ")->execute(); 
            
            $query = $this->db->prepare(" DROP TABLE IF EXISTS ".'oF_tour_pretable_'.$tData['id']." ")->execute();
            $query = $this->db->prepare(" DROP TABLE IF EXISTS ".'oF_tour_table_'.$tData['id']." ")->execute();
            $query = $this->db->prepare(" DROP TABLE IF EXISTS ".'oF_tour_brackettable_'.$tData['id']." ")->execute();
            
            $query = $this->db->prepare(" DELETE FROM oF_tour_users WHERE tourid = '".$tData['id']."' ")->execute();
            $query = $this->db->prepare(" DELETE FROM oF_tour_admin WHERE tourid = '".$tData['id']."' ")->execute();
/*
            $semaphore = sem_get($tData['id'], 1, 0666, 0);
            sem_acquire($semaphore);
            shmop_delete ($tData['id']);
            sem_release($semaphore); \
*/
        }
        
        
        
        
    /***********************
                        TOURNEY ADMIN
                                ***********************/
        
        //------> Set Winner
        
        function setWinnerByAdmin($tData, $tUser, $tEnemy, $round)
        {
            if($tData['tourmod'] == 'Spartan')
            {
                if(empty($tUser['MoveTo_SE']))
                {
                    $sql = " UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                             SET ".'r'.$round.'rez'." = 'W', ".'r'.$round.'finalrez'." = 'W', ".'r'.$round.'score'." = '2', points = points + 2 
                             WHERE username = '".$tUser['username']."';
                                                 
                             UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                             SET ".'r'.$round.'rez'." = 'D', ".'r'.$round.'finalrez'." = 'D', ".'r'.$round.'score'." = '0', points = points - 1
                             WHERE username = '".$tEnemy['username']."' ";
                    
                    $query = $this->db->query($sql);
                    return 'ok';
                }
                
                if(!empty($tUser['MoveTo_SE']))
                {
                    lebelsetWinnerByAdminOlympia:
                    $sql = " UPDATE ".'oF_tour_table_'.$tData['id']." 
                             SET ".'r'.$round.'rez'." = 'W', ".'r'.$round.'finalrez'." = 'W', ".'r'.$round.'score'." = '2' 
                             WHERE username = '".$tUser['username']."';
                             
                             UPDATE ".'oF_tour_table_'.$tData['id']." 
                             SET ".'r'.$round.'rez'." = 'D', ".'r'.$round.'finalrez'." = 'D', ".'r'.$round.'score'." = '0'
                             WHERE username = '".$tEnemy['username']."' ";
                    
                    $query = $this->db->query($sql);
                    return 'ok';
                }
            }
            
            if($tData['tourmod'] == 'Olympia')
            {
                goto lebelsetWinnerByAdminOlympia;
            }
         
        }
        
        


        
        

        
        
        
        //------> Round 1 Analitycs  
        
        function getRoundOneAnalytic($tData, $round)
        {
            $sql = " SELECT username, ".'r'.$round.'rez'.", ".'r'.$round.'finalrez'." FROM ".'oF_tour_brackettable_'.$tData['id']." ORDER BY ".'Back_r'.$round." ASC, r0 ASC ";
            return json_encode($this->db->query($sql)->fetchAll());
        }
   
            
        //------> Twitch
        
        function getTwitch()
        {
            $query = $this->db->query(" SELECT streamers FROM oFight_streamers_HS ");
            return $query->fetchAll(PDO::FETCH_COLUMN);    
        }
        function delTwitch($twitch)
        {
            $query = $this->db->query(" DELETE FROM oFight_streamers_HS WHERE streamers = '".$twitch."' ");  
        }  
        function addTwitch($twitch)
        {
            $query = $this->db->query(" INSERT INTO oFight_streamers_HS (streamers) VALUES ('".$twitch."') ");  
        }       
  /*          
            
            
            
  
            $now = strtotime('now');
            $now = $now - 60 * 3; 
            for($i = 0; $i <= count($data); $i++)
            {
                if($i % 2 != 0)
                {
                    $k = $i - 1;
                    
                    if($round > 1)
                    {
                        if(empty($data[$i]['r'.($round - 1).'finalrez']) || empty($data[$k]['r'.($round - 1).'finalrez']))
                        {
                            unset($data[$i]);
                            unset($data[$k]);
                            goto lebelmisspair;
                        }
                    }
                    
                        if( (empty($data[$i]['r'.$round.'rez']) && !empty($data[$k]['r'.$round.'rez'])) )
                        {
                            $check = strtotime($data[$k]['rtime']);
                            if($check < $now)
                            {
                                $data[$i]['status'] = 'check';	
                            }   
                        }
                        if( (empty($data[$k]['r'.$round.'rez']) && !empty($data[$i]['r'.$round.'rez'])) )
                        {
                            $check = strtotime($data[$i]['rtime']);
                            if($check < $now)
                            {
                                $data[$k]['status'] = 'check';	
                            }  
                        }
                    
                    lebelmisspair:
                    $i++;
                }
            }

            return $result = array("data" => $data, "round" => $round);  */



        
        
    /***********************
                        GET TOURNEY
                                ***********************/
        
        //------> Get Single Tourney
        
        function getTour()
        {
            return $this->db->query("SELECT * FROM oF_tour_cPanel WHERE tourspecial = '' ORDER BY tourdate ASC LIMIT 5")->fetchAll(); 
        }
        function getFutureTour()
        {
            return $this->db->query(" SELECT * FROM oF_tour_cPanel WHERE tourtechstart = '' ORDER BY tourdate ASC ")->fetchAll();  
        }
        function getPastTour()
        {
            return $this->db->query(" SELECT * FROM oF_tour_cPanel_Past ORDER BY tourdate DESC ")->fetchAll();
        }
        function getTourSpecial()
        {
            return $this->db->query("SELECT * FROM oF_tour_cPanel WHERE tourspecial != '' ORDER BY tourdate ASC LIMIT 2")->fetchAll(); 
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
    /***********************
            Получить статус турнира
                                ***********************/
        
        function tourStatus($uName, $tData){
            $startDate = strtotime($tData['tourdate']);
            $regDate = $startDate - 7200;
            $nowDate = strtotime('now');

            /* tour started */
            if($startDate < $nowDate){
                return 'started';	
            }    
            
            /* tour pre registr */            
            if($regDate > $nowDate){
                $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_pretable_'.$tData['id']." WHERE username = ? ");
                $query->execute(array($uName));
                $preReg = $query->rowCount();  
                if(!empty($preReg)){
                    return 'pregPass';
                }
                return 'pregOpen';
            }

            /* tour final registr */
            if($regDate < $nowDate)
            { 
                if($tData['tourmod'] == 'Spartan')
                {
                    $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username = ? ");
                    $query->execute(array($uName));
                    $finReg = $query->rowCount();
                    if(!empty($finReg))
                    {
                        return 'fregPass';
                    }
                    return 'fregOpen';
                }
                
                $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE username = ? ");
                $query->execute(array($uName));
                $finReg = $query->rowCount();
                if(!empty($finReg)){
                    return 'fregPass';
                }
                return 'fregOpen';
            }
        }
        
        


        
        

        
        
        
        
        
    /***********************
         Получить статус на турнире
                                ***********************/
        
        function tourUserCheck($uName){
            
            if(empty($uName)){
                return 'noTour';
            }
            
            $query = $this->db->prepare(" SELECT tourid FROM oF_tour_users WHERE username = ? ");
            $query->execute(array($uName));
            if($query->rowCount() > 0 ){
                $tourid = $query->fetch();
                return $tourid['tourid']; 
            }
            return 'noTour'; 
      
        }
        
        
        

        
        
        
    /***********************
              Подтвердить участие
                                ***********************/
        
        function tourAccDuel($uName, $tData, $tUser)
        {
            $sql = " UPDATE ".'oF_tour_table_'.$tData['id']." SET tConfirm = '' WHERE username = '".$uName."'; 
                     UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET tConfirm = '' WHERE username = '".$uName."' ";
            $this->db->prepare($sql)->execute(); 
        }
            
            
        
        
        
        
        
        
    /***********************
               Получить раунд игрока
                                ***********************/
        function tourUserRound($tUser, $tData)
        { 
            if($tData['tourmod'] == 'Spartan')
            {
                if(empty($tUser['MoveTo_SE']))
                {
                    for($i = 1; $i < 12; $i ++){ 
                        if(empty($tUser['r'.$i.'finalrez'])){
                            break;  
                        }
                        if($i > 3){
                            $i = 3;
                        }
                    }
                    return min($i, 3);
                } 
                if(!empty($tUser['MoveTo_SE']))
                {
                    goto tourUserRoundOlympia;
                } 
            }
            
            if($tData['tourmod'] == 'Olympia')
            {
                tourUserRoundOlympia:
                
                for($i = 1; $i < 12; $i ++){ 
                    if(empty($tUser['r'.$i.'finalrez'])){
                        break;  
                    }
                    if($i == 12){
                        $i = 1;
                    }
                }   
                $i = min($tData['tourrounds'], $i);
            }
            return $i;
        }
        
        
        
        
        
        
        
    /***********************
         Получить юзера из турнира
                                ***********************/
        
        function tourUser($tData, $uName)
        {
            if($tData['tourmod'] == 'Spartan')
            {

                $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE MoveTo_SE = 'y' AND username = ? ");
                $query->execute(array($uName));
                if($query->rowCount() == 0){
                    $query = $this->db->prepare(" SELECT * FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username = ? ");
                    $query->execute(array($uName));
                    return $query->fetch();

                }else{

                    $query = $this->db->prepare(" SELECT * FROM ".'oF_tour_table_'.$tData['id']." WHERE username = ? ");
                    $query->execute(array($uName));
                    return $query->fetch();

                }   
            }
            
            $query = $this->db->prepare(" SELECT * FROM ".'oF_tour_table_'.$tData['id']." WHERE username = ? ");
            $query->execute(array($uName));
            return $query->fetch();
 
        }

        
        
        
   
    /***********************
                Получить противника
                                ***********************/
        
        function tourEnemy($tData, $tUser, $round)
        {
           
            if($tData['tourmod'] == 'Spartan')
            {
                if(empty($tUser['MoveTo_SE']))
                {
                    if( $round == 1 )
                    {
                        $sql = " SELECT * FROM ".'oF_tour_brackettable_'.$tData['id']." 
                                 WHERE ".'Back_r'.$round." = '".$tUser['Back_r'.$round]."' 
                                 AND username != '".$tUser['username']."' AND r2 = '".$tUser['r2']."' ";
                    } else {
                        $sql = " SELECT * FROM ".'oF_tour_brackettable_'.$tData['id']." 
                                 WHERE ".'Back_r'.$round." = '".$tUser['Back_r'.$round]."' 
                                 AND username != '".$tUser['username']."' AND r2 = '".$tUser['r2']."' AND ".'r'.( $round - 1 ).'finalrez'." != '' ";
                    }
                    
                    $query = $this->db->query($sql);
                    $tEnemy = $query->fetch();
                    return $tEnemy;

                } 
                
                if(!empty($tUser['MoveTo_SE']))
                {
                    
                    lebelTourEnemyOlympia:
                    
                    if($round == 1)
                    {
                        $sql = " SELECT * FROM ".'oF_tour_table_'.$tData['id']." WHERE ".'r'.$round." = '".$tUser['r'.$round]."' 
                                 AND username != '".$tUser['username']."' AND username !='' ";
                    } else {
                        $sql = " SELECT * FROM ".'oF_tour_table_'.$tData['id']." WHERE ".'r'.$round." = '".$tUser['r'.$round]."' 
                                 AND ".'r'.($round - 1).'finalrez'." = 'W' AND username != '".$tUser['username']."' AND username !='' ";
                    }
                    
                    if($tData['tourrounds'] == $round && $tUser['r'.($round - 1).'finalrez'] == 'D')
                    {
                        unset($sql);
                        $sql = " SELECT * FROM ".'oF_tour_table_'.$tData['id']." WHERE ".'r'.$round." = '".$tUser['r'.$round]."' 
                                 AND ".'r'.($round - 1).'finalrez'." = 'D' AND username != '".$tUser['username']."' AND username != 'Free Slot' ";
                    }

                    $query = $this->db->prepare($sql);
                    $query->execute();
                    return $query->fetch();
                    
                }
            } 
            
            if($tData['tourmod'] == 'Olympia')
            {
                goto lebelTourEnemyOlympia;
            }
            
        }
        
        function getAllEnemyInGroup($tUser, $tData)
        {
            return $this->db->query(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE r2 = '".$tUser['r2']."' ")->fetchAll(PDO::FETCH_COLUMN);
        }
        
        
       

        
    /***********************
         Получить статус участника
                                ***********************/

    function getMoveFin($tData, $tUser)
    {
        $tMoveFin = array();
        $query = $this->db->query(" SELECT points FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE r2 = '".$tUser['r2']."' AND r3finalrez != '' ")->fetchAll(PDO::FETCH_COLUMN);
        $tMoveFin['count'] = count($query);
        if( $tMoveFin['count'] > 3 )
        {
            rsort($query);
            $tmp = array_slice($query, 0, 2);
            $tMoveFin['criteria'] = min($tmp[0], $tmp[1]);
            return $tMoveFin;
        }
    }
        
        
     
    function tourUserStatus($tData, $tUser, $tEnemy, $round)
    {
        if($tData['tourmod'] == 'Spartan')
        {
            if(empty($tUser['MoveTo_SE']))
            {
                if($tUser['tConfirm'] != 0)
                {
                    return 'ShowConfirm';
                }

                $tMoveFin = $this->getMoveFin($tData, $tUser);
                
            //------> переход в финал
                
                if( $tMoveFin['count'] > 3 && empty($tUser['MoveTo_SE']) )
                {
                    
                    //---------> 
                    
                    if( $tUser['points'] >= $tMoveFin['criteria'] )
                    {
                        $sql = " UPDATE IGNORE ".'oF_tour_table_'.$tData['id']." 
                                 SET username = '".$tUser['username']."', race1 = '".$tUser['race1']."', race2 = '".$tUser['race2']."', race3 = '".$tUser['race3']."'
                                 WHERE Backet = '".$tUser['r2']."' AND username = '' ORDER BY r0 LIMIT 1;
                                 UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET MoveTo_SE = 'y' WHERE username = '".$tUser['username']."' ";
                        $query = $this->db->query($sql);
                        return 'ReloadEndGroup';
                    } else {
                        $query = $this->db->query(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET MoveTo_SE = 'n' WHERE username = '".$tUser['username']."' ");
                        $this->tourEndForUser($tUser['username']);
                        return 'TourEndForUser';
                    }
                }

            //------> проигрышь в группе               
                
                if( $tUser['MoveTo_SE'] == 'n' )
                {
                    $this->tourEndForUser($tUser['username']);
                    return 'TourEndForUser';
                }
                
            //------> ждем окончания группы                          
                
                if( $tMoveFin['count'] < 4 && !empty($tUser['r'.$round.'finalrez']) )
                {     
                    return 'WaitGroupEnd';
                }
                
                if( $tEnemy['username'] == 'Free Slot' )
                {
                    $query = $this->db->query(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                                                SET ".'r'.$round.'rez'." = 'W', ".'r'.$round.'finalrez'." = 'W'
                                                WHERE username = '".$tUser['username']."' ");
                    return 'ReloadFreeSlot';
                }
                
                if( empty($tEnemy) )
                {
                    return 'EnemyEmpty';
                }


                if( empty($tUser['r'.$round.'rez']) )
                {
                    return 'UserResultEmpty';
                }


                if( empty($tEnemy['r'.$round.'rez']) )
                {
                    return 'EnemyResultEmpty';
                }


                if( $tUser['r'.$round.'rez'] == $tEnemy['r'.$round.'rez'] )
                {
                    return 'ResultError';
                }
                
                
            }
            if(!empty($tUser['MoveTo_SE']))
            {
                goto lebeltourUserStatusOlympia;  
            }
        }
        
        if($tData['tourmod'] == 'Olympia')
        {
            if($tUser['tConfirm'] != 0)
            {
                return 'ShowConfirm';
            }
            
            lebeltourUserStatusOlympia:
            
        //------> определяем 1-4 места
            
            if( $round == $tData['tourrounds'] )
            {
                  if( $tUser['r'.($round - 1).'finalrez'] == 'W' )
                  {
                        if( $tUser['r'.$round.'finalrez'] == 'W' )
                        {
                            $check = $this->tourEnd($tData, 'no');
                            return 'UserWinPlace_1';
                        }
                        if( $tUser['r'.$round.'finalrez'] == 'D' )
                        {
                            return 'UserWinPlace_2';
                        }
                  }
                  if( $tUser['r'.($round - 1).'finalrez'] == 'D' )
                  {
                        if( $tUser['r'.$round.'finalrez'] == 'W' )
                        {
                            $check = $this->tourEnd($tData, 'no');
                            return 'UserWinPlace_3';
                        }
                        if( $tUser['r'.$round.'finalrez'] == 'D' )
                        {
                            $this->tourEndForUser($tUser['username']);
                            return 'TourEndForUser';
                        }
                  }
            }

            if( $tUser['r'.$round.'finalrez'] == 'D' || $tUser['r'.($round - 1).'finalrez'] == 'D' && $round != $tData['tourrounds'] )
            {
                 $this->tourEndForUser($tUser['username']);
                 return 'TourEndForUser';
            }

            if( $tEnemy['username'] == 'Free Slot' ||  $tEnemy['FreeSlotHide'] == 'y')
            {
                $query = $this->db->query(" UPDATE ".'oF_tour_table_'.$tData['id']." 
                                            SET ".'r'.$round.'rez'." = 'W', ".'r'.$round.'finalrez'." = 'W', ".'r'.$round.'score'." = 2
                                            WHERE username = '".$tUser['username']."' ");
                return 'ReloadFreeSlot';
            }

            if( empty($tEnemy) )
            {
                 return 'EnemyEmpty';
            }

            if( empty($tUser['r'.$round.'rez']) )
            {
                 return 'UserResultEmpty';
            }

            if( empty($tEnemy['r'.$round.'rez']) )
            {
                 return 'EnemyResultEmpty';
            }

            if( $tUser['r'.$round.'rez'] == $tEnemy['r'.$round.'rez'] )
            {
                  return 'ResultError';
            }
            
        }
    }
        

        
    /***********************
    Завершить турнир для пользователя
                                ***********************/
        
        function tourEndForUser($uName){
            
            $query = $this->db->prepare(" DELETE FROM oF_tour_users WHERE username = ? ");
            $query->execute(array($uName));
            
        }
        
        
    /***********************
          Пререгистрация на турнире
                                ***********************/
        
        function tourPreReg($uName, $tData)
        { 
            $query = $this->db->prepare(" INSERT INTO ".'oF_tour_pretable_'.$tData['id']." (username) VALUES (?) ");
            $query->execute(array($uName));
        }
        

    /***********************
            Регистрация на турнире
                                ***********************/
        
        function tourRegNormal($uName, $tData, $arg1, $arg2, $arg3)
        {    
            if($tData['tourgame'] == 'Hearthstone')
            {
                if($tData['tourmod'] == 'Spartan')
                {  
                    $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username = ? ");
                    $query->execute(array($uName));
                    if($query->rowCount() > 0){ return 0;}
                    $query = $this->db->prepare(" INSERT INTO ".'oF_tour_brackettable_'.$tData['id']." (username, race1, race2, race3) VALUES (?, ?, ?, ?) ");
                    $query->execute(array($uName, $arg1, $arg2, $arg3)); return 0;
                }
                if($tData['tourmod'] == 'Olympia')
                {  
                    $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE username = ? ");
                    $query->execute(array($uName));
                    if($query->rowCount() > 0){ return 0;}
                    $query = $this->db->prepare(" INSERT INTO ".'oF_tour_table_'.$tData['id']." (username, race1, race2, race3) VALUES (?, ?, ?, ?) ");
                    $query->execute(array($uName, $arg1, $arg2, $arg3)); return 0;
                }  
            }
            if($tData['tourgame'] == 'Starcraft')
            {
                if($tData['tourmod'] == 'Spartan')
                {  
                    $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username = ? ");
                    $query->execute(array($uName));
                    if($query->rowCount() > 0){ return 0;}
                    $query = $this->db->prepare(" INSERT INTO ".'oF_tour_brackettable_'.$tData['id']." (username) VALUES (?) ");
                    $query->execute(array($uName)); return 0;
                }
                if($tData['tourmod'] == 'Olympia')
                {  
                    $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE username = ? ");
                    $query->execute(array($uName));
                    if($query->rowCount() > 0){ return 0;}
                    $query = $this->db->prepare(" INSERT INTO ".'oF_tour_table_'.$tData['id']." (username) VALUES (?) ");
                    $query->execute(array($uName)); return 0;
                }  
            }
        }


    /***********************
                   Ввод результатов
                                ***********************/
        function tourResult($uName, $tData, $tUser, $round, $tmpRez, $result){
            
            if($tData['tourmod'] == 'Spartan')
            {
                if(empty($tUser['MoveTo_SE']))
                {
                    $query = $this->db->prepare(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET ".'r'.$round.'rez'." = ?, tmpRez = ?, rtime = NOW() WHERE username = ? ");
                    $query->execute(array($result, $tmpRez, $uName));   
                    return true;
                } 
                
                if(!empty($tUser['MoveTo_SE']))
                {
                    $query = $this->db->prepare(" UPDATE ".'oF_tour_table_'.$tData['id']." SET ".'r'.$round.'rez'." = ?, tmpRez = ? WHERE username = ? ");
                    $query->execute(array($result, $tmpRez, $uName));   
                    return true;
                }
            }
            
            $query = $this->db->prepare(" UPDATE ".'oF_tour_table_'.$tData['id']." SET ".'r'.$round.'rez'." = ?, tmpRez = ? WHERE username = ? ");
            $query->execute(array($result, $tmpRez, $uName));   
            
        }
        
        
        function tourCancelResult($tData, $tUser, $round)
        {
            if($tData['tourmod'] == 'Spartan')
            {
                if(empty($tUser['MoveTo_SE']))
                {
                    $table = 'oF_tour_brackettable_'.$tData['id'];
                }
                if(!empty($tUser['MoveTo_SE']))
                {
                    $table = 'oF_tour_table_'.$tData['id'];
                }
            }
            if($tData['tourmod'] == 'Olympia')
            {
                $table = 'oF_tour_table_'.$tData['id'];
            }
            $this->db->query(" UPDATE ".$table." SET ".'r'.$round.'rez'." = '' WHERE username = '".$tUser['username']."' ");  
        }


        
        
    /***********************
                       Tour Rate Value
                                ***********************/
        
        function getTourRateValue($uName, $fScore, $type)
        {
            $data = $this->db->query(" SELECT wincount, defeatcount FROM oFight_users_HS WHERE username = '$uName' ")->fetch(PDO::FETCH_ASSOC);

            if( abs($fScore[0] - $fScore[1]) == 1 )
            {
                $k1 = 0.8;
            } else {
                $k1 = 1;
            }
            
            if( $type == 'win' )
            {
                $p = 1;
                
                if( ($data['wincount'] + $data['defeatcount']) == 0 )
                {
                    $c = 1;
                } else {
                    $c = $data['wincount'] + $data['defeatcount'];  
                }
                
                $wc = $data['wincount']/$c;
                
                if( empty($data['wincount']) || !empty($data['defeatcount']) )
                {
                    $k2 = 0.2;
                }
                
                if( !empty($data['wincount']) && $data['wincount'] > 0 )
                {
                    $k2 = 0.3;
                }
                
                if( $data['wincount'] == 2 )
                {
                    $k2 = 0.4;
                }
                
                if( $data['wincount'] < $data['defeatcount'] && $data['wincount'] <= 2 )
                {
                    $k2 = 0.25;
                }
                
                if( $data['wincount'] == 3 )
                {
                    $k2 = 0.5;
                }

                if( $data['wincount'] > 3 )
                {
                    $k2 = min($wc, 0.6);
                }

                if( $data['wincount'] > 7 )
                {
                    $k2 = min($wc, 0.7);
                }

                if( $data['wincount'] > 15 )
                {
                    if( $wc > 0.5 )
                    {
                        $k2 = 1;
                    } else {
                        $k2 = 0.8;
                    }
                } 
                return $p + min((1 * $k1 * $k2), 1.5);
            }
            
            if( $type == 'def' )
            {
                if( empty($data['wincount']) || !empty($data['defeatcount']) )
                {
                    $k2 = 1;
                }
                
                if( !empty($data['wincount']) && $data['wincount'] > 0 )
                {
                    $k2 = 0.9;
                }
                
                if( $data['wincount'] == 2 )
                {
                    $k2 = 0.85;
                }
                
                if( $data['wincount'] < $data['defeatcount'] && $data['wincount'] <= 2 )
                {
                    $k2 = 0.95;
                }
                
                if( $data['wincount'] >= 3 )
                {
                    $k2 = 0.8;
                }

                if( $data['wincount'] >= 5 )
                {
                    $k2 = 0.75;
                }

                if( $data['wincount'] >= 7 )
                {
                    $k2 = 0.70;
                }
                return $k1 * $k2;  
            }

        }

        
        
        
        
        
        
    /***********************
             Продвижение по турниру
                                ***********************/
        
        function tourResultFinal($uName, $tData, $tUser, $round, $tEnemy)
        {
            
            if($tData['tourmod'] == 'Spartan')
            {
                if(empty($tUser['MoveTo_SE']))
                {
                    if($tUser['r'.$round.'rez'] == 'W' && $tEnemy['r'.$round.'rez'] == 'D')
                    {
                        $fScore = explode(':', $tUser['tmpRez']);
                        
                        $prateWinner = $this->getTourRateValue($tEnemy['username'], $fScore, 'win');
                        $prateLosser = $this->getTourRateValue($tUser['username'], $fScore, 'def');
                        
                        $query = $this->db->prepare(" UPDATE ".'oF_tour_brackettable_'.$tData['id']."
                                                      SET ".'r'.$round.'finalrez'." = 'W', tmpRez = '', rtime = '0', points = points + '$prateWinner', tConfirm = NOW()
                                                      WHERE username = '".$uName."';
                                                      
                                                      UPDATE oFight_users_HS SET wincount = wincount + 1 WHERE username = '".$uName."';
                                                      
                                                      UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                                                      SET ".'r'.$round.'finalrez'." = 'D', tmpRez = '', rtime = '0', points = points - '$prateLosser'
                                                      WHERE username = '".$tEnemy['username']."';
                                                      
                                                      UPDATE oFight_users_HS SET defeatcount = defeatcount + 1 WHERE username = '".$tEnemy['username']."' ")->execute();

                    //------> Если фри слот предыдущий, то смотрим $round - 2
                    /*
                        
                        $sql = " SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." 
                                 WHERE r2 = '".$tUser['r2']."' AND ".'Back_r'.($round - 1)." = '".$tUser['Back_r'.($round - 1)]."' AND username = 'Free Slot' ";
                        $query = $this->db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
                        if( count($query) > 0 )
                        {
                            $winRate = $round - 2;
                        } else {
                            $winRate = $round - 1;   
                        }  
                        
                        if( $tUser['r'.$winRate.'rez'] == 'W' && $round > 1)
                        {
                            $query = $this->db->query(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET points = points + 1 WHERE username = '".$uName."' "); 
                        }   
                        */
                    }
                    
                    if($tUser['r'.$round.'rez'] == 'D' && $tEnemy['r'.$round.'rez'] == 'W')
                    {
                        $fScore = explode(':', $tEnemy['tmpRez']);
                        
                        $prateWinner = $this->getTourRateValue($tUser['username'], $fScore, 'win');
                        $prateLosser = $this->getTourRateValue($tEnemy['username'], $fScore, 'def');

                        $query = $this->db->prepare(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                                                      SET ".'r'.$round.'finalrez'." = 'D', tmpRez = '', rtime = '0', points = points - '$prateLosser'
                                                      WHERE username = '".$uName."';
                                                      
                                                      UPDATE oFight_users_HS SET defeatcount = defeatcount + 1 WHERE username = '".$uName."';
                                                      
                                                      UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                                                      SET ".'r'.$round.'finalrez'." = 'W', tmpRez = '', rtime = '0', points = points + '$prateWinner', tConfirm = NOW()
                                                      WHERE username = '".$tEnemy['username']."';
                                                      
                                                      UPDATE oFight_users_HS SET wincount = wincount + 1 WHERE username = '".$tEnemy['username']."' ")->execute();
                        

                    //------> Если фри слот предыдущий, то смотрим $round - 2
                    
                        $sql = " SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." 
                                 WHERE r2 = '".$tEnemy['r2']."' AND ".'Back_r'.($round - 1)." = '".$tEnemy['Back_r'.($round - 1)]."' AND username = 'Free Slot' ";
                        $query = $this->db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
                        if( count($query) > 0 )
                        {
                            $winRate = $round - 2;
                        } else {
                            $winRate = $round - 1;   
                        }  
                        
                        if( $tEnemy['r'.$winRate.'rez'] == 'W' && $round > 1)
                        {
                            $query = $this->db->query(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET points = points + 1 WHERE username = '".$tEnemy['username']."' "); 
                        }
                        
                    } 
                } 
                
                if(!empty($tUser['MoveTo_SE']))
                {
                    goto lebeltourResultFinalOlympia;
                }
            }
            
            if($tData['tourmod'] == 'Olympia')
            {
                
                lebeltourResultFinalOlympia:
                
                if($tUser['r'.$round.'rez'] == 'W' && $tEnemy['r'.$round.'rez'] == 'D')
                {

                    $fScore = explode(':', $tUser['tmpRez']);
                    $query = $this->db->prepare(" UPDATE ".'oF_tour_table_'.$tData['id']."
                                                  SET ".'r'.$round.'finalrez'." = 'W', ".'r'.$round.'score'." = '".$fScore[0]."', tmpRez = '', tConfirm = NOW() WHERE username = '".$uName."';
                                                  UPDATE oFight_users_HS SET wincount = wincount + 1 WHERE username = '".$uName."';
                                                  UPDATE ".'oF_tour_table_'.$tData['id']." 
                                                  SET ".'r'.$round.'finalrez'." = 'D', ".'r'.$round.'score'." = '".$fScore[1]."', tmpRez = '', tDoubleElem = 'yes' WHERE username = '".$tEnemy['username']."';
                                                  UPDATE oFight_users_HS SET defeatcount = defeatcount + 1 WHERE username = '".$tEnemy['username']."' ")->execute();
                }

                if($tUser['r'.$round.'rez'] == 'D' && $tEnemy['r'.$round.'rez'] == 'W')
                {
                    $fScore = explode(':', $tEnemy['tmpRez']);
                    $query = $this->db->prepare(" UPDATE ".'oF_tour_table_'.$tData['id']." 
                                                  SET ".'r'.$round.'finalrez'." = 'D', ".'r'.$round.'score'." = '".$fScore[1]."', tmpRez = '', tDoubleElem = 'yes' WHERE username = '".$uName."';
                                                  UPDATE oFight_users_HS SET defeatcount = defeatcount + 1 WHERE username = '".$uName."';
                                                  UPDATE ".'oF_tour_table_'.$tData['id']." 
                                                  SET ".'r'.$round.'finalrez'." = 'W', ".'r'.$round.'score'." = '".$fScore[0]."', tmpRez = '', tConfirm = NOW() WHERE username = '".$tEnemy['username']."';
                                                  UPDATE oFight_users_HS SET wincount = wincount + 1 WHERE username = '".$tEnemy['username']."' ")->execute();
                }    
            }
            
        }
        

    /***********************
                    Get row data from SHM
                                ***********************/

        function tourGetPlayers($tData)
        {
            if($tData['tourmod'] == 'Spartan')
            {
                $query = $this->db->query(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username != 'Free Slot' ");
                return $query->fetchAll(PDO::FETCH_COLUMN);   
            }
            if($tData['tourmod'] == 'Olympia')
            {
                $query = $this->db->query(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE username != 'Free Slot' ");
                return $query->fetchAll(PDO::FETCH_COLUMN);   
            }
        }
        
        function tourGetAllPlayers()
        {
            return $this->db->query(" SELECT username, tourid FROM oF_tour_users ")->fetchAll(PDO::FETCH_ASSOC);  
        }

        
        
        
        
    /***********************
            Создание турнира Spartan
                                ***********************/
        
        function startTourSpartan($tData){
            
    //------> Генерация групповой сетки
            
            $playerNames = $this->db->query(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." ")->fetchAll(PDO::FETCH_COLUMN);
            $playerCount = count($playerNames);
            $maxPlayers = pow(2, ceil(log($playerCount, 2)));
            $maxFS_real = ceil($playerCount / 4) * 4 - $playerCount;
            
            while($playerCount < (ceil($playerCount / 4) * 4))
            {
                $query = $this->db->prepare(" INSERT INTO ".'oF_tour_brackettable_'.$tData['id']." (username) VALUES ('Free Slot') ")->execute();
                $playerCount++;
            }

            $i = 1;
            foreach($playerNames as $key => $username)
            {
                $query = $this->db->prepare(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET r0 = '".$i."' WHERE username = '".$username."' ")->execute();
                $query = $this->db->prepare(" INSERT INTO oF_tour_users (username, tourid) VALUE ('".$username."', '".$tData['id']."') ")->execute();
                
                $i++;
                if( ($maxFS_real > 0) && ($i % 3 == 0) )
                {
                    $query = $this->db->prepare(" UPDATE ".'oF_tour_brackettable_'.$tData['id']." 
                                                  SET r0 = '".$i."', r1rez = 'D', r1finalrez = 'D', r2rez = 'D', r2finalrez = 'D', r3rez = 'D', r3finalrez = 'D', points = - 6
                                                  WHERE username = 'Free Slot' AND r0 = '' LIMIT 1 ")->execute();
                    $i++; 
                    $maxFS_real--;
                }
            }

            for($k = 1; $k <= $maxPlayers; $k++)
            {
                for($i = 1; $i <= 2; $i++)
                {
                     ${'r'.$i} = ceil($k/pow(2,$i));
                     if($i == 1)
                     {
                         $sql = $sql." r".$i." = '".${'r'.$i}."'";
                     } else {
                         $sql = $sql.", r".$i." = '".${'r'.$i}."'";
                     }   
                }
                $sql = "UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET ".$sql." WHERE r0 = '".$k."' ";
                $query = $this->db->prepare($sql)->execute();
                unset($sql);
            }

            
    //------> Генерация сетки на вылет
            
            
            $backets = array(
                                '1' => 'Back_r1 = 1, Back_r2 = 1, Back_r3 = 0',
                                '2' => 'Back_r1 = 1, Back_r2 = 0, Back_r3 = 1',
                                '3' => 'Back_r1 = 0, Back_r2 = 1, Back_r3 = 1',
                                '4' => 'Back_r1 = 0, Back_r2 = 0, Back_r3 = 0'
                            );

            $i = 1;
            for($k = 1; $k <= $maxPlayers; $k++)
            {
                $sql = "UPDATE ".'oF_tour_brackettable_'.$tData['id']." SET ".$backets[$i]." WHERE r0 = '".$k."' ";
                $query = $this->db->prepare($sql)->execute();
                unset($sql);
                $i++;
                if($i == 5)
                {
                    $i = 1;
                }
            }
            
            $maxPlayers = $maxPlayers / 2;
            $mRounds = log(($maxPlayers),2);
            
            $query = $this->db->prepare(" UPDATE oF_tour_cPanel SET tourrounds = '".$mRounds."' WHERE id = '".$tData['id']."' ")->execute();
            

            for($k = 1; $k <= $maxPlayers; $k++)
            {
                $query = $this->db->prepare(" INSERT INTO ".'oF_tour_table_'.$tData['id']." (r0) VALUES ('".$k."') ")->execute();
            }

            for($k = 1; $k <= $maxPlayers; $k++)
            {
                for($i = 1; $i <= $mRounds; $i++)
                {
                     ${'r'.$i} = ceil($k/pow(2,$i));
                     if($i == 1)
                     {
                         $sql = $sql." r".$i." = '".${'r'.$i}."'";
                     } else {
                         $sql = $sql.", r".$i." = '".${'r'.$i}."'";
                     }   
                }
                $sql = "UPDATE ".'oF_tour_table_'.$tData['id']." SET ".$sql." WHERE r0 = '".$k."' ";
                $query = $this->db->prepare($sql)->execute();
                unset($sql); 
            }
                        
            $FS_pOff = $maxPlayers - ceil($playerCount / 4) * 2;
            
            for($i = 1; $i <= $maxPlayers; $i++)
            {
                if( ($i % 2 == 0) && ($FS_pOff > 0) )
                {
                    $query = $this->db->prepare(" UPDATE ".'oF_tour_table_'.$tData['id']." SET
                                                  username = 'Free Slot', r1rez = 'D', r2rez = 'D', r3rez = 'D', r1finalrez = 'D', r2finalrez = 'D', r3finalrez = 'D'
                                                  WHERE r0 = '".$i."' ")->execute();
                    $FS_pOff--;
                }   
            }
            

            $r0_pOff = $this->db->query(" SELECT r0 FROM ".'oF_tour_table_'.$tData['id']." WHERE username = '' ")->fetchAll(PDO::FETCH_COLUMN);
            
            $k = 1;
            foreach($r0_pOff as $key => $val)
            {
                $query = $this->db->prepare(" UPDATE ".'oF_tour_table_'.$tData['id']." SET Backet = '".$k."' WHERE r0 = '".$val."' ")->execute();
                $k++;
                if( $k > ceil($playerCount / 4) )
                {
                    $k = 1;
                }
            }
            
            $query = $this->db->prepare(" UPDATE oF_tour_cPanel SET tourtechstart = 'yes' WHERE id = '".$tData['id']."' ")->execute();
            $this->db->query(" update ".'oF_tour_brackettable_'.$tData['id']." set tConfirm = NOW() WHERE username != 'Free Slot' ");
            
            
            
        }

        function startTourOlympia($tData)
        {
            $playerNames = $this->db->query(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." ")->fetchAll(PDO::FETCH_COLUMN);
            $playerCount = count($playerNames);
            $maxPlayers = pow(2, ceil(log($playerCount, 2)));
            $mFS = $maxPlayers - $playerCount;
            $mRounds = log(($maxPlayers),2);
            $query = $this->db->query(" UPDATE oF_tour_cPanel SET tourrounds = '".$mRounds."' WHERE id = '".$tData['id']."' ");
            
            $sql = " INSERT INTO ".'oF_tour_table_'.$tData['id']." (username, r0, r1rez, r1finalrez, r2rez, r2finalrez, r3rez, r3finalrez, r4rez, r4finalrez, r5rez, r5finalrez, r6rez, r6finalrez, r7rez, r7finalrez, r8rez, r8finalrez, r9rez, r9finalrez, r10rez, r10finalrez ) VALUES ('Free Slot', '0', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D', 'D' ) ";

            $mFS_lim = $mFS;
            while($mFS_lim > 0)
            {
                $query = $this->db->query($sql);
                $mFS_lim--;
            }  
            unset($sql);

            $mFS_lim = $mFS;
            $c = 0;
            for($i = 1; $i <= $maxPlayers; $i++)
            {
                if($i % 2 == 0 && $mFS_lim > 0)
                {
                    $query = $this->db->query(" UPDATE ".'oF_tour_table_'.$tData['id']." SET r0 = '".$i."' WHERE username = 'Free Slot' AND r0 = 0 LIMIT 1 ");
                    $mFS_lim--;
                } else {
                    $query = $this->db->query(" UPDATE ".'oF_tour_table_'.$tData['id']." SET r0 = '".$i."' WHERE username = '{$playerNames[$c]}' "); 
                    $c++;
                }
            }
            
            for($k = 1; $k <= $maxPlayers; $k++)
            {
                for($i = 1; $i <= $mRounds; $i++)
                {
                     ${'r'.$i} = ceil($k/pow(2,$i));
                     if($i == 1)
                     {
                         $sql = $sql." r".$i." = '".${'r'.$i}."'";
                     } else {
                         $sql = $sql.", r".$i." = '".${'r'.$i}."'";
                     }   
                }
                $sql = "UPDATE ".'oF_tour_table_'.$tData['id']." SET ".$sql." WHERE r0 = '".$k."' ";
                $query = $this->db->query($sql);
                unset($sql); 
            } 
            
            $this->db->query(" UPDATE oF_tour_cPanel SET tourtechstart = 'yes' WHERE id = '".$tData['id']."' ");
            
            foreach($playerNames as $key => $username)
            {
                $this->db->query(" INSERT INTO oF_tour_users (username, tourid) VALUE ('".$username."', '".$tData['id']."') ");
            }

            $this->db->query(" update ".'oF_tour_table_'.$tData['id']." set tConfirm = NOW() WHERE username != 'Free Slot' ");
        }
        
        
    /***********************
                       Get Group Enemy
                                ***********************/

        function tourGetGroupEnemy($tData, $tUser)
        {
            $sql = " SELECT ".'oF_tour_brackettable_'.$tData['id'].".username, oFight_users.avatar 
                     FROM ".'oF_tour_brackettable_'.$tData['id']." INNER JOIN oFight_users ON ".'oF_tour_brackettable_'.$tData['id'].".username = oFight_users.username 
                     WHERE ".'oF_tour_brackettable_'.$tData['id'].".r2 = '".$tUser['r2']."' ";
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);  
        }
        
        
        
                

        
        
        
        
    /***********************
                        Get Keyfrom SHM
                                ***********************/

        function shmGetKey($uName, $SHMTourney)
        {
            foreach($SHMTourney as $key => $val)
            {  
               if($val['username'] == $uName)
               {
                   return $key;
               }      
            }

        }
        
        
        function shmGetData($tData)
        {
            $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username != 'Free slot' ");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
        

        
        
        
        
        
        

        
        
    /***********************
                        BRACKETS
                                ***********************/
        function getBracket($tData){

            if($tData['tourmod'] == 'Spartan')
            {
                
        //------> Group Stage

                $query = $this->db->query(" SELECT username, r2, points FROM ".'oF_tour_brackettable_'.$tData['id']." ORDER BY r1, points ASC ");
                $groupPlayers = $query->fetchAll(PDO::FETCH_ASSOC);
                $groupCount = count($groupPlayers) / 4;

                $group = array();
                for($i = 1; $i <= $groupCount; $i++)
                {
                    ${'bracket_'.$i} = array();
                    foreach($groupPlayers as $key => $val)
                    {
                        if($val['r2'] == $i)
                        {
                            $user = array();
                            $user = array("un" => $val['username'], "sc" => $val['points']);
                            array_push(${'bracket_'.$i}, $user);               
                            unset($user);
                        }
                    } 

                    usort(${'bracket_'.$i}, function($a, $b){
                        return $b['sc'] - $a['sc'];
                    }); 

                    array_push($group, ${'bracket_'.$i});
                }
                
                lebelgetBracketOlympia:
                
                $players = array();
                $results = array();
                $arrWinnerBracket = array();
                $arrLoserBracket = array();
                $arrFinalBracket = array();

                $query = $this->db->query(" SELECT MAX(r0) FROM ".'oF_tour_table_'.$tData['id']." ")->fetchAll(PDO::FETCH_COLUMN);
                $maxRound = log(($query[0]),2);

                $query = $this->db->query(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." ORDER BY r0 ASC ")->fetchAll(PDO::FETCH_COLUMN);
                $pCount = count($query);
                $players = $this->resPrepare($query);


        //------> Winner Line

                for($i = 1; $i < $maxRound; $i++){

                    if($i == 1){
                        $selectResults = $this->db->query(" SELECT ".'r'.$i.'score'." FROM ".'oF_tour_table_'.$tData['id']." ORDER BY r0 ASC ")->fetchAll(PDO::FETCH_COLUMN);
                        
                        // $selectResults = $this->makeTableForBrackets(0, $selectResults, $tData['tourrounds']);
                        
                        $pairs = $this->resPrepare($selectResults);
                        array_push($arrWinnerBracket, $pairs);
                        unset($pairs);
                    }else{
                        $sql = " SELECT r".$i.", r".$i."score FROM oF_tour_table_".$tData['id']." WHERE r".($i - 1)."finalrez = 'W' ORDER BY r0 ASC ";
                        $selectResults = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                        
                        $selectResults = $this->makeTableForBrackets($i, $selectResults, $tData['tourrounds']);
                        
                        $pairs = $this->resPrepare($selectResults);
                        array_push($arrWinnerBracket, $pairs);
                        unset($pairs); 
                    }

                }

                
        //------> Finals / Semi - Finals

                $finals = array();
                $query_1 = $this->db->query(" SELECT ".'r'.$maxRound.'score'." FROM ".'oF_tour_table_'.$tData['id']." WHERE  ".'r'.($maxRound - 1).'finalrez'." = 'W' ORDER BY r1 ASC ")->fetchAll(PDO::FETCH_COLUMN);
                array_push($finals, $query_1);
                $query_2 = $this->db->query(" SELECT ".'r'.$maxRound.'score'." FROM ".'oF_tour_table_'.$tData['id']." WHERE  ".'r'.($maxRound - 1).'finalrez'." = 'D' ORDER BY r1 ASC ")->fetchAll(PDO::FETCH_COLUMN);
                array_push($finals, $query_2);
                array_push($arrWinnerBracket, $finals);

                array_push($results, $arrWinnerBracket);

                $SE_Names = $this->db->query(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE username != '' ")->fetchAll(PDO::FETCH_COLUMN);

                return $data = array("group" => $group, "SE_Names" => $SE_Names, "winners" => array("teams" => $players, "results" => $results));  
            }
            
            if($tData['tourmod'] == 'Olympia')
            {
                goto lebelgetBracketOlympia;
            }

        }
        
        
        function makeTableForBrackets($round, $data, $mRound)
        {
            $arrResult = array();
            $c = 1;
            $pair = 1;
            lebel_makeTableForBrackets:
            
                $true = false;
                foreach($data as $key => $val)
                {
                    if($val['r'.$round] == $pair)
                    { 
                        array_push($arrResult, $val['r'.$round.'score']);
                        unset($data[$key]);
                        $true = true;
                        break;
                    } 
                }   
                if($true !== true)
                {
                        array_push($arrResult, 0);
                }
            
            if($c % 2 == 0)
            {
                $pair++;
            }
            $c++;
            
            if($c <= pow(2, ($mRound - $round + 1)))
            {
                goto lebel_makeTableForBrackets;
            }
            return $arrResult;
        }
        
        
        function cleanArray($array)
        {
            $max = key(end($array)); //Get the final key as max!
            for($i = 0; $i < $max; $i++)
            {
                if(!isset($array[$i]))
                {
                    $array[$i] = '0';
                }
            }
        }
        

        function sSQL($round){
            for($i = 1; $i < $round; $i++){
                if($i != 1){
                    $and = ' AND ';
                }
                $loop = "r".$i."finalrez = 'W' "; 
                $sql = $sql.$and.$loop;  
            }
            return 'WHERE '.$sql;
        }
        
        function getArray($inArr) {
            $outArr = array();
            foreach($inArr as $this->key => $this->val) {
                foreach($this->val as $this->k => $this->v){
                    array_push($outArr, $this->v);
                }
            }
            return $outArr;
        }
        
        function resPrepare($inArr){
            
            $pair = array();
            $rpair = array();
            
            foreach($inArr as $this->k => $this->v){
                if(count($rpair) < 1){
                    array_push($rpair, $this->v);
                }elseif(count($inArr) == 1){
                    array_push($rpair, $this->v);
                    array_push($pair, $rpair);
                    $rpair = array();
                }else {
                    array_push($rpair, $this->v);
                    array_push($pair, $rpair);
                    $rpair = array();
                }
            }
            
            return $pair;
        }





        
        
    /***********************
                           CRON
                                ***********************/
    //------> Start
        
        function cronStartTour()
        {
            $query = $this->db->query(" SELECT id FROM oF_tour_cPanel WHERE tourdate < NOW() + 60 AND tourtechstart = '' ");
            return $query->fetchAll(PDO::FETCH_COLUMN); 
        }
        
    //------> Kick Leavers
        
        function cronDeleteLeavers()
        {
            $query = $this->db->query(" SELECT id FROM oF_tour_cPanel WHERE tourtechstart = 'yes' ");
            return $query->fetchAll(PDO::FETCH_COLUMN); 
        }
        
        function cronEndTour()
        {
            return $this->db->query(" SELECT id FROM oF_tour_cPanel WHERE tourdate < NOW() - 60*60*8 AND tourtechstart = 'yes' ")->fetchAll(PDO::FETCH_COLUMN);
        }
        
        
        
    /***********************
                Вывод пререгистрации
                                ***********************/
        
        function getPreRegPlayers($id)
        {
            $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_pretable_'.$id." ");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_COLUMN);
        }

        
        
        
        
        function testtest()
        {
            
            $query = $this->db->query(" SELECT username FROM oFight_users_HS ORDER BY id ASC ");
            $tourSelect = $query->fetchAll(PDO::FETCH_COLUMN); 

            foreach($tourSelect as $key => $val)
            {
                $i = $i +1;
                $query1 = $this->db->query(" UPDATE oFight_users_HS SET  WHERE username = '".$val."' ");

            } 
            echo $i;
        }
        
        
        
                    
    /***********************
                  Основной стрим турнира
                                ***********************/
                    
        function getTourMainStream()
        {
            return $this->db->query(" SELECT mainstream FROM oF_stream_main ")->fetchAll(PDO::FETCH_COLUMN);  
        }
        function setTourMainStream($streamer)
        {
            $query = $this->db->prepare(" UPDATE oF_stream_main SET mainstream = ? WHERE game = 'Hearthstone' ");
            $query->execute(array($streamer)); 
        }
        function delTourMainStream()
        {
            $this->db->query(" UPDATE oF_stream_main SET mainstream = '' WHERE game = 'Hearthstone' ");
        }
            

        
    /***********************
          Вывод зарегистрированных
                                ***********************/
        
        function getRegPlayers($tData){
            
            if($tData['tourmod'] == 'Spartan')
            {
                $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_brackettable_'.$tData['id']." WHERE username != 'Free slot' ");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_COLUMN);
            }

            $query = $this->db->prepare(" SELECT username FROM ".'oF_tour_table_'.$tData['id']." WHERE username != 'Free slot' ");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_COLUMN);
            
        }
        
        
        
        

        
    }


?>