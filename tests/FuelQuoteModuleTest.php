<?php
use PhpFiles\FuelQuoteModule as Module;
class FuelQuoteModuleTest extends \PHPUnit\Framework\TestCase
{
    protected $pdo2;
    protected function setUp(): void
    {
        $appName = $_SERVER['HTTP_HOST'] ?? 'defaulthost';
        $appName .= $_SERVER['REQUEST_URI'] ?? 'defaulturi';
        $dsn = 'pgsql:host=localhost;dbname=postgres;options=\'--application_name=' . $appName . '\'';
        $user = 'postgres';
        $password = 'root';
        // Create a PDO instance
        $pdo2 = new PDO($dsn, $user, $password);
        $this->pdo2 = $pdo2;
    }
    public function testModule()
    {
        $example_post_data = array("userid"=>"d278547f-ddbb-4c2e-b76e-5c06a975296e",
                                  "gallons"=>"500",
                                  "address"=> "155 Vango Dr",
                                  "address2"=> "",
                                  "date"=> "2024-07-20",
                                  "state"=> "TX",
                                  "zip"=>"55123",
                                  "city"=>"Austin");
        $test_Module = new Module($example_post_data, true);
        $this->assertEquals("500", $test_Module->getGallons());
        $this->assertEquals("155 Vango Dr", $test_Module->getAddress());
        $this->assertEquals("", $test_Module->getAddress2());
        $this->assertEquals("2024-07-20", $test_Module->getDate());
        $suggestPrice = 1.50 + (1.50 * (0.02 - 0.01 + 0.03 + 0.1));
        $this->assertEquals($suggestPrice, $test_Module->getSuggestedPrice()); //3.02 is default price
        $this->assertEquals($test_Module->getSuggestedPrice() * $test_Module->getGallons(), $test_Module->getTotalPrice());
        
        
    }
    public function testSQLInsertion()
    {
        $this->setUp();
        $pdo2 = $this->pdo2;
        $errors = array();
        $example_post_data = array("userid"=>"d278547f-ddbb-4c2e-b76e-5c06a975296e",
                                  "gallons"=>"500",
                                  "address"=> "155 Vango Dr",
                                  "address2"=> "",
                                  "date"=> "2024-07-20",
                                  "state"=> "TX",
                                  "zip"=>"55123",
                                  "city"=>"Austin");
        $test_Module = new Module($example_post_data, true);
        //Count number of rows before and store into $count1
        $sql = "SELECT COUNT(*) as count FROM fuelquotehistory WHERE userid=?";
        $stmt1 = $pdo2->prepare($sql);
        $stmt1->execute([$example_post_data["userid"]]);
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        $count1 = $result["count"];
        //Run the insert command.
        $test_Module->InsertFuelQuote($example_post_data["userid"]);
        //Recount number of rows after the insert, should be 1 more than before.
        $stmt1->execute([$example_post_data["userid"]]);
        $result2 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $count2 = $result2["count"];
        //assert that the after count is 1 more than before count.
        $this->assertEquals($count1 + 1, $count2, "ERROR: Insert Failed.");
        $stmt2 = $pdo2->prepare("DELETE FROM fuelquotehistory WHERE userid = ?");
        $stmt2->execute([$example_post_data["userid"]]);
        //Deletes this test users' fuel quotes.  
    }
}