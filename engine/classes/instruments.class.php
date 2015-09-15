<?php

    class Instruments {
        
        function __construct() {
            
            $this->db = new DB();
            $this->db = $this->db->connect();
            
        }
        
    /***********************
              Создать Local Storage
                                ***********************/
        
        function pushLocalStorage($name, $data){
            
            echo "<script>localStorage.removeItem('".$name."');</script>";
            echo "<script>localStorage.setItem('".$name."', '".$data."');</script>"; 
            
        }
        
        function clearLocalStorage($name){
            
            echo "<script>localStorage.removeItem('".$name."');</script>";
            
        }
        
        
    }


?>