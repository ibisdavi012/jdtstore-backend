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
        
        $controller = RouteList::getTargetControllerName($this->endpoint);
    
        if ($controller === false) {
            header(HTTP403);
        }elseif($controller === null) {
            header(HTTP404);
        }
        else {
            $this->controller = new $controller();
            $this->controller->{$this->requestMethod}($this->requestedId);
        }              
    }

    public function get_controller() {

        return $this->controller;
        
    }
}