<?php namespace App\Routing;

class RouteList {
    
    private static $validRoutes = array(
        'products' => 'ProductController'
    );

    private static $protectedRoutes = array(
        'base'
    );

    public static function getTargetControllerName($endpoint) {

        $routes_keys = array_keys(self::$validRoutes);        

        if (in_array($endpoint, $routes_keys)) {
            $target = self::$validRoutes[$endpoint];
            $fullTargetName = "App\\Controllers\\{$target}";            
            if(!class_exists($fullTargetName,true)){return null;}
            
            return $fullTargetName;
        }
        elseif (in_array($endpoint, self::$protectedRoutes)) {
            return false;
        }
        else{            
            return null;
        }
    }
}

