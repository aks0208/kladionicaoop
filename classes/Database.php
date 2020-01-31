<?php

class Database {
    
    private static $instance = null;
    private $conn;
    private $dbhost ="localhost";
    private $dbuser ="root";
    private $dbpass ="";
    private $dbname ="betlive";
    public $errors=[];
    
    private function __construct() {
        try{
        $this->conn = new PDO("mysql:host={$this->dbhost};dbname={$this->dbname}", $this->dbuser, $this->dbpass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            array_push($errors, $e->getMessage());
        }
      //  $this->conn = new PDO("mysql:host=127.0.0.1;dbname = betlive", "root", "" );
    }
    
    public static function getInstance(){
        if (!self::$instance) {
          self::$instance = new Database(); 
        }
         return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}