
<?php 
require(__DIR__ .'/../PhpFiles/loginModule.php');
require(__DIR__ .'/../PhpFiles/loginValidation.php');
use PhpFiles\userLogin; 
use PhpFiles\loginValidation;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $validate = new loginValidation($_POST);
  $errors = $validate->errors();
  if(!empty($errors))
  {
    echo "Errors found";
    exit();
  }
}

if(!isset($_GET['error'])) { 
    echo $_GET ['error']; 
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
      <form action="loginModule.php" method = "post">
          <label for="username" class="block text-sm text-gray-500">Username:</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" class="mt-1 p-2 w-full border rounded-md">
      
          <label for="password" class="block mt-4 text-sm text-gray-500">Password:</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 p-2 w-full border rounded-md">
      
          <button class="mt-4 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
            Login
          </button>
      </form>
        <p class="mt-4 text-sm text-gray-500">
          Don't have an account? <a href="register.html" class="text-blue-500">Register here</a>.
        </p>
      </div>
</body>
</html>

<?php
  $username = $_POST["username"];
  $password = $_POST["password"];
?>