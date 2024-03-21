<?php
namespace PhpFiles;
class userRegister {
    public $servername = "localhost";
    public $user = "JohnDoe123";
    public $pass = "Password";
    public $confirmPass = "Password";
    
    public function getUsername(){
        return $this->user;
    }
    
    public function setUsername($username){
        $this->user = $username;
    }

    public function getPassword(){
        return $this->pass;
    }

    public function setPassword($password){
        $this->pass = $password;
    }
}

?>