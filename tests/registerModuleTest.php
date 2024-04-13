<?php
require( __DIR__ . '/../PhpFiles/registerModule.php');
use PhpFiles\userRegister as userRegister;

class registerModuleTest extends \PHPUnit\Framework\TestCase {

    public function testLoginModule() {
        $user = new userRegister("JohnDoe123, Password1!");
        $this->assertEquals('JohnDoe123', $user->getUsername());
        $this->assertEquals('Password1!', $user->getPassword());
        $user->setUsername('JohnDoe123');
        $this->assertEquals('JohnDoe123', $user->getUsername());
        $user->setPassword('Password1!');
        $this->assertEquals('Password1!', $user->getPassword());
    }
}