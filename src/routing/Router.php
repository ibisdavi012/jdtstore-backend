<?php

namespace App\Routing;

use App\Controllers\BaseController;

/**
 * Router - It handles incomming requests and dispatch them them to the right controller.
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
class Router
{

    private $requestURI;

    private $uriSegments;

    private $requestedEndPoint;

    private $requestedId;

    private $requestMethod;

    private $routes;

    public function __construct()
    {

        $this->routes = array();

        $this->parseUri();
    }

    /**
     * Parses the incomming Request URI
     *
     * @return void
     */
    private function parseUri()
    {

        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        $this->requestURI = strtolower($_SERVER['REQUEST_URI']);

        // Remove trailing '/' of the URI
        $this->requestURI = preg_replace("/\/$/", "", $this->requestURI);

        $this->uriSegments = explode('/', $this->requestURI);

        $this->requestedEndPoint = $this->uriSegments[1];

        // Extract Uri Segments
        if (count($this->uriSegments) > 2) {
            if (is_numeric($this->uriSegments[2])) {
                // Extract the ID from the third segment of the Uri
                $this->requestedId = $this->uriSegments[2];
            } else {
                // Send 404 Error if the URI segments are wrogly formatted
                header(HTTP404);
                exit;
            }
        }
    }

    /**
     * Register valid routes that will be handled from the $endpoint param to the
     * $targetController.
     *
     * @param  string $endpoint
     * @param  string $targetController
     * @return void
     */
    public function addRoute($endpoint, $targetController)
    {
        $this->routes[$endpoint] = $targetController;
    }


    /**
     * Validates if the proovided controller name correspond to a valid class.
     *
     * @return void
     */
    public function validateTargetController()
    {

        $route_names = array_keys($this->routes);


        if (in_array($this->requestedEndPoint, $route_names)) {
            $target = $this->routes[$this->requestedEndPoint];

            $fullTargetName = "App\\Controllers\\{$target}";

            if (!class_exists($fullTargetName, true)) {
                return null;
            }

            return $fullTargetName;
        } else {
            return null;
        }
    }

    /**
     * Dispatch the current request to the appropiate Controller
     *
     * @return void
     */
    public function dispatch()
    {

        $controller = $this->validateTargetController();

        if ($controller === false) {
            header(HTTP403);
        } elseif ($controller === null) {
            header(HTTP404);
        } else {
            $this->controller = new $controller();
            $this->controller->{$this->requestMethod}($this->requestedId);
        }
    }
}
