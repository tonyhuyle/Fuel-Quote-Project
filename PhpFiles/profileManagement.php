<?php
namespace PhpFiles;
require(__DIR__ . '/../dist/connection.php');
class userProfile {
    public $username;
    public $name;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip;
    public $email;

    public function __construct($username, $name='', $address1='', $address2='', $city='', $state='', $zip='', $email='') {
        // Get the user's profile information from the database and store it in the object
        /*global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch_assoc();

        $this->username = htmlspecialchars($user['username']);
        $this->name = htmlspecialchars($user['name']);
        $this->address1 = htmlspecialchars($user['address1']);
        $this->address2 = htmlspecailchars($user['address2']);
        $this->city = htmlspecialchars($user['city']);
        $this->state = htmlspecialchars($user['state']);
        $this->zip = htmlspecialchars($user['zip']);
        $this->email = htmlspecialchars($user['email']);
        */

        // hardcode the user's profile information for now -- this will be removed when we have a database
        $this->username = $username;
        $this->name = $name;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->email = $email;
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

    public function updateProfile($name, $email, $address1, $address2, $city, $state, $zip){
        // Update the user's profile information in the database
        /*global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, address1 = ?, address2 = ?, city = ?, state = ?, zip = ? WHERE username = ?");
        $stmt->execute([$name, $email, $address1, $address2, $city, $state, $zip, $this->username]);
        */
        // Update the user's profile information in the session -- this is temporary will be removed when we have a database
        $_SESSION['Users'][$this->getUsername()]['name'] = $name;
        $_SESSION['Users'][$this->getUsername()]['email'] = $email;
        $_SESSION['Users'][$this->getUsername()]['address1'] = $address1;
        $_SESSION['Users'][$this->getUsername()]['address2'] = $address2;
        $_SESSION['Users'][$this->getUsername()]['city'] = $city;
        $_SESSION['Users'][$this->getUsername()]['state'] = $state;
        $_SESSION['Users'][$this->getUsername()]['zip'] = $zip;
        
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
