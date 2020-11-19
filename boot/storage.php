<?php
$router = new core\http\Router();
$request = new core\http\Request();
$response = new core\http\Response();

function router(){
    global $router;
              
    return $router;
}

function request(){
    global $request;

    return $request;
}

function response(){
    global $response;

    return $response;
}

