<?php 
namespace PhpFiles;
class registerValidation
{
    private $register;
    private $errors = array();
    private $fields = ['username','password'];

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
            foreach(self::$fields as $field)
            {
                if(!array_key_exists($field, $this->register))
                {
                    trigger_error("$field is not present in data");
                    return;
                }
            }
            $this->validateUsername($this->register['username']); // Pass username to validation method
            $this->validatePassword($this->register['password']); // Pass password to validation method
            $this->validateConf_Pass($this->register['password'], $this->register['confirmPassword']); // Pass both passwords to validation method
            return empty($this->errors); // Return true if there are no errors
        }
        
        public function validateUsername($username) // Add $username parameter
        {
            // Username validation rules
            if(!preg_match('/^[a-zA-Z0-9]{4,}$/', $username)) // Use $username parameter
            {
                $this->appendErrors('username', "Username must be at least 4 characters long and contain only alphanumeric characters");
            }
        }
    
        public function validatePassword($password) // Add $password parameter
        {
            // Password validation rules
            if(strlen($password) < 8) // Use $password parameter
            {
                $this->appendErrors('password', "Password must be at least 8 characters long");
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