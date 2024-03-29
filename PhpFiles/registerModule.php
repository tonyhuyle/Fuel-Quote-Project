<?php
namespace PhpFiles;
class userRegister {
    public $servername = "localhost";
    public $username;
    public $password;
    public $confirmPassword;
    
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