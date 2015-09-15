<?

    define("OFIGHTENGINE", true);
    define ( 'ROOT_DIR', dirname ( __FILE__ ) );

    include_once('engine/configs/dbconfig.php');
    include_once('engine/classes/database.class.php');
    include_once(ROOT_DIR . '/engine/classes/simpleSHM.class.php');
    include_once(ROOT_DIR . '/engine/classes/users.class.php');
    $user = new Users();

    include_once('engine/classes/tournament.class.php');
    $tour = new Tournament();


    //------> End Tourney

        $data = $tour->cronEndTour();
        if(!empty($data))
        {
            foreach($data as $key => $id)
            {
                $tData = $tour->getTourinfo($id);
                $tour->tourEnd($tData, 'yes');
            }
        }

    //------> Start Tourney


        $id = $tour->cronStartTour();
        if(!empty($id))
        {
            foreach ($id as $key => $value)
            {
                $tData = $tour->getTourinfo($value);
   
                if($tData['tourdate'] > date("Y-m-d H:i:s"))
                {
                    echo 'time'; break;	
                }
                
                if($tData['tourmod'] == 'Spartan')
                {
                    $tour->startTourSpartan($tData);
                    echo ' Tourney ' . $tData['id'] . 'started';
                }
                
                if($tData['tourmod'] == 'Olympia')
                {
                    $tour->startTourOlympia($tData); 
                    echo ' Tourney ' . $tData['id'] . 'started';
                }

            // вливаем данные о конкретном турнире
                $obj = array();
                $playes = $tour->tourGetPlayers($tData);
                foreach($playes as $key => $val)
                {
                    $obj[$val] = '0'; 
                }
                $SHM = new Block($tData['id']);
                $SHM->write(json_encode($obj));
                
            // вливаем данные о всех турнирах и участниках
                $obj_tU = array();
                $data = $tour->tourGetAllPlayers();
                foreach($data as $key => $user)
                {
                    $obj_tU[$user['username']] = $user['tourid'];
                }
                $SHM = new Block('99999');
                $SHM->write(json_encode($obj_tU));
                
            }
        } else {
            echo 'start Tournye empty';	 
        }

    //------> Kick AFK

        $id = $tour->cronDeleteLeavers();
        if(!empty($id))
        {
            foreach ($id as $key => $value)
            {
                $tData = $tour->getTourinfo($value);   
                $tour->tourKickAfk($tData); 

                // вливаем данные о всех турнирах и участниках
                $obj_tU = array();
                $data = $tour->tourGetAllPlayers();
                foreach($data as $key => $user)
                {
                    $obj_tU[$user['username']] = $user['tourid'];
                }
                $SHM = new Block('99999');
                $SHM->write(json_encode($obj_tU));
            }
        } else {
            echo '<br>no afk in tourney';
        }





?>