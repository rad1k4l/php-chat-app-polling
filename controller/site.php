<?php

namespace controller;
use model\User;

class site
{


    public function index(){

        if (!isset($_COOKIE['userid']))
            return \response()->redirect('/site/login');

        return response()->view('chat');
    }
    public function login(){

        $login = request()->str()->get('login');

        if ($login){
            $user = new User();
            $res = $user->get($login);
            if (empty($res)){
                $user->create($login);
                $us = $user->get($login);
                response()->cookie('userid' , $us[0]['id'] , 24*60);
                response()->redirect('/');
            }else{
                response()->cookie('userid' , $res[0]['id'] , 24*60);
                response()->redirect('/');
            }
        }
        return response()->view('login');
    }
}