<?php

// Database Settings
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'jdtstore');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', '');

// HTTP headers
define('HTTP200', '"HTTP/1.1 200 OK"');
define('HTTP400', 'HTTP/1.1 400 Bad Request');
define('HTTP403', 'HTTP/1.1 403 Forbidden');
define('HTTP404', 'HTTP/1.1 404 Not Found');
define('HTTP_CORS', 'Access-Control-Allow-Origin: *');
define('HTTP_ACAH', 'Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
define('HTTP_ACAM', 'Access-Control-Allow-Methods: GET, POST, HEAD, OPTIONS, PUT, DELETE');
define("HTTP_ACEH", "Access-Control-Expose-Headers: Content-Length, X-JSON");
define('HTTP_METHODS', 'Allow: GET, POST, OPTIONS, PUT, DELETE');
define('HTTP_JSON', 'Content-Type: application/json; charset=utf-8');
