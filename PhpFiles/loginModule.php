<?php
namespace PhpFiles;
class userLogin {
    public $servername = "localhost";
    public $username = "JohnDoe123";
    public $password = "Password1!";

    public function getUsername(){
        return $this->username;
    }
    
    public function getPassword(){
        return $this->password;
    }
}

?>