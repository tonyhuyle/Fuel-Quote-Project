<?php
    session_start();
    require(__DIR__ .'/../PhpFiles/FuelQuoteModule.php');
    require(__DIR__ .'/../PhpFiles/FuelQuoteValidation.php');
    use PhpFiles\FuelQuoteModule;
    use PhpFiles\FuelQuoteValidation;
    $errors = array();
    if(!array_key_exists("Users", $_SESSION))
    {
        $_SESSION["Users"] = array("dogFriend1", "goodPal35");
        $_SESSION["passwords"] = array("Baby_Ring1", "SecurePass2");
        $_SESSION["History"] = array(
            "dogFriend1" => array(
                array("id" =>"99902345", "date"=> "2024-04-25", "address" => "14567 Happy Way Dr", "gallons"=> "5", "suggestPrice"=> "3.00", "totalPrice"=>"15.00")
            )
        );
       
        $_SESSION["History"]["goodPal35"] = array(array("id" =>"13000345", "date"=> "2024-05-11", "address" => "55567 Unhappy Blvd", "gallons"=> "5", "suggestPrice"=> "3.00", "totalPrice"=>"15.00"));
        $_SESSION["History"]["dogFriend1"][] = array("id" =>"99902345", "date"=> "2024-05-25", "address" => "14567 Happy Way Dr", "gallons"=> "7", "suggestPrice"=> "3.00", "totalPrice"=>"21.00");
    }
    if(!array_key_exists("CurrentUser", $_SESSION))
    {
         $_SESSION["CurrentUser"] = "dogFriend1"; //default to being under dogFriend1's profile
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $validate = new FuelQuoteValidation($_POST);
        $errors = $validate->is_valid();
        $FormSubmitSuccesful = FALSE;
        if(empty($validate->errors())) //No errors popped up so go ahead and assign form data to Module
        {
            $module = new FuelQuoteModule($_POST);
            $id = rand(10000000, 99999999);
            $gallons = $module->getGallons();
            $address = $module->getAddress();
            $date = $module->getDate();
            $suggestPrice = $module->getSuggestedPrice();
            $totalPrice = $module->getTotalPrice();
            $currentUser = $_SESSION["CurrentUser"];
            if(!array_key_exists($currentUser, $_SESSION["History"])) //There is no history for this user
            {
                $_SESSION["History"][$currentUser] = array(array("id" =>$id, "date"=> $date, "address" => $address, "gallons"=> $gallons, "suggestPrice"=> $suggestPrice, "totalPrice"=>$totalPrice));
            }
            else //There is history
            {
                //$currentUserRecords = $_SESSION["History"][$currentUser]; THIS IS FRUSTRATINGLY WRONG
                $_SESSION["History"][$currentUser][] = (array("id" =>$id, "date"=> $date, "address" => $address, "gallons"=> $gallons, "suggestPrice"=> $suggestPrice, "totalPrice"=>$totalPrice));
                echo '<pre>';
                print_r($_SESSION["History"]);
                echo '</pre>';

            }
            $FormSubmitSuccesful = TRUE;
        }
        else
        {
            $errors = $validate->errors();
        }
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FuelQuote</title>
    <link rel="stylesheet" href="output.css">
</head>

<!--Account Management Form-->
<body class="bg-cover bg-center flex items-center justify-center h-screen" background=images/Refinery.jpg>

    <div class="container mx-auto my-36 p-6 bg-white max-w-6xl rounded shadow-md" style = "height: 66.666667%">
        <div class="navbar">
			<ul>
			<li class="font-semibold text-gray-800 mb-4"><a href="profile/profile.php" class="button-left">My Profile</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a class="active">New Quote</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a href="history.php">View Quotes</a></li>
			</ul>
		</div>
        <div class ="p-2 text-2xl text-center"> Fuel Quote Form
        </div>
            <div class="m-2">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <h2 class="font-semibold">Gallons of Oil to request</h2>
                    <input class = "h-10 box-border border-2" type="number" required name = "gallons" min="0" value="0" step="0.01" style="width:750px;"><br>
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                        //echo $currentUser;
                        //echo $_SESSION["History"][$_SESSION["CurrentUser"]][0][2];
                        //echo '<pre>';
                        //print_r($_SESSION["History"]);
                        //echo '</pre>';
                   }
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("gallons", $errors))
                    {
                        $message = $errors["gallons"];
                        echo "Error: ";
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>
<!-- PUT CHECKBOX HERE FOR ADDRESS! -->
                    <label class="font-semibold" for="address1">Street Address</label>
				    <input type="text" id="address1" class="w-full p-2 border border-gray-300 rounded-md" name="address">
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("address", $errors) )
                    {
                        $message = $errors["address"];
                        echo "Error: ";
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>
                    <h2 class = "mt-10 font-semibold">Delivery Date</h2>
                    <input class = "h-10 box-border border-2" type="date" name = "date">
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("date", $errors) )
                    {
                        $message = $errors["date"];
                        echo "Error: ";
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>
                    <h2 class="mt-10 font-semibold">Suggested Price Per Gallon</h2>
                    <input class = "h-10 box-border border-2" placeholder="Sample Price: 3.02" type="text" style="width:750px" readonly>
                    <h2 class="mt-10 font-semibold">Total Price</h2>
                    <input class = "h-10 box-border border-2" placeholder="Sample Price: 3.02" type="text" style="width:750px" readonly>
                    <input type = "submit" value="submit" name="submit" class="rounded shadow-md block p-3">
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors) && $FormSubmitSuccesful == TRUE)
                    {
                        echo "<Br><p><strong>Form submitted successfully! All input fields sucessfully validated.</strong></p>";
                    }
                    else if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($errors))
                    {
                        echo "<Br><p><strong>Form NOT submitted successfully! Error should be displayed above.</strong></p>";
                        print_r($errors);
                    }
                    else if($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors) && $FormSubmitSuccesful == FALSE)
                    {
                        echo "<Br><p><strong>Form NOT submitted successfully! Something wrong with submitting fuel quote to history.</strong></p>";
                    }
                    ?>
                </form>
            </div>
    </div>
</body>
