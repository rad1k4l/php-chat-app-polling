<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19.04.2019
 * Time: 18:09
 */

namespace controller;


use core\http\Response;
use model\Chat;
use model\User;

class api
{
    public $userid;
    public $user ;
    public $chat;


    public function __construct()
    {
        if (isset($_COOKIE['userid']))
            $this->userid = $_COOKIE['userid'];
        else
            return \response()->redirect('/site/login');
        $this->chat = new Chat();
        $this->user = new User();

    }
    public function inbox(){

        $to = request()->str()->post('to');

        if ($to !== false) {
            $inbox = $this->chat->inbox($this->userid, $to);

            return response()->json($inbox);
        }

        return response()->json(['status'=>'error' , 'post' => $_POST , 'get' => "123123"]);
    }

    public function getUser(){
        $userid =  $this->userid;
        $user = $this->user->getUser($userid);

        if(!empty($this->user->getUser($userid))){
            return response()->json($user[0]);
        }
        return response()->json(['status'=> "error"]);
    }

    public function search(){
        $res = [
            'status' => 'error'
        ];

        $query  = request()->str()->get("query");
        if($query !== false) {
            $users = $this->user->search($query);
            $res = [];
        }
            foreach ($users as $user) {
            $res[] = [
                'userid' => $user['id'],
                'username' => $user['name'],
                'online' => time() - (int)trim($user['time']) <= 3 ? true : false
            ];
        }
        return response()->json($res);
    }

    public function index(){
        $this->chat->send(18 , 17 , 'testd message ');
//        print_r($this->user->search('u'));
    }

    public function send(){
        $to = request()->str()->post('to');
        $text = request()->str()->post('text');

        if($to && $text){
            $from = $this->userid;
            $this->chat->send($from , $to , $text);
            $response = ['status'=> "ok"];
        }else  $response = ['status' => 'error'];

        return response()->json($response);
    }

    public function chats(){
        $user = new User();
        $userid = request()->str()->get('userid') ;
        if ($userid && !empty($user->getUser($userid)) ){
            $this->user->update($userid);
            $chats = $this->chat->get($userid);
            $res = $this->buildChat($chats , $userid);
            return response()->json($res);
        }
        return response()->json(['status'=>'error']);
    }

    protected function buildChat($chats , $userid){

        $result = [];
        function added($userid , $chats){
            if (empty($chats)) return false;
            foreach ($chats as $chat ){
                if ($chat['userid'] == $userid){
                    return true;
                }
            }
            return false;
        }

        foreach ($chats  as $chat){
            if ($chat['from'] == $userid){
                $id = $chat['to'];
            }else{
                $id = $chat['from'];
            }
            if(!added($id , $result)) {
                $user = $this->user->getUser($id);
                if(!empty($user))
                    $result[] = [
                        'userid' =>$id,
                        'username' => $user[0]['name'] ,
                        'latest' => $chat['text'],
                        'online' => time() - (int)trim($user[0]['time']) <=3 ? true : false
                    ];
            }

        }
        return $result;
    }


}