<?php
namespace PhpFiles;
class userRegister {
    public $servername = "localhost";
    public $username = "JohnDoe123";
    public $password = "Password1!";
    public $confirmPassword = "Password1!";

    public function getUsername(){
        return $this->username;
    }
    
    public function setUsername($username){
        $this->username = $username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }
}
?>