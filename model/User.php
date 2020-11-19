<?php
namespace model;

use core\db\db;

class User extends db
{
    public function getUser($id){
        $sql = "SELECT * FROM users WHERE id = ?  ";
        return $this->execute_fetch($sql  , [ $id ]);
    }
    public function create($username){
        $sql = "INSERT INTO `users` (`name` ) VALUES ( ? ) ";
        return $this->execute($sql , [$username]);
    }
    public function search($query){

        $sql = "SELECT * FROM users WHERE `name` LIKE ?  ";

        return $this->execute_fetch($sql , ["%$query%"]);
    }
    public function update($userid){
        $sql = "UPDATE users SET  time = ? WHERE id = ?";
        return $this->execute($sql, [time() , $userid]);
    }

    public function get($username){
        $sql = "SELECT * FROM users WHERE name = ?  ";
        return $this->execute_fetch($sql  , [ $username ]);
    }
}