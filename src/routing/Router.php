<?php

namespace App\Routing;

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
    private $requestedEndPoint;
    private $requestedId;
    private $requestMethod;

    public function __construct() {    
        
        $this->requestURI = strtolower($_SERVER['REQUEST_URI']);        
        $this->uriSegments = explode('/',$this->requestURI);
        $this->requestedEndPoint = $this->uriSegments[1];   
        
        if (count($this->uriSegments) > 2 && is_numeric($this->uriSegments[2]))
        {
            $this->requestedId = $this->uriSegments[2];                       
        }

        $this->requestMethod = $_SERVER['REQUEST_METHOD']; 
    }

    public function dispatch() {
        
        $route = new Route($this->requestedEndPoint,$this->requestMethod,$this->requestedId);

        $route->load();
    }
    
}