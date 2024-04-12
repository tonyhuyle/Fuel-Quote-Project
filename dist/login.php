
<?php 
require(__DIR__ .'/../PhpFiles/loginModule.php');
require(__DIR__ .'/../PhpFiles/loginValidation.php');
require(__DIR__ . '/connection.php');
use PhpFiles\userLogin; 
use PhpFiles\loginValidation;
$errors = array();
/*
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $validate = new loginValidation($_POST);
    $errors = $validate->is_valid();
    $formLoginSuccessful = false;
    if(empty($validate->errors())) {
         $module = new userLogin($_POST);
         $username = $_POST["username"];
         $password = $_POST["password"];
        
         $module->getUsername($username);
         $module->getUsername($password);
        // Set the current user variable
     // Assuming $username is the user's identifier
        
        // Redirect to the profile page after successful registration
        if(array_key_exists($username, $_SESSION["Users"])) {
            if($_SESSION["Users"][$username]["password"] == $password) {
        $_SESSION["CurrentUser"] = $username;
        $formLoginSuccessful = true;
        header("Location: ../dist/profile/profile.php");
        exit; // Make sure to exit after redirection
            }
        }
        
    }
    else 
    {
        $errors = $validate->errors();
    }
}
*/
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validate = new loginValidation($_POST);
    $errors = $validate->is_valid();
    if(empty($validate->errors())) {
         $username = $_POST["username"];
         $password = $_POST["password"];

         // Prepare SQL statement to fetch user data
        $query = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $query->execute([$username]);
        $result = $query->fetch();

        // Check if user exists and verify password
        if ($result) {
            if (password_verify($password, $result['passwordhash'])) {
                // Set the current user variable
                $query = $pdo ->prepare("SELECT userid FROM users WHERE users.username = ? LIMIT 1");
                $query ->execute([$username]);
                $user = $query->fetch();
                
                $_SESSION["CurrentUser"] = $user['userid'];
                header("Location: ../dist/profile/profile.php");
                exit; // Make sure to exit after redirection
            }
            else {
                // If password is incorrect, set error message
                $errors[] = "Invalid username or password";
            }
        }
        // If credentials are not valid, set error message
        $errors[] = "Invalid username or password";
    }
    else {
        $errors = $validate->errors();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="output.css">
</head>

<!--Login Screen-->
<body class="bg-cover bg-center flex items-center justify-center h-screen" background=images/Refinery.jpg>

    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Client Portal</h2>
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
                    if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($errors))
                    {
                        $message = $errors[0];
                        echo "<Br><p style=\"color:red\"><strong>Error with input! Message: $message </strong></p>";
                    }?>

          <button class="mt-4 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
            Login
          </button>
      </form>
        <p class="mt-4 text-sm text-gray-500">
          Don't have an account? <a href="register.php" class="text-blue-500">Register here</a>.
        </p>
      </div>
</body>
</html>
