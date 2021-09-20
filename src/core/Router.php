<?php

namespace App\Core;

use App\Controllers\BaseController;

/**
* Router - It is responsible for dispatching the request to the right Controller
* 
* @author      David Márquez <ibisdavi012@gmail.com>
* @license     MIT
* 
*/
class Router {
    
    private $requestURI;
    private $uriSegments;    
    private $requestedRoute;
    private $requestMethod;

    public function __construct() {    
        
        $this->requestURI = strtolower($_SERVER['REQUEST_URI']);        
        $this->uriSegments = explode('/',$this->requestURI);
        $this->requestedRoute = $this->uriSegments[1];                
        $this->requestMethod = $_SERVER['REQUEST_METHOD']; 
        
        $this->dispatch();
    }

    public function dispatch() {
        
        $route = new Route($this->requestedRoute);

        if($route->is_forbidden()){
            header(HTTP403);  
            exit();          
        }else if($route->is_valid()) {
            $route->get_controller()->{$this->requestMethod}();
        }else{
            header(HTTP404);            
            exit();
        }
    }
    
}