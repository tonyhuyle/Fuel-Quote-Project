<?php 
namespace PhpFiles;
class loginValidation
{
    private $login;
    private $errors = array();
    private $fields = ['username','password'];

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

        // Retrieve the password from $this->login and compare it with the stored hash
      /*  $enteredPassword = $this->login['password'] ?? "";
        $storedHashedPassword = ""; // Fetch the hashed password from your database based on the provided username/email

        if (!$storedHashedPassword) {
            $this->appendErrors('password', "Invalid username or password."); // Inform the user that either the username or password is invalid
            return;
        } */
    }
    public function appendErrors($field, $message) {
        $this->errors[$field] = $message;
    }

}
