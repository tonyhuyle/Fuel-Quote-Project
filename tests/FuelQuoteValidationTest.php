<?php
#include __DIR__ . '/../PhpFiles/FuelQuoteModule.php';
#include __DIR__ . '/../PhpFiles/FuelQuoteValidation.php';
use PhpFiles\FuelQuoteModule;
use PhpFiles\FuelQuoteValidation as Validation;
class FuelQuoteValidationTest extends \PHPUnit\Framework\TestCase
{
    public function test_if_valid_is_valid(){
        $example_post_data = array("gallons"=>"6",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>"2024-06-20");
        $test_Validation = new Validation($example_post_data);
        $errors = $test_Validation->is_valid();
        $message ="";
        foreach($errors as $key=>$value)
        {
            $message .= $value . "\n";
        }
        $this->assertEmpty($errors, $message);
    }
    public function test_if_invalid_is_valid(){
        //Missing fields case
        $example_post_data = array("gallons"=>"6");
        $test_Validation = new Validation($example_post_data);
        $errors = $test_Validation->is_valid();
        $message ="";
        foreach($errors as $key=>$value)
        {
            $message .= $value . "\n";
        }
        $this->assertNotEmpty($errors, $message);

        // gallons invalid case

        $example_post_data = array("gallons"=>"WRONG",
                                    "address"=>"124 Sunny Hills Lane",
                                    "date"=>"2024-03-20");
        $test_Validation = new Validation($example_post_data);
        $errors = $test_Validation->is_valid();
        $message ="";
        foreach($errors as $key=>$value)
        {
            $message .= $value . "\n";
        }
        $this->assertNotEmpty($errors, $message);

        // date invalid case

        $example_post_data = array("gallons"=>"5",
                                    "address"=>"124 Sunny Hills Lane",
                                    "date"=>"NA");
        $test_Validation = new Validation($example_post_data);
        $errors = $test_Validation->is_valid();
        $message ="";
        foreach($errors as $key=>$value)
        {
            $message .= $value . "\n";
        }
        $this->assertNotEmpty($errors, $message);


    }
    public function test_if_valid_validate_gallons(){
        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>"2024-06-20");
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateGallons();

        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['gallons'] ?? "General Error Message");
    }
    public function test_if_invalid_validate_gallons(){
        //Given that we have an invalid value for gallons, 
        $example_post_data = array("gallons"=>"Obviously Invalid",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>"2024-06-20");
        $test_Validation2 = new Validation($example_post_data);
        //When we validate the gallons field, 
        $test_Validation2->validateGallons();
        //We expect that the errors array contained in the $test_Validation object to be NOT EMPTY as our validation method would've logged an error message!
        $this->assertNotEmpty($test_Validation2->errors(), $test_Validation2->errors()['gallons'] ?? "General Error Message");
    }
    public function test_if_missing_validate_gallons(){
        //Given that we have an missing value for gallons, 
        $example_post_data = array("gallons"=>"",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>"2024-06-20");
        $test_Validation2 = new Validation($example_post_data);
        //When we validate the gallons field, 
        $test_Validation2->validateGallons();
        //We expect that the errors array contained in the $test_Validation object to be NOT EMPTY as our validation method would've logged an error message!
        $this->assertNotEmpty($test_Validation2->errors(), $test_Validation2->errors()['gallons'] ?? "General Error Message");
    }
    public function test_if_missing_validate_date()
    {
        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>"");
        $test_Validation3 = new Validation($example_post_data);
        $test_Validation3->validateDate();
        $this->assertNotEmpty($test_Validation3->errors(), $test_Validation3->errors()['date'] ?? "General Date Error Message");
    }
    public function test_if_valid_validate_date2()
    {
        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>date("Y-m-d"));
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateDate();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['date'] ?? "General Date Error Message");
    }
    public function test_if_valid_validate_date()
    {
        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>date("Y-m-d", strtotime("+1 day")));
        $test_Validation = new Validation($example_post_data);
        $test_Validation->validateDate();
        $this->assertEmpty($test_Validation->errors(), $test_Validation->errors()['date'] ?? "General Date Error Message");
    }
    
    public function test_if_invalid_validate_date()
    {
        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>"1000-03-01");
        $test_Validation3 = new Validation($example_post_data);
        $test_Validation3->validateDate();
        $this->assertNotEmpty($test_Validation3->errors(), $test_Validation3->errors()['date'] ?? "General Date Error Message");
    }
    public function test_if_invalid_validate_date3()
    {
        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"124 Sunny Hills Lane",
                                   "date"=>"2055-03-01");
        $test_Validation3 = new Validation($example_post_data);
        $test_Validation3->validateDate();
        $this->assertNotEmpty($test_Validation3->errors(), $test_Validation3->errors()['date'] ?? "General Date Error Message");

    }
    public function test_if_missing_or_wrong_length_validate_address()
    {
        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"",
                                   "date"=>"2055-03-01");
        $test_Validation3 = new Validation($example_post_data);
        $test_Validation3->validateAddress();
        $this->assertNotEmpty($test_Validation3->errors(), $test_Validation3->errors()['address'] ?? "General Date Error Message");

        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"axe",
                                   "date"=>"2055-03-01");
        $test_Validation3 = new Validation($example_post_data);
        $test_Validation3->validateAddress();
        $this->assertNotEmpty($test_Validation3->errors(), $test_Validation3->errors()['address'] ?? "General Date Error Message");

        $example_post_data = array("gallons"=>"5.5",
                                   "address"=>"%$^#",
                                   "date"=>"2055-03-01");
        $test_Validation3 = new Validation($example_post_data);
        $test_Validation3->validateAddress();
        $this->assertNotEmpty($test_Validation3->errors(), $test_Validation3->errors()['address'] ?? "General Date Error Message");
    }
    
}