<?php
namespace PhpFiles;

class profileValidation
{
    private $profile;
    private $errors = array();
    private $fields = ['username','name','address1','address2','city','state','zip','email'];

    public function __construct($newprofile)
    {
        $this->profile = $newprofile;
        
    }
    public function errors()
    {
        return $this->errors;
    }
    public function is_valid()
    {
        foreach(self::$fields as $field)
        {
            if(!array_key_exists($field, $this->profile))
            {
                trigger_error("$field is not present in data");
                return;
            }
        }
        $this->validateUsername();
        $this->validateName();
        $this->validateAddress1();
        $this->validateAddress2();
        $this->validateCity();
        $this->validateState();
        $this->validateZip();
        $this->validateEmail();
        return $this->errors();

    }
    public function validateUsername()
    {
        $regex = "/^[a-zA-Z0-9]+$/";
        $value = trim($this->profile['username'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('username', "There needs to be a username submitted");
        }
        else if(!(preg_match($regex, $value)) || strlen($value) < 5 || strlen($value) > 100)
        {
            $this->appendErrors('username', "There needs to be a username submitted in the form of alphanumeric characters");
        }
    }
    public function validateName()
    {
        $regex = "/^[a-zA-Z]+$/";
        $value = trim($this->profile['name'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('name', "There needs to be a name submitted");
        }
        else if(!(preg_match($regex, $value)) || strlen($value) < 5 || strlen($value) > 50)
        {
            $this->appendErrors('name', "There needs to be a name submitted in the form of alphabetical characters");
        }
    }
    public function validateAddress1()
    {
        $regex = "/^[a-zA-Z0-9]+$/";
        $value = trim($this->profile['address1'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('address1', "There needs to be an address submitted");
        }
        else if(!(preg_match($regex, $value)) || strlen($value) < 5 || strlen($value) > 100)
        {
            $this->appendErrors('address1', "There needs to be an address submitted in the form of alphanumeric characters");
        }
    }
    public function validateAddress2()
    {
        $regex = "/^[a-zA-Z0-9]+$/";
        $value = trim($this->profile['address2'] ?? "");
        if(!(preg_match($regex, $value)) || strlen($value) < 5 || strlen($value) > 100)
        {
            $this->appendErrors('address2', "There needs to be an address submitted in the form of alphanumeric characters");
        }
    }
    public function validateCity()
    {
        $regex = "/^[a-zA-Z]+$/";
        $value = trim($this->profile['city'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('city', "There needs to be a city submitted");
        }
        else if(!(preg_match($regex, $value)) || strlen($value) < 5 || strlen($value) > 100)
        {
            $this->appendErrors('city', "There needs to be a city submitted in the form of alphabetical characters");
        }
    }
    public function validateState()
    {
        $regex = "/^[a-zA-Z]+$/";
        $value = trim($this->profile['state'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('state', "There needs to be a state submitted");
        }
        else if(!(preg_match($regex, $value)) || strlen($value) != 2)
        {
            $this->appendErrors('state', "There needs to be a state submitted in the form of alphabetical characters");
        }
    }
    public function validateZip()
    {
        $regex = "/^[0-9]+$/";
        $value = trim($this->profile['zip'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('zip', "There needs to be a zip code submitted");
        }
        else if(!(preg_match($regex, $value)) || strlen($value) > 9 || strlen($value) < 5)
        {
            $this->appendErrors('zip', "There needs to be a zip code submitted in the form of numerical characters");
        }
    }
    public function validateEmail()
    {
        $regex = "/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/";
        $value = trim($this->profile['email'] ?? "");
        if(empty($value))
        {
            $this->appendErrors('email', "There needs to be an email submitted");
        }
        else if(!(preg_match($regex, $value)))
        {
            $this->appendErrors('email', "There needs to be an email submitted in the form of alphanumeric characters");
        }
    }
    private function appendErrors($key, $message)
    {
        $this->errors[$key] = $message;
    }
}