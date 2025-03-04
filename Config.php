<?php
class Config {
    private $host = 'localhost';
    private $dbname = 'testcafeteria';
    private $username = 'root';
    private $password = '123456Mh*';
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(  "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",$this->username,$this->password );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}