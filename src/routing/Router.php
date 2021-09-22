<?php

namespace App\Routing;

use App\Controllers\BaseController;

class Router {
    
    private $requestURI;
    private $uriSegments;    
    private $requestedEndPoint;
    private $requestedId;
    private $requestMethod;
    private $routes;
    private $protectedRoutes; 

    public function __construct() { 

        $this->routes = array();

        $this->protectedRoutes = array();       
        
        $this->requestURI = strtolower($_SERVER['REQUEST_URI']);  
        
        // Remove trailing '/'
        if (substr($this->requestURI,-1) === '/') {            
            $this->requestURI = substr($this->requestURI,0,strlen($this->requestURI)-1);  
        }
        
        $this->uriSegments = explode('/',$this->requestURI);
        
        $this->requestedEndPoint = $this->uriSegments[1];   

        $this->requestMethod = $_SERVER['REQUEST_METHOD']; 

        if (count($this->uriSegments) > 2)
        {            
            if(is_numeric($this->uriSegments[2]))  {
                $this->requestedId = $this->uriSegments[2];
            }                    
            else{
                header(HTTP404);
                exit;
            }
        }

    }
    
    public function addRoute($endpoint,$targetController){
        $this->routes[$endpoint] = $targetController; 
    }

    public function addProtectedRoute($endpoint){
        array_push($protectedRoutes,$endpoint);
    }

    private function validateAccess($endpoint) {
        return false;
    }

    public function validateTargetController() {

        $route_names = array_keys($this->routes);        
       
        if (in_array($this->requestedEndPoint, $this->protectedRoutes)) {
            return false;
        }
        elseif (in_array($this->requestedEndPoint, $route_names)) {            
            $target = $this->routes[$this->requestedEndPoint];
            $fullTargetName = "App\\Controllers\\{$target}";            
            if(!class_exists($fullTargetName,true)){return null;}
            
            return $fullTargetName;
        }        
        else{            
            return null;
        }
    }

    public function dispatch() {
        
        $controller = $this->validateTargetController();

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
    
}