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
    public function testSQLInsertion()
    {
        $this->setUp();
        $pdo2 = $this->pdo2;
        $errors = array();
        $pdo2->beginTransaction();
        $example_post_data = array("userid"=>"fa8eff83-187f-48ee-be64-505f394cfe86",
                                  "gallons"=>"5",
                                  "address"=> "155 Vango Dr",
                                  "date"=> "2024-07-20");
        $test_Module = new Module($example_post_data);
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
        $pdo2->commit();
        //Deletes this test users' fuel quotes.  
    }
}