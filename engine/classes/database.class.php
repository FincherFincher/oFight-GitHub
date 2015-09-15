<?php

    class DB {
        
        
        function __construct() {
           
            $this->dbhost = $GLOBALS['dbhost'];
            $this->dbname = 'p286168_try';
            $this->dbuser = 'p286168_try';
            $this->dbpass = 'e7zRmxFmq6';

            $this->charset = 'utf8';

            $this->dsn = "mysql:host=$this->dbhost;dbname=$this->dbname;charset=$this->charset";

            $this->opt = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ); 
            
            
        }
        
        function connect() {
            
            return new PDO($this->dsn, $this->dbuser, $this->dbpass, $this->opt);;
            
        }
        
    }
?>