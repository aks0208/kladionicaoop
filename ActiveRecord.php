<?php

abstract class ActiveRecord {
    public static function getAll($filter="") {
        $instance = Database::getInstance();
        $conn = $instance->getConnection();
        //$res = array();
        $pdo = $conn->prepare("SELECT * FROM ".static::$table." ".$filter);
        $pdo->execute();

        
        $res = $pdo->fetchAll(PDO::FETCH_CLASS, get_called_class());
      //var_dump($res);
        return $res;
        
       
    }
    public static function getById($id) {
        $instance = Database::getInstance();
        $conn = $instance->getConnection();
        
        $pdo = $conn->prepare("SELECT * FROM ".static::$table . " WHERE ".static::$key." = " .$id . " LIMIT 1");
        $pdo->execute();

        return $pdo->fetchObject(get_called_class());
        
    }

    public function save() {
        $q = " UPDATE " . static::$table . " SET "; 
        //proci kroz listu kolona koje klasa sadrzi
        foreach ($this as $key => $value) {
            if ($key == static::$key) continue;
            $q.=$key."='".$value."',";   
        }
        $q = rtrim($q,", ");
        $keyField = static::$key;
        $q.=" WHERE ". $keyField ." = " . $this->$keyField; 

        $instance = Database::getInstance();
        $conn = $instance->getConnection();

        $pdo = $conn->prepare($q);
        $pdo->execute();
        //var_dump($pdo);
    }

    public function insert() {
        $fields = get_object_vars($this); //asoc niz sa vrijednostima kolona bez id-a
        $keys = array_keys($fields);
        $values = array_values($fields);
     

        $q = "INSERT INTO " . static::$table . "(";
        $q.= implode(",", $keys);
        $q.=") VALUES (";
        
        $q.= implode(",", $values);  
        $q.=")";

        $instance = Database::getInstance();
        $conn = $instance->getConnection();

        $pdo = $conn->prepare($q);
       
        $pdo->execute();
      //  $keyField = static::$key;
       // $this->$keyField = $conn->lastInsertId();
       //var_dump($q);
       

    }

    public static function delete($id) {
        $q = "DELETE FROM " . static::$table . " WHERE " . static::$key . " = " . $id;

        $instance = Database::getInstance();
        $conn = $instance->getConnection();

        $pdo = $conn->prepare($q);
        $pdo->execute();

    }

    

    
}


