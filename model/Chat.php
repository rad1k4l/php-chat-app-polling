<?php
namespace model;

use core\db\db;

class Chat  extends db
{
    public function send($from , $to , $message){
        $message = trim($message);

        $sql = "INSERT INTO chats ( `from` , `to` , `text` ) VALUES (? ,? ,?)";
        return $this->execute($sql , [$from , $to  , $message]);
    }

    public function get($userid){
        $sql = "SELECT * FROM chats WHERE `from` = ? OR `to` = ? ORDER  BY id DESC ";

        return $this->execute_fetch($sql , [$userid , $userid ]);
    }

    public function inbox($from , $to){
        $sql = "SELECT * FROM chats WHERE (`from` = ? AND `to` = ?) OR  (`from` = ? AND `to` = ?) ORDER  BY id ASC";
        return $this->execute_fetch($sql , [$from , $to , $to , $from]);
    }

}