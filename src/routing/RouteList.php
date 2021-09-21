<?php namespace App\Routing;

class RouteList {
    
    private static $validRoutes = array(
        'products' => 'ProductController'
    );

    private static $protectedRoutes = array(
        'base'
    );

    public static function getTarget($endpoint) {

        $routes_keys = array_keys(self::$validRoutes);

        if (in_array($endpoint, $routes_keys)) {
            return self::$validRoutes[$endpoint];
        }
        elseif (in_array($endpoint, self::$protectedRoutes)) {
            return false;
        }
        else{
            return null;
        }
    }
}

