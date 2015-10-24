<?

    if(!defined('OFIGHTENGINE')){
        die("Hacking attempt!");
    }

    class Users {
        
        function __construct()
        {
            session_start();
            $this->isAuth();
            $this->db = new DB();
            $this->db = $this->db->connect();
        }
        
        
        
    /***********************
                           LOGIN
                                ***********************/
        
        function login($uname, $upass)
        {
            $this->pass = md5($upass);
            
            $sql = $this->db->prepare(" SELECT * FROM oFight_users WHERE username = ? AND password = ? ");
            $sql->execute(array($uname, $this->pass));
            
            if($sql->rowCount() == 0)
            {
                return false;
            }
            
            $sql = $sql->fetch();
            $_SESSION['username'] = $sql['username'];
            $_SESSION['uinfo'] = $sql;
            
            return true;
        }
        
        
        
        function register($uname, $upass, $uemail, $usubsc) {
            $this->pass = md5($upass);
            
            $ucheck = $this->db->prepare("SELECT * FROM oFight_users WHERE username = ?");
            $ucheck->execute(array($uname));
            $ucheck->fetch();
            
            if($ucheck->rowCount() > 0){
                return false;
            }
            
            
            $reg = $this->db->prepare("INSERT INTO oFight_users (username, password, email, regdate, avatar) VALUES (?, ?, ?, NOW(), 'defaultavatar.jpg'); INSERT INTO oFight_users_HS (username) VALUES (?);");
            if(!$reg->execute(array($uname, $this->pass, $uemail, $uname))){
                return false;
            }
            if($usubsc){
                include_once(ROOT_DIR . '/engine/api/mail/ML_Subscribers.php');
                $ML_Subscribers = new ML_Subscribers('184e63b2dc0b341b1f10341b1fba4daf');
                $subsc = array(
                    'email' => $uemail,
                    'name' => $uname
                );
                $add = $ML_Subscribers->setId(1881853)->add($subsc);
            }
            $_SESSION['username'] = $uname;
            
            return true;
        }
        
        function passReset($email) {
            
            $ucheck = $this->db->prepare("SELECT * FROM oFight_users WHERE email = ?");
            $ucheck->execute(array($email));
            
            if($ucheck->rowCount() == 0){
                return false;
            }
            
            $uinfo = $ucheck->fetch();
            $password = $this->passGener();
            
            $title = 'Восстановление пароля | oFight.ru';
            $headers = "From: noreply@ofight.ru\r\n";
            $message = "Your new password: $password\nYour login: ".$uinfo['username']."";
            
            if(mail($email, $title, $message, $headers)) {
                $passupdate = $this->db->prepare("UPDATE oFight_users SET password = ? WHERE email = ?");
                if(!$passupdate->execute(array(md5($password), $email))){
                    return false;
                }
            } else {
                return false;
            }
            
            return true;
            
        }
        
        function unsubscribe($user) {
            
        }
        
        function isAuth() {
            if(!isset($_SESSION['username'])){
                setcookie('username', '', 1, '/chat');
                setcookie('img', '', 1, '/chat');
                return false;
            }
            return true;
        }
        
        function logout(){
            unset($_SESSION['username']);
            setcookie('username', 0, time()-3600, '/chat');
            setcookie('img', 0, time()-3600, '/chat');
        }
        
        function info() {
            
            $info = $this->db->prepare("SELECT * FROM oFight_users WHERE username = :name; SELECT * FROM oFight_users_HS WHERE username = :name");
            $info->execute(array('name' => $_SESSION['username']));
            
            return $info->fetch();
            
        }
        
        function ainfo($user) {
            
            $info = $this->db->prepare("SELECT * FROM oFight_users WHERE username = :name; SELECT * FROM oFight_users_HS WHERE username = :name");
            $info->execute(array('name' => $user));
            
            return $info->fetch();
            
        }
        
        // Начисление очков пользователю
        
        function addPTS($user) {
            
            
            
        }
        
        function racePick($user, $race) {
            
        }
        
        function raceBan($user, $race) {
            
        }
        
        
        
    /***********************
                           Set Avatar
                                ***********************/
        
        function setAvatar($uName, $fname)
        {
            $query = $this->db->prepare(" UPDATE oFight_users SET avatar = ? WHERE username = ? ");
            $query->execute(array($fname, $uName));
        }
        
        
    /***********************
                           Get Ranking
                                ***********************/
        
        function getRanking()
        {
            $sql = " SELECT oFight_users.username, oFight_users.avatar, oFight_users_HS.wincount, oFight_users_HS.defeatcount
                     FROM oFight_users INNER JOIN oFight_users_HS ON oFight_users.username = oFight_users_HS.username
                     ORDER BY oFight_users_HS.wincount DESC, oFight_users_HS.defeatcount ASC
                     LIMIT 50 ";
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        function getRankingByUser($uName)
        {
            $sql = " SELECT oFight_users.username, oFight_users.avatar, oFight_users_HS.wincount, oFight_users_HS.defeatcount
                     FROM oFight_users INNER JOIN oFight_users_HS ON oFight_users.username = oFight_users_HS.username
                     WHERE oFight_users.username = ?
                     ORDER BY oFight_users_HS.wincount DESC, oFight_users_HS.defeatcount ASC ";
            $query = $this->db->prepare($sql);
            $query->execute(array($uName));
            if($query->rowCount() > 0)
            {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
                $sql = "SELECT oFight_users.username
                        FROM oFight_users INNER JOIN oFight_users_HS ON oFight_users.username = oFight_users_HS.username
                        ORDER BY oFight_users_HS.wincount DESC, oFight_users_HS.defeatcount ASC ";
                $rank = $this->db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
                $rank = array_search($uName, $rank) + 1;
                array_push($data, $rank);
                return $data;
            } else {
                return 0;
            }
        }

        
        function getTourWinner($tData)
        {
            return $this->db->query(" SELECT username FROM oF_tour_winners WHERE tourname = '".$tData['tourname']."' ")->fetch();
        }
        
    /***********************
                           VACANCY
                                ***********************/
        
        function sendVacancy($realName, $email, $topic, $textInfo)
        {
            $title = 'Заявка в проект | oFight';
            $headers = "From: noreply@ofight.ru\r\n";
            $message = "Имя: ".$realName."\nemail для ответа: ".$email."\nТема: ".$topic."\nИнформация: ".$textInfo." ";
            $emailto = 'admin@ofight.ru';
            mail($emailto, $title, $message, $headers);
        }
        
        
    /***********************
                           Winner's
                                ***********************/
        
        function getTourWinners()
        {
            $sql = " SELECT oF_tour_winners.tourname, oF_tour_winners.username, oF_tour_cPanel_Past.tourlogo, oF_tour_cPanel_Past.tourgame 
                     FROM oF_tour_winners INNER JOIN oF_tour_cPanel_Past ON oF_tour_winners.tourname = oF_tour_cPanel_Past.tourname
                     ORDER BY oF_tour_winners.id DESC LIMIT 10 ";
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);   
        }
        
        
        
    /***********************
                           sendTourCreateFrom
                                ***********************/
        
        function sendTourCreateFrom($realName, $email, $textInfo)
        {  
            $title = 'Заявка в проект | oFight';
            $headers = "From: noreply@ofight.ru\r\n";
            $message = "Имя: ".$realName."\nemail для ответа: ".$email."\nИнформация: ".$textInfo." ";
            $emailto = 'admin@ofight.ru';
            mail($emailto, $title, $message, $headers);

        }
        
   
        
        
        
        
        
        
        
        
    /***********************
                  Добавить параметр
                                ***********************/
        
        function userAttr($uName, $attrName, $attrValue) {
            
            $query = $this->db->prepare("UPDATE oFight_users SET ".$attrName." = ? WHERE username = ?");
            if(!$query->execute(array($attrValue, $uName))){
                return false;
            }
            return true;

        }
        
        
    /***********************
            Создать localStorage турнира
                                ***********************/
        
        function runTour($uName){
            
            $query = $this->db->prepare("SELECT tourid FROM oF_tour_users WHERE username = ?");
            $query->execute(array($uName));
            $data = $query->fetchAll();
            return $data;
        }
        
    
    /***********************
    Деление показателей статистики
                                ***********************/
        function divisionInt($a, $b){
            if($b === 0){
                $c = 0;
            }else{
                $c = $a/$b; 
            }
            return $c; 
            
        }
        
        
    /***********************
    турниры администрируемые юзером
                                ***********************/
        function getAdminTour($uName){
        
            $query = $this->db->prepare(" SELECT tourid FROM oF_tour_admin WHERE username = ? ");
            $query->execute(array($uName));
            return $query->fetchAll();
      
        }
        
        
    /***********************
        Получить данные пользователя
                                ***********************/
        
        function userinfo($uName) {

            $query = $this->db->prepare(" SELECT * FROM oFight_users, oFight_users_HS WHERE oFight_users.username = ? AND oFight_users.username=oFight_users_HS.username; ");
            $query->execute(array($uName));
            return $query->fetch();
            
        }

        
        
        function passGener(){
            
            $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
            $max = 10;
            $size = StrLen($chars)-1;
            $password = null;

            while($max--) {
                $password.=$chars[rand(0,$size)];
            }
            
            return $password;
        }
        
        function getStreamers(){
            $str = $this->db->query("SELECT streamers FROM oFight_streamers_HS");
            $str = $str->fetchAll();
            $arr = array();
            foreach($str as $key => $val){
                foreach($val as $k => $v){
                    array_push($arr, $v);
                }
            }
            $rez = implode(",", $arr);
            return $rez;
        }
        
    }
?>