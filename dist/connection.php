<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!array_key_exists("Users", $_SESSION)){
        $_SESSION['Users'] = array(
            "dogFriend1" => array(
                "username" => "dogFriend1",
                "password" => "Baby_Ring1",
                "name" => "John Smith",
                "email" => "jsmith1@gmail.com",
                "address1" => "14567 Happy Way Dr",
                "address2" => "Unit 2",
                "city" => "Houston",
                "state" => "TX",
                "zip" => "77001"
            ),
            "goodPal35" => array(
                "username" => "goodPal35",
                "password" => "SecurePass2",
                "name" => "Jane Doe",
                "email" => "jdoe35@hotmail.com",
                "address1" => "55567 Unhappy Blvd",
                "address2" => "",
                "city" => "Austin",
                "state" => "TX",
                "zip" => "78701"
            )
        );
        $_SESSION["History"] = array(
            "dogFriend1" => array(
                array("id" =>"99902345", "date"=> "2024-04-25", "address1" => "14567 Happy Way Dr", "addresss2"=> "Unit 2", "gallons"=> "5", "suggestPrice"=> "3.00", "totalPrice"=>"15.00")
            ),
            "goodPal35" => array(
                array("id" =>"13000345", "date"=> "2024-05-11", "address1" => "55567 Unhappy Blvd", "gallons"=> "5", "suggestPrice"=> "3.00", "totalPrice"=>"15.00")
            )
        );
    }
if(!array_key_exists("CurrentUser", $_SESSION)){
    $_SESSION["CurrentUser"] = "dogFriend1";
}
