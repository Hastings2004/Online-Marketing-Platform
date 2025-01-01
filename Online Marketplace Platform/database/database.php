<?php

class Database{
    private $server = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'online_marketing';

    protected function connect(){
        try {
            $pdo = new PDO("mysql:host=$this->server;dbname=$this->dbname", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Error connecting '. $e->getMessage();
        }
    }
}