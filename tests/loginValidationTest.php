<?php
use PhpFiles\loginValidation as Validation;
class loginValidationTest extends \PHPUnit\Framework\TestCase {

    public function test_if_invalid_is_valid(){
        //Missing fields case
        $example_post_data = array("username"=>"Joe",
                                   "password"=>"Passwords1!",);
        $test_Validation = new Validation($example_post_data);
        $errors = $test_Validation->is_valid();
        $message ="";
        foreach($errors as $key=>$value)
        {
            $message .= $value . "\n";
        }
        $this->assertEmpty($errors, $message);

        $example_post_data = array("username"=>"",
                                   "passwords"=>"",);
        $test_Validation = new Validation($example_post_data);
        $errors = $test_Validation->is_valid();
        $message ="";
        foreach($errors as $key=>$value)
        {
            $message .= $value . "\n";
        }
        $this->assertNotEmpty($errors, $message);
    }

    public function test_if_valid_validate_username(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password1!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateUsername();

        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['username'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_name(){
        $example_post_data = array("username"=>"John*Doe",
                                   "password"=>"Password1!");
        $test_Validation2 = new Validation($example_post_data);
        $test_Validation2->validateUserName();
        $this->assertNotEmpty($test_Validation2->errors(), $test_Validation2->errors()['username'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_name(){
        $example_post_data = array("username"=>"J",
                                   "password"=>"Password1!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateUsername();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['username'] ?? "General Error Message");
    }

    public function test_if_missing_validate_name(){
        $example_post_data = array("username"=>"",
                                   "password"=>"Password1!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateUsername();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['username'] ?? "General Error Message");
    }

    public function test_if_valid_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password1!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validatePassword();

        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }
}

?>