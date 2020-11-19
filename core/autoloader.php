<?php
spl_autoload_register(function($class){

    $class = explode('\\' , $class);
        $path = implode(DIRECTORY_SEPARATOR , $class);
        require_once  __DIR__ ."/../". $path . ".php";
    return 1;
});