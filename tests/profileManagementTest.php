<?php
require( __DIR__ . '/../PhpFiles/profileManagement.php');
require( __DIR__ . '/../dist/connection.php');
use PhpFiles\userProfile as userProfile;

class ProfileManagementTest extends \PHPUnit\Framework\TestCase
{
    public function testProfileManagement()
    {
        global $pdo;
        //sample data to be used for testing, some is obviosly invalid
        $sampleData = array(
            'username' => 'testUsername',
            'password' => 'testPassword',
            'email' => 'testEmail', //invalid email to ensure it is not used, but it is unique
            'name' => 'testName',
            'address1' => 'testAddress1',
            'address2' => 'testAddress2', 
            'city' => 'testCity',
            'state' => 'ST',
            'zip' => '123456789',
        );
        //create a new test user
        $stmt1 = $pdo->prepare("INSERT INTO users (username, passwordhash, email) VALUES (:username, :password, :email)");
        $stmt1->execute(array(
            ':username' => $sampleData['username'],
            ':password' => $sampleData['password'],
            ':email' => $sampleData['email']
        ));
        //usernames and emails are unique in the db, so we can use it to get the user
        $stmt2 = $pdo->prepare("SELECT * FROM users WHERE username = ? AND email = ? LIMIT 1");
        $stmt2->execute([$sampleData['username'], $sampleData['email']]);
        $user = $stmt2->fetch();
        
        //create a new profile for the user
        $testUser = new userProfile($user['userid']);
        $testUserID = $user['userid'];

        //Update the profile with the sample data
        $testUser->updateProfile($testUserID, $sampleData['name'], $sampleData['email'], $sampleData['address1'], $sampleData['address2'], $sampleData['city'], $sampleData['state'], $sampleData['zip']);

        $this->assertEquals($sampleData['username'], $testUser->getUsername());
        $this->assertEquals($sampleData['name'], $testUser->getName());
        $this->assertEquals($sampleData['address1'], $testUser->getAddress1());
        $this->assertEquals($sampleData['address2'], $testUser->getAddress2());
        $this->assertEquals($sampleData['city'], $testUser->getCity());
        $this->assertEquals($sampleData['state'], $testUser->getState());
        $this->assertEquals($sampleData['zip'], $testUser->getZip());
        $this->assertEquals($sampleData['email'], $testUser->getEmail());

        //delete the test user and profile from the db
        $stmt3 = $pdo->prepare("DELETE FROM users WHERE userid = ? LIMIT 1");
        $stmt3->execute([$testUserID]);
        $stmt4 = $pdo->prepare("DELETE FROM profiles WHERE userid = ? LIMIT 1");
        $stmt4->execute([$testUserID]);
    }
}