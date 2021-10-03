# Scandiweb Test Assignment

This is a minimal backend project build in PHP and MySQL with an OOP approach without using any frameworks. See more details in the requirement folder.

## How does it work?

It's basically starts with a request which is received by a Router. This router will dispatch the request to the corresponding conroller as defined in src/config/bootstap.php. In This case there is one Controller that handle the requests to the endpoint: http://domain/products

To add a new route, just include the following in the src/config/bootstrap.php file:

    $router->addRoute($endPoint, $controllerName);

The ENDPOINT is in the format:

    /endpoint

For instance, in order to accept requests at /products and dispatch them to the product controller, then you have to write:

    $router->addRoute('products', 'ProductController');


Where the second parameter must be a valid class name.

## The ProductController
It is responsible for properly handling the GET, POST, DELETE and OPTIONS requests. It also extends the BaseController class.

## The models
They are responsible for handling the data, storing and deleting. There are 6 models.

- BaseModel.php
- ProductModel.php
- Product.php
- Book.php
- Furniture.php
- Dvd.php

## Installation
- Copy repository files in the public of your server.
- Execute the sql file database/jdtstore.sql

Make sure to copy the .htaccess because this files contains a rule that redirects al requets to the same endpoint.

## CORS
This projects sends headers to avoid CORS issues. However, it only allows the UI origin.

## Responses
The server responses in JSON, and follows the format:

    {"status":"","api_version":"","message":"","affected_rows":0,"content":null}

* status: Either ERROR or OK depending on the result of the request.
* api_version: API current version (Ex. v1.0)
* message: It contains easy to understand details about the last request.
* affected_rows: It represents how many rows were affected after executing the last request.
* content: It is either NULL or an array. The array version can be the newly inserted or deleted item. It can also the array of errors found.

A response would be like:
    
    {"status":"OK","api_version":"1.0","message":"No products were found.","affected_rows":0,"content":null}


## User Interfacte
Since it is the backend, there is no UI code. You can check a react project built for this purpose [See React Frontend project](https://github.com/ibisdavi012/jdtstore-ui)

## Live version (Backend)
[Backend @ 000webhost](https://jdtstore.000webhostapp.com/)

[Frontend @ Netlify](https://frosty-darwin-651925.netlify.app/)

## Additional notes
000webhost does not allow free accounts to make DELETE requests. Therefore, an alternative DELETE method was implemented using GET method.

    GET: http://server/products/delete/{:id}

