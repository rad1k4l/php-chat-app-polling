<?php

namespace core\http;

use core\exceptions\ViewNotFoundException;

class Response
{
    private $response = '';

    public function json($data){

        $this->addHeader('Content-Type','application/json; charset=UTF-8');
        $this->response = json_encode($data);
        return $this;
    }

    public function redirect($url){

        return $this->addHeader('Location' , $url);
    }

    public function cookie($key , $value , $expire = 60){
        $expire *= 60;
        setcookie($key , $value , time() +$expire , '/'   );
    }

    public function addHeader($header , $value = false)
    {
        if ($value !== false)
            $header = $header . ": " . $value;

        header($header);
        return $this;
    }
    public function code(int  $code)
    {
        http_response_code($code);
        return $this;
    }
    
    public function view($view , $data = []){
        $dir =  __DIR__."/../../view/" . $view . '.php' ;
        if( file_exists($dir))
        {
            ob_start();
            extract($data);
            include_once $dir;
            $viewData = ob_get_clean();
            $this->response = $viewData;
        }else{
            echo "Dir : ".  $dir . "<br>";
            throw new ViewNotFoundException;
        }
    }

    public function send(){
        print $this->response;
    }
}