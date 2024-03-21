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
            foreach(self::$fields as $field)
            {
                if(!array_key_exists($field, $this->login))
                {
                    trigger_error("$field is not present in data");
                    return;
                }
            }
            $this->validateUsername();
            $this->validatePassword();
            return $this->errors();

        }

        public function validateUsername() {
            if(isset($_POST['username'])) {
                function validate  ($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }    
            } 

            if(empty($username)) {
                header("Location: login.php?error= Username is required");
                $this->appendErrors('username', "Username is required");
                exit();
        }
    }

    public function validatepassword() {
        if(isset($_POST['password'])) {
            function validate  ($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }    
            } 

            if(empty($password)) {
                header("Location: login.php?error= Password is required");
                $this->appendErrors('password', "Password is required");
                exit();
            } 
        }

        

    public function appendErrors($field, $message) {
        $this->errors[$field] = $message;
    }

}
