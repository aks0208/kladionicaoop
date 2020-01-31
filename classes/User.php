<?php

class User extends ActiveRecord {
    public static $table = "users";
    public static $key = "user_id";

    public function setSessions() {
    	Session::set("user_status", $this->status);
    	Session::set("user_session", $this->user_id);
    }
  	public static function login($email, $password) {
  		$user = self::getAll(" WHERE email = '$email' AND password = '$password' LIMIT 1");
      if (count($user) == 1) {
  			$user[0]->setSessions();
  			return $user[0];
      } else {
  			return null;
        }
  	}

    public function register($username, $email, $password) {
      $checkUsername = self::getAll(" where username = '$username'");
      $checkEmail = self::getAll(" where email = '$email'");
      try {
        if (count($checkUsername) > 0) {
          echo "<div style='color:red'>This username is already taken</div>";
        } else if(count($checkEmail) > 0) {
          echo "This email is already in use";
          } else { 
            $this->setSessions();
            $this->insert();
           }
       } catch (PDOException $e) { 
     }
    }


     public function is_approved($user_id) {
      $user = self::getById($user_id);
      if ($user->is_approved == 1) {
        return true;
      } else {
        return null;
      }
     
     }

  	public static function logout() {
  		Session::stop();
  	}

  	public static function is_admin() {
  		$status = Session::get("user_status");
  		if ($status == 1 || $status == 2) return true;
  		else return null;
  	}

  	public static function is_logged_in() {
      $session = Session::get("user_session");
      if ($session) return $session;
      else return null;
    }

    public static function redirect ($url) {
    header("location: " . $url);
    } 

    public static function getBalance($user_id) {
      return $user = self::getById($user_id);
       
    }

    

    
    


  	

}


