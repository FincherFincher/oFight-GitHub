<?php
    
    class Template {
    
        function __construct($tpl_name) {
        
            
            $this->url = $_SERVER['DOCUMENT_ROOT'] . '/templates/' . $tpl_name;
            
        }
        
        
        function setVar($var, $value){
        
            $this->$var = $value;
            
        }
        
        function setBlock($block) {
            
            $this->$block = file_get_contents($this->url.'/'.$block.'.tpl');
            
        }
        
        
        function loadTemplate() {
            
            include_once($this->url.'/varlist.inf');
            foreach($blocklist as $name => $block) {
                
                $tmp = file_get_contents($this->url.'/'.$block.'.tpl');
                
            }
            
            foreach($varlist as $var => $val) {
                
                $tmp = str_replace('{'.$var.'}', $this->$val, $tmp);
                
            }
            
            return $tmp;
            
        }
        
        function compileTemplate($tmp) {
            
            
            
        }
        
    }



?>
