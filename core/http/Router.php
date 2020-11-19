<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19.04.2019
 * Time: 16:22
 */

namespace core\http;

class Router
{
    public $routes;
    public $defaultController = 'site';
    public $defaultAction = "index";

    public function handle(){

        $path = $this->getPath();
        if ($path[0] === '/') $path[0] = ' ';

        $path = explode('/' ,trim($path) );
        $controller = empty(trim($path[0])) ? '/' : $path[0];

        if($controller === '/' ){
            $controller = $this->defaultController;
            $action = $this->defaultAction;
        }else{

            if(isset($path[1]) ){
                $action = $path[1];
            }else{

                return false;
            }
        }

        $controllerPath = __DIR__ . '/../../controller/' .$controller . ".php";
        if(file_exists(strtolower($controllerPath))){
            $namespace = 'controller\\' . $controller;
            $controller = new $namespace();
            if (method_exists($controller , $action))
                $controller->$action();
            else
                return false;
            return true;
        }else{
            return false;
        }

    }

    public function getPath(){
        return request()->path();
    }

    public function run(){
        if(!$this->handle()){
            http_response_code(404);
            response()->view('site/404' );
        }
    }

}