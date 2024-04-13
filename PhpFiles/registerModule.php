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

    public function register($username, $password) {
        $this->setUp();
            $pdo = $this->pdo;
            
        $passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

        // Prepare SQL statement to insert user data
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
        else {
            $errors[] = "Registration failed. Please try again.";
        }
}
}

?>