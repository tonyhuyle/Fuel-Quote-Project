<?php
namespace PhpFiles;
class userProfile {
    public $username;
    public $name;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip;
    public $email;
    protected $pdo;
    protected function setUp(): void
    {
        require __DIR__ . '/../dist/connection.php';
        $this->pdo = $pdo;
    }
    public function __construct($CurrentUser) {
        // Get the user's profile information via their uuid from the database and store it in the object
        $this->setUp();
        $pdo = $this->pdo;
        $stmt = $pdo->prepare(" SELECT users.username, users.email, profiles.fullname, profiles.address1, profiles.address2, profiles.city, profiles.userstate, profiles.zipcode
                                FROM users
                                JOIN profiles ON users.userid = profiles.userid
                                WHERE users.userid = ?
                                LIMIT 1
                                ");
        $stmt->execute([$CurrentUser]);
        $user = $stmt->fetch();
        
        $this->name = $user['fullname'];
        $this->username = $user['username'];
        $this->address1 = $user['address1'];
        $this->address2 = $user['address2'];
        $this->city = $user['city'];
        $this->state = $user['userstate'];
        $this->zip = $user['zipcode'];
        $this->email = $user['email'];
    }

    public function getName(){
        return $this->name;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getAddress1(){
        return $this->address1;
    }
    
    public function getAddress2(){
        return $this->address2;
    }

    public function getCity(){
        return $this->city;
    }

    public function getState(){
        return $this->state;
    }

    public function getZip(){
        return $this->zip;
    }

    public function getEmail(){
        return $this->email;
    }

    public function updateProfile($currentUser, $name, $email, $address1, $address2, $city, $state, $zip){
        // Update the user's profile information in the database
        $pdo = $this->pdo;
        try{
            $pdo->beginTransaction();

            $stmt1 = $pdo->prepare('UPDATE profiles
                                    SET fullname = ?, address1 = ?, address2 = ?, city = ?, userstate = ?, zipcode = ?
                                    WHERE userid = ?
                                    ');
            $stmt1->execute([$name, $address1, $address2, $city, $state, $zip, $currentUser]);

            $stmt2 = $pdo->prepare('UPDATE users
                                    SET email = ?
                                    WHERE userid = ?
                                    ');
            $stmt2->execute([$email, $currentUser]);

            $pdo->commit();
        }
        catch(\PDOException $e){
            $pdo->rollBack();
            error_log($e->getMessage());
            throw new \Exception('An error occurred while updating your profile. Please try again.');
        }
        
        // Update the user's profile information in the object
        $this->name = $name;
        $this->email = $email;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }
}
