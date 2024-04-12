<?php
namespace PhpFiles;
class userRegister {
    public $servername = "localhost";
    public $username = "JohnDoe123";
    public $password = "Password1!";
    public $confirmPassword = "Password1!";
    protected $pdo;
    protected function setUp(): void
    {
        require __DIR__ . '/../dist/connection.php';
        $this->pdo = $pdo;
    }

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

    public function register($username, $passwordhash) {
        $this->setUp();
        $pdo = $this->pdo;

        
        $query = $pdo->prepare("INSERT INTO users (username, passwordhash) VALUES (?, ?)");
        $result = $query->execute([$username, $passwordhash]);
        if($result) {
            // Set the current user variable
            $query = $pdo ->prepare("SELECT userid FROM users WHERE users.username = ? LIMIT 1");
            $query ->execute([$username]);
            $user = $query->fetch();
            $_SESSION["CurrentUser"] = $user['userid'];
            header("Location: ../dist/profile/profile.php");
        } 
        $errors[] = "Invalid username or password";
    }
} 

?>