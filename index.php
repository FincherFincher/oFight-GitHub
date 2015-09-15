<?php

    define('OFIGHTENGINE', true);
    define ( 'ROOT_DIR', dirname ( __FILE__ ) );

    include_once('engine/configs/dbconfig.php');
    include_once('engine/classes/users.class.php');
    include_once('engine/classes/database.class.php');
    include_once('engine/classes/news.class.php');
    include_once('engine/classes/instruments.class.php');
    include_once('engine/configs/config.php');
    $user = new Users();
    $news = new News();
    $inst = new Instruments();
    if($_GET['do'] == 'logout'){
        $user->logout();
        unset($_GET['do']);
        header('Location: /');
    }

    $db = new DB();
    $db = $db->connect();

    include_once('engine/classes/tournament.class.php');
    $tour = new Tournament();

    include_once('engine/classes/template.class.php');
    $tpl = new Template();
    $tpl->dir = ROOT_DIR . '/templates/' . 'Default';
    define ( 'TEMPLATE_DIR', $tpl->dir );
    
    include_once('engine/classes/router.class.php');
    

    $uinfo = array();

    $isAuth = $user->isAuth();

    if(!$isAuth){
        $uinfo['uGroup'] = 'g';
    } else {
        $uinfo = $user->info();
        setcookie('username', $uinfo['username'], 0);
        setcookie('img', $uinfo['avatar'], 0);
    }


    $router = new Router($tpl, $user, $tour, $news, $db, $config);
    if($router->mainPage) {
        $tpl->load_template('head.tpl');
        $tpl->set('{DESCRIPTION}', 'Турниры Hearthstone, Heroes of the storm');
        $tpl->set('{KEYWORDS}', 'Турниры Hearhstone, Heroes of the storm');
        $tpl->compile('head');
        $tpl->clear();
        $router->mainTitle = 'oFight.ru | Игровой портал';
        $tpl->load_template('shortstory.tpl');
        $singleNews = $tpl->copy_template;
        $new = 1;
        $snews = $news->getLastNews();
        foreach($snews as $k => $v){
            if($new === 1){
                $tpl->copy_template = str_ireplace("{IMAGE}", $v['picture'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TITLE}", $v['title'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{ATITLE}", $v['title'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{AUTHOR}", $v['author'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{DATE}", date('d M Y', strtotime($v['date'])), $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{PREVTEXT}", $v['prevtext'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{VIEWS}", $v['views'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{LINK}", $v['urlname'], $tpl->copy_template);
            } else {
                $tpl->copy_template .= $singleNews;
                $tpl->copy_template = str_ireplace("{IMAGE}", $v['picture'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TITLE}", $v['title'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{ATITLE}", $v['title'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{AUTHOR}", $v['author'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{DATE}", date('d M Y', strtotime($v['date'])), $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{PREVTEXT}", $v['prevtext'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{VIEWS}", $v['views'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{LINK}", $v['urlname'], $tpl->copy_template);
            }
            $new++;
        }
        $tpl->compile('news');
        $tpl->clear();
        
        
        
    /***********************
                         Winner's
                                ***********************/
        
        $tpl->load_template('block-winners.tpl');
        $single = $tpl->copy_template;
        $data = $user->getTourWinners();
        $tplloop = true;
        foreach($data as $key => $pData){
            if($tplloop === true){
                $tpl->copy_template = str_ireplace("{WINNERTOURNAME}", $pData['tourname'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{WINNERNAME}", $pData['username'], $tpl->copy_template);            
                $tpl->copy_template = str_ireplace("{WINNERTOURLOGO}", urldecode($pData['tourlogo']), $tpl->copy_template);    
                $tpl->copy_template = str_ireplace("{WINNERTOURGAME}", $pData['tourgame'], $tpl->copy_template);    
                unset($tplloop);
            } else {
                $tpl->copy_template .= $single;
                $tpl->copy_template = str_ireplace("{WINNERTOURNAME}", $pData['tourname'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{WINNERNAME}", $pData['username'], $tpl->copy_template);            
                $tpl->copy_template = str_ireplace("{WINNERTOURLOGO}", urldecode($pData['tourlogo']), $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{WINNERTOURGAME}", $pData['tourgame'], $tpl->copy_template); 
            }
        }
        $tpl->compile('winnerbox');
        $tpl->clear();
        
        
        
        $tpl->load_template('main.tpl');
        $tpl->set('{NEWS}', $tpl->result['news']);
        $tpl->set('{WINNERS}', $tpl->result['winnerbox']);
        // $tpl->set('{STREAMERS}', $tpl->result['streamers']);
        $tpl->compile('main-part');
        $tpl->clear();
    }
    $tpl->load_template('login.tpl');
    if($uinfo['group'] != 'g'){
        $tpl->set('{login}', $uinfo['username']);
    }
    $tpl->compile('login_sec');
    $tpl->clear();

    if(!isset($tpl->result['head'])){
        $tpl->load_template('head.tpl') ;
        $tpl->set("{DESCRIPTION}", 'oFight.ru');
        $tpl->set("{KEYWORDS}", 'oFight.ru');
        $tpl->compile('head');
        $tpl->clear();   
    }

    if(empty($router->mainTitle)){
        $router->mainTitle = 'oFight.ru | Игровой портал';
    }

    $tourInf = $tour->getTour();
    
    if(isset($tourInf[0])){
        $num = 1;
        $tpl->load_template('top-tour.tpl');
        
        $singleTour = $tpl->copy_template;

        foreach($tourInf as $k => $v){
            $tData = $tour->getTourinfo($v['id']);  
            $tStatus = $tour->tourStatus($uinfo['username'], $tData);
            if($num == 1){
                $tpl->copy_template = str_ireplace("{TOURNAME}", $v['tourname'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURPRIZE}", $v['tourprize'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURGAME}", $config['tourGameicon'][$v['tourgame']], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURDATE}", date('d M', strtotime($v['tourdate'])), $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURLINK}", $v['id'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURSTATUS}", $config['tourStatus'][$tStatus], $tpl->copy_template);
            } else {
                $tpl->copy_template .= $singleTour;
                $tpl->copy_template = str_ireplace("{TOURNAME}", $v['tourname'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURPRIZE}", $v['tourprize'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURGAME}", $config['tourGameicon'][$v['tourgame']], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURDATE}", date('d M', strtotime($v['tourdate'])), $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURLINK}", $v['id'], $tpl->copy_template);
                $tpl->copy_template = str_ireplace("{TOURSTATUS}", $config['tourStatus'][$tStatus], $tpl->copy_template);
            }
            $num++;
        }
        
        $tpl->compile('toptour');        
        $tpl->clear();
    }


    $arr_tData = $tour->getTourSpecial();
    if(!empty($arr_tData))
    {
        $tpl->load_template('top-tour.tpl');
        $single = $tpl->copy_template;
        $tplloop = true;
        foreach($arr_tData as $key => $v){
            $tData = $tour->getTourinfo($v['id']);  
            $tStatus = $tour->tourStatus($uinfo['username'], $tData);
            // вынести в конфиг /uploads/sys/up-1.jpg
            if($tour->tourStatus($uinfo['username'], $tour->getTourinfo($v['id'])) == 'pregOpen')
            {
                $timgstatus = '<div class="cell tstatus-live"><img src="/uploads/sys/up-1.jpg" class="img-responsive" alt="Hearthstone турнир"></div>';
            }else{
                $timgstatus = $config['tourStatus'][$tStatus];
            }
            // вынести 100%
                                                     
            if($tplloop === true){
                    $tpl->copy_template = str_ireplace("{TOURNAME}", $v['tourname'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURPRIZE}", $v['tourprize'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURGAME}", $config['tourGameicon'][$v['tourgame']], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURDATE}", date('d M', strtotime($v['tourdate'])), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURLINK}", $v['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURSTATUS}", $timgstatus, $tpl->copy_template);   
                unset($tplloop);
            } else {
                    $tpl->copy_template .= $singleTour;
                    $tpl->copy_template = str_ireplace("{TOURNAME}", $v['tourname'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURPRIZE}", $v['tourprize'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURGAME}", $config['tourGameicon'][$v['tourgame']], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURDATE}", date('d M', strtotime($v['tourdate'])), $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURLINK}", $v['id'], $tpl->copy_template);
                    $tpl->copy_template = str_ireplace("{TOURSTATUS}", $timgstatus, $tpl->copy_template);     
            }
        }

        $tpl->compile('toptourspecial');
        $tpl->clear(); 
    }




    /***********************
                          URI BRACKET
                                ***********************/

    $escaped_link = htmlspecialchars("$_SERVER[REQUEST_URI]", ENT_QUOTES, 'UTF-8');
    if(explode("/",$escaped_link)[1] == 'bracket')
    { 
        $tpl->load_template('bracket.tpl');
        $tpl->compile('index');
        $tpl->result['index'] = str_ireplace('{THEME}', 'http://' . $_SERVER['HTTP_HOST'] . '/templates/' . 'Default', $tpl->result['index']);
        echo $tpl->result['index'];
        $tpl->clear();
        exit();
    }



    /***********************
                            404
                                ***********************/

    if($page404)
    { 
        exit();
    }



    $tpl->load_template('index.tpl');
    $tpl->set('{TITLE}', $router->mainTitle);
    $tpl->set('{HEAD}', $tpl->result['head']);
    $tpl->set('{CONTENT}', $tpl->result['main-part']);
    $tpl->set('{login}', $tpl->result['login_sec']);
    $tpl->set('{TOPTOURSPECIAL}', $tpl->result['toptourspecial']);
    $tpl->set('{TOPTOUR}', $tpl->result['toptour']);
    $tpl->compile('index');
    $tpl->result['index'] = str_ireplace('{THEME}', 'http://' . $_SERVER['HTTP_HOST'] . '/templates/' . 'Default', $tpl->result['index']);
    echo $tpl->result['index'];
    $tpl->clear();
    






?>