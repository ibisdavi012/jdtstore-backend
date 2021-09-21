<?php

namespace App\Routing;

class Route {

    private $endpoint;
    
    private $controller;

    private $requestMethod;

    private $requestedId;

    public function __construct($endpoint,$requestMethod,$requestedId){
        $this->endpoint = $endpoint;
        $this->requestMethod = $requestMethod; 
        $this->requestedId = $requestedId;       
    }

    public function load() {
        
        $target = RouteList::getTarget($this->endpoint);
    
        $controllerName = "App\\Controllers\\{$target}";
    
        if($target === null || !class_exists($controllerName,true)) {
            header(HTTP404);
        }elseif($target === false) {
            header(HTTP403);
        }
        else {
            $this->controller = new $controllerName();
            $this->controller->{$this->requestMethod}($this->requestedId);
        }              
    }

    public function get_controller() {

        return $this->controller;
        
    }
}