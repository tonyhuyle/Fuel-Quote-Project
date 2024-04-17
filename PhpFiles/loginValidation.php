<?php 
namespace PhpFiles;
class loginValidation
{
    private $login;
    private $errors = array();
    private $fields = ['username','password'];
    protected $pdo;
    protected function setUp(): void
    {
        require __DIR__ . '/../dist/connection.php';
        $this->pdo = $pdo;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function __construct($login)
        {
            $this->login = $login;
            
        }

        public function is_valid()
        {
            foreach($this->fields as $field)
            {
                if(!array_key_exists($field, $this->login))
                {
                    $this->appendErrors($field, "$field is not present in data");
                }
            }
            $this->validateUsername();
            $this->validatePassword();
            return $this->errors();

        }

        public function validateUsername()
    {
        $regex = "/^[a-zA-Z0-9\s_]+$/";
        $value = trim($this->login['username'] ?? "");

        if (empty($value)) {
            $this->appendErrors('username', "Username cannot be empty");
        } 

        elseif (!preg_match($regex, $value)) 
            {
                $this->appendErrors('username', "Username can only contain alpha numerical characters with _ and spaces");
            } 
        
        elseif (strlen($value) < 3 || strlen($value) > 20) 
            {
                $this->appendErrors('username', "Username must be between 3 and 20 characters long.");
            }
    }

    public function validatePassword()
    {
        $value = trim($this->login['password'] ?? "");

        if (empty($value)) {
            $this->appendErrors('password', "Password cannot be empty");
        } 
        else {
            // Retrieve user data from the database
            $this->setUp();
            $pdo = $this->pdo;
            $query = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $query->execute([$this->login['username']]);
            $result = $query->fetch();
    
            // Check if user exists and verify password
            if (!$result || !password_verify($value, $result['passwordhash'])) {
                $this->appendErrors('password', "Invalid username or password.");
            }
        }
    }
    public function appendErrors($field, $message) {
        $this->errors[$field] = $message;
    }

}
