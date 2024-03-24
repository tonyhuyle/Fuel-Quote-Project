<?php
require( __DIR__ . '/../PhpFiles/loginModule.php');
use PhpFiles\userLogin as userLogin;

class loginModuleTest extends \PHPUnit\Framework\TestCase {

    public function testLoginModule() {
        $user = new userLogin("JohnDoe123");
        $this->assertEquals('JohnDoe123', $user->getUsername());
        $this->assertEquals('Password1!', $user->getPassword());
    }
}