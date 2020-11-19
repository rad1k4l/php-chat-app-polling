<?php

namespace core\db;
use PDO;
class db{
    public $conn;
    public $pod;
    public function __construct(){
        $this->connect('host' , 'database' , 'user' , 'password');
    }
    public function connect($host, $db , $user , $pass ){
        //  include_once 'reyestr/database.php';
        $dsn = 'mysql:host=' . $host . ';dbname=' . $db .';charset=utf8';
        $user = $user;
        $password = $pass;
        $this->conn = new \PDO($dsn, $user, $password , [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $this->conn;
    }
    public function execute_fetch($sql , $data){
        $this->pod = $this->conn->prepare($sql);
        $this->pod->execute($data);
        return $this->pod->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql , $data){
        $this->pod = $this->conn->prepare($sql);
        return $this->pod->execute($data);

    }

    public function query($sql){
        $pod = $this->conn->prepare($sql);

        $pod->execute();

        $result = $pod->fetchall(PDO::FETCH_ASSOC);

        if($result === false ){
            return false;
        }else{
            return $result;
        }
    }
}
?>
