<?php
use PhpFiles\registerValidation as Validation;
class registerValidationTest extends \PHPUnit\Framework\TestCase {

    public function test_if_invalid_is_valid(){
        //Missing fields case
        $example_post_data = array("username"=>"Joe",
                                   "password"=>"Password1!",
                                   "confirmPass" => "Password1!");
        $test_Validation = new Validation($example_post_data);
        $errors = $test_Validation->is_valid();
        $message ="";
        foreach($errors as $key=>$value)
        {
            $message .= $value . "\n";
        }
        $this->assertEmpty($errors, $message);

        $example_post_data = array("username"=>"",
                                   "password"=>"",
                                   "confirmPass" => "");
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
        $example_post_data = array("username"=>"John)Doe",
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

    public function test_if_invalid_length_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Pass1!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validatePassword();

        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }

    public function test_if_missing_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validatePassword();

        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }

    public function test_if_missing_uppercase_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"password1!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validatePassword();

        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }

    public function test_if_missing_digit_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validatePassword();

        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }

    public function test_if_missing_special_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password1");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validatePassword();

        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }

    public function test_if_invalid_character_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password1{");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validatePassword();

        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }

    public function test_if_confirm_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password1!",
                                   "confirmPass" => "Password1!");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateConf_Pass($example_post_data['password'], $example_post_data['confirmPass']);

        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }

    public function test_if_not_confirm_validate_password(){
        $example_post_data = array("username"=>"John Doe",
                                   "password"=>"Password1!",
                                   "confirmPass" => "Password1");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateConf_Pass($example_post_data['password'], $example_post_data['confirmPass']);

        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['password'] ?? "General Error Message");
    }
}

?>