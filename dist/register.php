<?php 
require(__DIR__ .'/../PhpFiles/registerModule.php');
require(__DIR__ .'/../PhpFiles/registerValidation.php');
require(__DIR__ . '/connection.php');
use PhpFiles\userRegister; 
use PhpFiles\registerValidation;
$errors = array();

if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $validate = new registerValidation($_POST);
        $errors = $validate->is_valid();
        if(empty($validate->errors()))
        {
            $module = new userRegister($_POST);
        }
        else
        {
            $errors = $validate->errors();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="output.css">
</head>

<!--Login Screen-->
<body class="bg-cover bg-center flex items-center justify-center h-screen" background=images/Refinery.jpg>

    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Client Registration</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <label for="username" class="block text-sm text-gray-500">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" class="mt-1 p-2 w-full border rounded-md">

            <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("username", $errors) )
                    {
                        $message = $errors["username"];
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>

            <label for="password" class="block mt-4 text-sm text-gray-500">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 p-2 w-full border rounded-md">

            <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("password", $errors) )
                    {
                        $message = $errors["password"];
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>

            <label for="password" class="block mt-4 text-sm text-gray-500">Confirm Password:</label>
            <input type="password" id="confirmPass" name="confirmPass" placeholder="Re-enter your password" class="mt-1 p-2 w-full border rounded-md">
             
            <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors) and array_key_exists("confirmPass", $errors) )
                    {
                        $message = $errors["confirmPass"];
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>

            <button class="mt-4 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
              Register
                </button> 

            <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST" and empty($errors))
                    {
                        echo "<Br><p><strong>Form submitted successfully! All input fields sucessfully validated.</strong></p>";
                            $currentUser = $_SESSION["CurrentUser"];
                            $user = new userRegister($currentUser, 
                                                    $_SESSION['Users'][$currentUser]['username'], 
                                                    $_SESSION['Users'][$currentUser]['password'],
                                                );
                        header("location:profile.php");
                    }?>
        </form>
        </p>
      </div>
</body>
</html>