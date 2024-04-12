<?php
namespace PhpFiles;
class userLogin {
    public $servername = "localhost";
    public $username;
    public $password;
/*
    public function __construct($CurrentUser) {
        // Get the user's profile information from the database and store it in the object
        global $pdo;
        $stmt = $pdo->prepare(" SELECT user.username, users.password
                                FROM users
                                JOIN profiles ON users.userid = profiles.userid
                                WHERE users.userid = ?
                                LIMIT 1
                                ");
        $stmt->execute([$CurrentUser]);
        $user = $stmt->fetch();
        
        $this->username = $user['username'];
        $this->password = $user['Password1!'];

    } */

    public function getUsername(){
        return $this->username;
    }
    
    public function getPassword(){
        return $this->password;
    }
}

?>