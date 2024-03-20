<?php
require( __DIR__ . '/../PhpFiles/profileManagement.php');
use PhpFiles\userProfile as userProfile;

class ProfileManagementTest extends \PHPUnit\Framework\TestCase
{
    public function testProfileManagement()
    {
        $user = new userProfile("JohnDoe123");
        $this->assertEquals("JohnDoe123", $user->getUsername());
        $this->assertEquals("John Doe", $user->getName());
        $this->assertEquals("123 main street", $user->getAddress1());
        $this->assertEquals("Unit 456", $user->getAddress2());
        $this->assertEquals("New York City", $user->getCity());
        $this->assertEquals("NY", $user->getState());
        $this->assertEquals("10001", $user->getZip());
        $this->assertEquals("johndoe@example.com", $user->getEmail());
        $user->updateProfile("Jane Doe", "janedoe@example.com", "456 main street", "Unit 789", "Los Angeles", "CA", "90001");
        $this->assertEquals("Jane Doe", $user->getName());
        $this->assertEquals("456 main street", $user->getAddress1());
        $this->assertEquals("Unit 789", $user->getAddress2());
        $this->assertEquals("Los Angeles", $user->getCity());
        $this->assertEquals("CA", $user->getState());
        $this->assertEquals("90001", $user->getZip());
        $this->assertEquals("janedoe@example.com", $user->getEmail());
    }
}