<?php

    class Router {
        private $_route = array();
        
        public $mainPage;
        
        public $mainTitle;
        
        public function __construct($tpl, $user, $tour, $news, $db, $config) {
            
            $this->url_path = explode('/', trim($_SERVER["PATH_INFO"], ' /'));
            if (!isset($_SERVER["PATH_INFO"])) {
                $this->mainPage = true;
            } else if (file_exists('engine/inc/' . $this->url_path[0] . '.php')) {
                include_once 'engine/inc/' . $this->url_path[0] . '.php';
            } else {
                global $page404;
                $page404 = true;
                include_once '404.html';
            }
                
            return true;
        }
        
    }
?>