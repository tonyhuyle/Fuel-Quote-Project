<?php 
use PhpFiles\profileValidation as Validation; 

class profileValidationTest extends \PHPUnit\Framework\TestCase
{
    public function test_if_valid_is_valid(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@gmail.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->is_valid();
        $this->assertEmpty($test_Validation->errors() ?? "General Error Message");
    }

    public function test_if_invalid_is_valid(){
        //Missing fields case
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->is_valid();
        $this->assertNotEmpty($test_Validation->errors() ?? "General Error Message");

        // name invalid case
        $example_post_data = array("name"=>"John6Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@gmail.com");
        $test_Validation2 = new Validation($example_post_data);
        $test_Validation2->is_valid();
        $this->assertNotEmpty($test_Validation2->errors() ?? "General Error Message");
    }

    public function test_if_valid_validate_name(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateName();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['name'] ?? "General Error Message");
    }
    
    public function test_if_invalid_validate_name(){
        $example_post_data = array("name"=>"John6Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");

        $test_Validation2 = new Validation($example_post_data);
        $test_Validation2->validateName();
        $this->assertNotEmpty($test_Validation2->errors(), $test_Validation2->errors()['name'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_name(){
        $example_post_data = array("name"=>"J",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateName();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['name'] ?? "General Error Message");
    }

    public function test_if_missing_validate_name(){
        $example_post_data = array("name"=>"",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateName();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['name'] ?? "General Error Message");
    }

    public function test_if_valid_validate_address1(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress1();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['address1'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_address1(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street*&%^*",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress1();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['address1'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_address1(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress1();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['address1'] ?? "General Error Message");
    }
    
    public function test_if_missing_validate_address1(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress1();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['address1'] ?? "General Error Message");
    }

    public function test_if_valid_validate_address2(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress2();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['address2'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_address2(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456!",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress2();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['address2'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_address2(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"U",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress2();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['address2'] ?? "General Error Message");
    }

    public function test_if_missing_validate_address2(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateAddress2();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['address2'] ?? "General Error Message");
    }

    public function test_if_valid_validate_city(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateCity();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['city'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_city(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City21!",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateCity();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['city'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_city(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"N",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateCity();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['city'] ?? "General Error Message");
    }

    public function test_if_missing_validate_city(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateCity();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['city'] ?? "General Error Message");
    }

    public function test_if_valid_validate_state(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateState();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['state'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_state(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"34",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateState();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['state'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_state(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NewYork",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateState();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['state'] ?? "General Error Message");
    }

    public function test_if_missing_validate_state(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateState();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['state'] ?? "General Error Message");
    }

    public function test_if_valid_validate_zip(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateZip();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['zip'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_zip(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"1001ABC",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateZip();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['zip'] ?? "General Error Message");
    }

    public function test_if_invalid_length_validate_zip(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"1001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateZip();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['zip'] ?? "General Error Message");
    }

    public function test_if_missing_validate_zip(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateZip();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['zip'] ?? "General Error Message");
    }

    public function test_if_valid_validate_email(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"10001",
                                   "email"=>"johndoe@example.com");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateEmail();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['email'] ?? "General Error Message");
    }

    public function test_if_invalid_validate_email(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"1001",
                                   "email"=>"johndoe@example");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateEmail();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['email'] ?? "General Error Message");
    }

    public function test_if_missing_validate_email(){
        $example_post_data = array("name"=>"John Doe",
                                   "address1"=>"123 main street",
                                   "address2"=>"Unit 456",
                                   "city"=>"New York City",
                                   "state"=>"NY",
                                   "zip"=>"1001",
                                   "email"=>"");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateEmail();
        $this->assertNotEmpty($test_Validation->errors(), $test_Validation->errors()['email'] ?? "General Error Message");
    }

}