<?php
namespace PhpFiles;

class profileValidation
{
    private $profile;
    private $errors = array();
    private $fields = ['name','address1','address2','city','state','zip','email'];

    public function __construct($newprofile)
    {
        $this->profile = $newprofile;
        
    }
    public function errors()
    {
        if(empty($this->errors))
        {
            return "";
        }
        else
        {
            return $this->errors;
        }
    }
    public function is_valid()
    {
        $this->validateName();
        $this->validateAddress1();
        $this->validateAddress2();
        $this->validateCity();
        $this->validateState();
        $this->validateZip();
        $this->validateEmail();
        return $this->errors();

    }
    public function validateName()
    {
        $regex = "/^[a-zA-Z\s]+$/";
        $value = trim($this->profile['name'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('name', "Name cannot be empty");
        }
        else if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('name', "Name can only contain alphabetical characters");
        }
        else if(strlen($value) < 5 || strlen($value) > 100)
        {
            $this->appendErrors('name', "Name must be between 5 and 100 characters");
        }
    }
    public function validateAddress1()
    {
        $regex = "/^[a-zA-Z0-9\s]+$/";
        $value = trim($this->profile['address1'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('address1', "Address cannot be empty");
        }
        else if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('address1', "Invalid address format, please use alphanumeric characters");
        }
        else if(strlen($value) < 5 || strlen($value) > 100)
        {
            $this->appendErrors('address1', "Address must be between 5 and 100 characters");
        }
    }
    public function validateAddress2()
    {
        $regex = "/^[a-zA-Z0-9\s]+$/";
        $value = trim($this->profile['address2'] ?? "");
        if(empty($value))
        {
            return;
        }
        else
        if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('address2', "Invalid address format, please use alphanumeric characters");
        }
        else if(strlen($value) > 100 || strlen($value) < 5)
        {
            $this->appendErrors('address2', "Address must be between 5 and 100 characters");
        }
    }
    public function validateCity()
    {
        $regex = "/^[a-zA-Z\s]+$/";
        $value = trim($this->profile['city'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('city', "City cannot be empty");
        }
        else if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('city', "City can only contain alphabetical characters");
        }
        else if(strlen($value) < 5 || strlen($value) > 100)
        {
            $this->appendErrors('city', "City must be between 5 and 100 characters");
        }
    }
    public function validateState()
    {
        $regex = "/^[a-zA-Z]+$/";
        $value = trim($this->profile['state'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('state', "State cannot be empty");
        }
        else if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('state', "Invalid state format");
        }
        else if(strlen($value) != 2)
        {
            $this->appendErrors('state', "State must be 2 characters");
        }
    }
    public function validateZip()
    {
        $regex = "/^[0-9]+$/";
        $value = trim($this->profile['zip'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('zip', "Zip code cannot be empty");
        }
        else if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('zip', "Invalid zip code format, please use numeric characters");
        }
        else if(strlen($value) > 9 || strlen($value) < 5)
        {
            $this->appendErrors('zip', "Zip code must be between 5 and 9 digits");
        }
    }
    public function validateEmail()
    {
        $regex = "/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/";
        $value = trim($this->profile['email'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('email', "Email cannot be empty");
        }
        else if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('email', "Invalid email format");
        }
    }
    private function appendErrors($key, $message)
    {
        $this->errors[$key] = $message;
    }
}