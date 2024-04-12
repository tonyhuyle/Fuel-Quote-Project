<?php
use PhpFiles\FuelQuoteModule as Module;
class FuelQuoteModuleTest extends \PHPUnit\Framework\TestCase
{
    public function testModule()
    {
        $example_post_data = array("gallons"=>"5",
                                  "address"=> "155 Vango Dr",
                                  "date"=> "2024-07-20");
        $test_Module = new Module($example_post_data);
        $this->assertEquals("5", $test_Module->getGallons());
        $this->assertEquals("155 Vango Dr", $test_Module->getAddress());
        $this->assertEquals("2024-07-20", $test_Module->getDate());
        $this->assertEquals(3.02, $test_Module->getSuggestedPrice()); //3.02 is default price
        $this->assertEquals($test_Module->getSuggestedPrice() * $test_Module->getGallons(), $test_Module->getTotalPrice());
        
        
    }
}