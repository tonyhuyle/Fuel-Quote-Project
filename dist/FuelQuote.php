<?php
    session_start();
    require(__DIR__ .'/../PhpFiles/FuelQuoteModule.php');
    require(__DIR__ .'/../PhpFiles/FuelQuoteValidation.php');
    require( __DIR__ . '/../PhpFiles/profileManagement.php');
    require( __DIR__ . '/connection.php');
    use PhpFiles\FuelQuoteModule;
    use PhpFiles\FuelQuoteValidation;
    use PhpFiles\userProfile; 
    $errors = array();
    $states = ["AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY"];

    if(!isset($_SESSION["CurrentUser"])){
        #header("Location: /login.php");
        #$_SEESION["CurrentUser"] = "727ddc29-248e-4c17-9382-a3729dd5b73a";
        $currentUser = $_SESSION["CurrentUser"];
    }
    else
    {
        $currentUser = $_SESSION["CurrentUser"];
		$user = new userProfile($currentUser);
        //query the db to see if the user has a quote history
        $userHasHistory = FALSE;
        $query = $pdo->prepare("SELECT * FROM fuelquotehistory WHERE userid = ?");
        $query->execute([$currentUser]);
        $result = $query->fetch();
        if($result)
        {
            $userHasHistory = TRUE;
        }
    }
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $validate = new FuelQuoteValidation($_POST);
        $errors = $validate->is_valid();
        $FormSubmitSuccesful = FALSE;
        if(empty($validate->errors())) //No errors popped up so go ahead and assign form data to Module
        {
            $module = new FuelQuoteModule($_POST, $userHasHistory);
            /* OLD HARDCODED CODE.
            $id = rand(10000000, 99999999);
            
            $gallons = $module->getGallons();
            $address = $module->getAddress();
            $date = $module->getDate();
            $suggestPrice = $module->getSuggestedPrice();
            $totalPrice = $module->getTotalPrice();
            $currentUser = $_SESSION["CurrentUser"];
            if(!array_key_exists($currentUser, $_SESSION["History"])) //There is no history for this user
            {
                $_SESSION["History"][$currentUser] = array(array("id" =>$id, "date"=> $date, "address1" => $address, "gallons"=> $gallons, "suggestPrice"=> $suggestPrice, "totalPrice"=>$totalPrice));
            }
            else //There is history
            {
                //$currentUserRecords = $_SESSION["History"][$currentUser]; THIS IS FRUSTRATINGLY WRONG
                $_SESSION["History"][$currentUser][] = (array("id" =>$id, "date"=> $date, "address1" => $address, "gallons"=> $gallons, "suggestPrice"=> $suggestPrice, "totalPrice"=>$totalPrice));


            }
            */
            $module-> InsertFuelQuote($currentUser);
            $FormSubmitSuccesful = TRUE;
            $quoteId = $module->getQuoteId();
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
    <style>
        button:disabled, input[type="submit"]:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
    <script src="fuelQuote.js"></script>
</head>

<!--Account Management Form-->
<body class="bg-cover bg-center flex items-center justify-center h-screen" background=images/Refinery.jpg>

    <div class="container mx-auto my-36 p-6 bg-white max-w-6xl rounded shadow-md">
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
                <form id="quoteForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <input type="hidden" id="hasHistory" name="hasHistory" value="<?php echo $hasHistory?>">

                    <h2 class="font-semibold">Gallons of Oil to request: A positive integer is expected</h2>
                    <input required class = "h-10 box-border border-2" type="number" required name = "gallons" id="gallons" min="0" value="0" step="0.01" style="width:750px;"><br>
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("gallons", $errors))
                    {
                        $message = $errors["gallons"];
                        echo "Error: ";
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>
<!-- PUT CHECKBOX HERE FOR ADDRESS! -->
                    <label class="font-semibold" for="address1">Street Address 1: Alphanumerical format with spaces at least 5 characters long and no more than 100 characters </label>
				    <input required type="text" id="address1" class="w-full p-2 border border-gray-300 rounded-md" name="address" value="<?php echo $user->getAddress1() ?>"><br>

                    <label class="font-semibold" for="address2">Street Address 2 (optional): Alphanumerical format with spaces at least 5 characters long and no more than 100 characters </label>
                    <input type="text" id="address2" class="w-full p-2 border border-gray-300 rounded-md" name="address2" value="<?php echo $user->getAddress2() ?>"><br>

                    <label class="font-semibold" for="city">City:</label>
                    <input required type="text" id="city" class="w-full p-2 border border-gray-300 rounded-md" name="city" value="<?php echo $user->getCity() ?>"><br>

                    <label class="font-semibold" for="state">State:</label>
                    <select required name="state" id="state" minlength="2" custommaxlength="2" class="w-full p-2 border border-gray-300 rounded-md">
                        <?php foreach ($states as $state): ?>
                            <option value="<?php echo $state; ?>" <?php if ($state == $user->getState()) echo 'selected'; ?>>
                                <?php echo $state; ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>

                    <label class="font-semibold" for="zip">Zip Code:</label>
                    <input required type="text" id="zip" class="w-full p-2 border border-gray-300 rounded-md" name="zip" value="<?php echo $user->getZip() ?>"><br>
                    
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("address", $errors) )
                    {
                        $message = $errors["address"];
                        echo "Error: ";
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>
                    <h2 class = "mt-10 font-semibold">Delivery Date: Pick a date that has not already passed and not more than 1 year into the future.</h2>
                    <input required class = "h-10 box-border border-2" type="date" name = "date">
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("date", $errors) )
                    {
                        $message = $errors["date"];
                        echo "Error: ";
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>
                    <h2 class="mt-10 font-semibold">Suggested Price Per Gallon:</h2>
                    <input class = "h-10 box-border border-2" placeholder="Price is dependent on State and number of gallons requested" type="number" step="0.001" min="0" style="width:750px" id="suggestedPrice" name="suggestedPrice" readonly>
                    <h2 class="mt-10 font-semibold">Total Price:</h2>
                    <input class = "h-10 box-border border-2" placeholder="Price is dependent on State and number of gallons requested" type="number" step="0.001" min="0" style="width:750px" id="totalPrice" name="totalPrice" readonly>
                    <button class="mt-4 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300" type="button" id="getQuote">Get Quote</button>
                    <input type = "submit" value="submit" name="submit" class="mt-4 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300" id="submitQuote">
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors) && $FormSubmitSuccesful == TRUE)
                    {
                        echo "<Br><p><strong>Form submitted successfully! Fuel Quote ID: $quoteId </strong></p>";
                    }
                    else if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($errors))
                    {
                        echo "<Br><p><strong>Form NOT submitted successfully! Error should be displayed above.</strong></p>";
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
