<?php
require( __DIR__ . '/../PhpFiles/registerModule.php');
use PhpFiles\userRegister as userRegister;

class registerModuleTest extends \PHPUnit\Framework\TestCase {
    protected $pdo;

    protected function setUp(): void
    {
        require __DIR__ . '/../dist/connection.php';
        $this->pdo = $pdo;
    }


    public function testLoginModule() {
        $user = new userRegister("JohnDoe123, Password1!");
        $this->assertEquals('JohnDoe123', $user->getUsername());
        $this->assertEquals('Password1!', $user->getPassword());
        $user->setUsername('JohnDoe123');
        $this->assertEquals('JohnDoe123', $user->getUsername());
        $user->setPassword('Password1!');
        $this->assertEquals('Password1!', $user->getPassword());
    }


    public function testRegistrationSuccess()
    {
        $registration = new userRegister($this->pdo);
        
        // Simulate registration with valid username and password
        $username = 'testuser';
        $password = 'testpassword';
        $result = $registration->register($username, $password);

        // Check if registration was successful
        $this->assertTrue($result);
        
        // You can add additional assertions to ensure that the session variable is set correctly, etc.
    }

    public function testRegistrationFailure()
    {
        $registration = new userRegister($this->pdo);
        
        // Simulate registration with invalid data
        $username = ''; // Invalid username
        $password = 'testpassword';
        $result = $registration->register($username, $password);

        // Check if registration failed
        $this->assertFalse($result);
        
        // You can add additional assertions to ensure that appropriate error handling is in place.
    }


}