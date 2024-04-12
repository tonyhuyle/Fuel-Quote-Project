<?php
namespace PhpFiles;
class userLogin {
    public $servername = "localhost";
    public $username = "JohnDoe123";
    public $password = "Password1!";
    protected $pdo;
    protected function setUp(): void
    {
        require __DIR__ . '/../dist/connection.php';
        $this->pdo = $pdo;
    }

    public function login($username, $password) {
        $this->setUp();
            $pdo = $this->pdo;

        $query = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $query->execute([$username]);
        $result = $query->fetch();

        // Check if user exists and verify password
        if ($result) {
            if (password_verify($password, $result['passwordhash'])) {
                // Set the current user variable
                $query = $pdo ->prepare("SELECT userid FROM users WHERE users.username = ? LIMIT 1");
                $query ->execute([$username]);
                $user = $query->fetch();
            
                $_SESSION["CurrentUser"] = $user['userid'];
                header("Location: ../dist/profile/profile.php");
                exit; // Make sure to exit after redirection
            }
            // If credentials are not valid, set error message
        }
        $errors[] = "Invalid username or password";
    }

    public function getUsername(){
        return $this->username;
    }
    
    public function getPassword(){
        return $this->password;
    }
}

?>