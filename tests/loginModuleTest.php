<?php
require( __DIR__ . '/../PhpFiles/loginModule.php');
use PhpFiles\userLogin as userLogin;

class loginModuleTest extends \PHPUnit\Framework\TestCase {



    public function testLoginModule() {
        $user = new userLogin("JohnDoe123");
        $this->assertEquals('JohnDoe123', $user->getUsername());
        $this->assertEquals('Password1!', $user->getPassword());
    }

    protected $loginInstance;

    protected function setUp(): void
    {
        $this->loginInstance = new userLogin(); // Replace YourClass with the actual class name
    }

    public function testValidLogin()
    {
        // Perform a valid login attempt
        $username = "valid_username";
        $password = "valid_password";

        // Assuming your setUp() method already initializes the database connection
        $this->loginInstance->login($username, $password);

        // Assert that the session variable was set and redirection header was sent
        $this->assertArrayHasKey("CurrentUser", $_SESSION);

        $result = [
            'userid' => 123 // Sample userid
        ];
    
        // Mocking the session
        $_SESSION = [];
    
        // Mocking the PDO object
        $pdoMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();
    
        $queryMock = $this->getMockBuilder(PDOStatement::class)
            ->getMock();
    
        // Mocking the execute method to return true and fetch method to return $result
        $queryMock->method('execute')->willReturn(true);
        $queryMock->method('fetch')->willReturn($result);
    
        // Mocking the prepare method to return $queryMock
        $pdoMock->method('prepare')->willReturn($queryMock);
    
        // Setting up the class instance with the mocked PDO object
        $loginInstance = new userLogin($pdoMock);
    
        // Call the login method with correct credentials
        $loginInstance->login("valid_username", "valid_password");
    
        // Asserting that session is set correctly
        $this->assertEquals(123, $_SESSION["CurrentUser"]);
    }

}