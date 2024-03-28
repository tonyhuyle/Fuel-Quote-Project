<?php
require( __DIR__ . '/../PhpFiles/registerModule.php');
use PhpFiles\userRegister as userRegister;

class userRegisterTest extends \PHPUnit\Framework\TestCase {

    public function testLoginModule() {
        $user = new userRegister("JohnDoe123");
        $this->assertEquals('JohnDoe123', $user->getUsername());
        $this->assertEquals('Password1!', $user->getPassword());
        $this->assertEquals('JohnDoe123', $user->setUsername('JohnDoe123'));
        $this->assertEquals('Password1!', $user->setPassword('Password1!'));
    }
}