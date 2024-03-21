<?php
use PhpFiles\registerValidation as Validation;
class registerValidationTest extends \PHPUnit\Framework\TestCase {

    public function test_if_valid_validate_username(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateUsername();

        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['username'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_name(){
        $example_post_data = array("username"=>"John6Doe",
                                   "password"=>"Password");
        $test_Validation2 = new Validation($example_post_data);
        $test_Validation2->validateUserName();
        $this->assertNotEmpty($test_Validation2->errors(), $test_Validation2->errors()['username'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_name(){
        $example_post_data = array("username"=>"J",
                                   "password"=>"Password");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateUsername();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['username'] ?? "General Error Message");
    }

    public function test_if_missing_validate_name(){
        $example_post_data = array("username"=>"",
                                   "password"=>"Password");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateUsername();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['username'] ?? "General Error Message");
    }

    public function test_if_valid_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateUsername();

        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['username'] ?? "General Error Message");
    }
}

?>