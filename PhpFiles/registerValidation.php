<?php 
namespace PhpFiles;
class registerValidation
{
    private $register;
    private $errors = array();
    private $fields = ['username','password', 'confirmPass'];

    public function errors()
    {
        return $this->errors;
    }

    public function __construct($register)
        {
            $this->register = $register;
            
        }

        public function is_valid()
        {
            foreach($this->fields as $field)
            {
                if(!array_key_exists($field, $this->register))
                {
                    $this->appendErrors($field, "$field is not present in data");
                }
            }
            $this->validateUsername(); // Pass username to validation method
            $this->validatePassword(); // Pass password to validation method
            $this->validateConf_Pass($this->register['password'], $this->register['confirmPassword']); // Pass both passwords to validation method
            return $this->errors();
        }
        
        public function validateUsername() // Add $username parameter
        {
                $regex = "/^[a-zA-Z\s]+$/";
            $value = trim($this->register['username'] ?? "");

            if (empty($value)) {
                $this->appendErrors('username', "Username cannot be empty");
            } 
            elseif (!preg_match($regex, $value)) 
            {
                $this->appendErrors('username', "Username can only contain alphabetical characters");
            } 
            elseif (strlen($value) < 3 || strlen($value) > 20) 
            {
                $this->appendErrors('username', "Username must be between 3 and 20 characters long.");
            }
        }
    
        public function validatePassword() // Add $password parameter
        {
                $regex = "/^[a-zA-Z0-9\s!@#$%^&*_+\-=\[\];':|,.<>\/?]+$/";
            $value = trim($this->register['password'] ?? "");

            if (empty($value)) {
                $this->appendErrors('password', "Password cannot be empty");

            } 
            elseif (!preg_match($regex, $value)) 
            {
                $this->appendErrors('password', "Password contains invalid characters");
            } 
            elseif (!preg_match('/[A-Z]/', $value)) 
            {
                $this->appendErrors('password', "Password must contain at least one uppercase letter.");
            } 
            elseif (!preg_match('/\d/', $value)) 
            {
                $this->appendErrors('password', "Password must contain at least one digit.");
            } 
            elseif (strlen($value) < 8) 
            {
                $this->appendErrors('password', "Password must be at least 8 characters long.");
            } 
            elseif (!preg_match('/[^\w\s]/', $value)) 
            {
                $this->appendErrors('password', "Password must contain at least one special character.");
            }
        }
    
        public function validateConf_Pass($password, $confirmPassword) // Add parameters for both passwords
        {
            // Confirm password validation
            if($password !== $confirmPassword) // Check if passwords match
            {
                $this->appendErrors('confirmPassword', "Passwords do not match");
            }
        }
    
        private function appendErrors($key, $message)
        {
            $this->errors[$key] = $message;
        }
    }
?>