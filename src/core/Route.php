<?php

namespace App\Core;

class Route {

    private $target;
    
    private $controller;

    public function __construct($target){
        $this->target = $target;
    }

    public function is_forbidden() {
        return strtolower($this->target) == 'base';
    }

    private function get_singular_noun($removed_letters) 
    {
        return "App\\Controllers\\" . 
                ucfirst(substr($this->target,0,strlen($this->target)-$removed_letters)) . 
                "Controller";
    }

    public function is_valid() {

        $singular_name1 = $this->get_singular_noun(1);

        $singular_name2 = $this->get_singular_noun(2); 

        if(class_exists($singular_name1,true)){

            $this->controller = new $singular_name1();

        } else if(class_exists($singular_name2,true)) {

            $this->controller = new $singular_name2();                    
        } 

        return $this->controller != null;
    }

    public function get_controller() {

        return $this->controller;
        
    }
}