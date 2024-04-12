 <?php
 	require( __DIR__ . '/../../PhpFiles/profileManagement.php');
	require( __DIR__ . '/../../PhpFiles/profileValidation.php');
    require( __DIR__ . '/../connection.php');
	use PhpFiles\userProfile; 
	use PhpFiles\profileValidation;

    $states = ["AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY"];

	//If the user is not logged in, redirect to the login page
	if(!isset($_SESSION["CurrentUser"])){
        header("Location: ../login.php");
    }
    //If the user is logged in, get the user's uuid from the session and create a new userProfile object
	else{
		$currentUser = $_SESSION["CurrentUser"];
		$user = new userProfile($currentUser);
	}
    // Update the user's profile information 
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		//Sanitize the input
		$post = array(
			'name' => htmlspecialchars($_POST['name']),
			'email' => htmlspecialchars($_POST['email']),
			'address1' => htmlspecialchars($_POST['address1']),
			'address2' => htmlspecialchars($_POST['address2']),
			'city' => htmlspecialchars($_POST['city']),
			'state' => htmlspecialchars($_POST['state']),
			'zip' => htmlspecialchars($_POST['zip']),
		);
        //Validate the input
		$validate = new profileValidation($post);
		$validate->is_valid();
		$errors = $validate->errors();
        //If there are errors, display an alert
		if(!empty($errors))
		{
            echo '<script type="text/javascript">';
            echo 'alert("Something went wrong, please make sure all submissions are valid");';
            echo '</script>';
		}
        //If there are no errors, update the user's profile information and refresh the page
		else{
            try{
                $user->updateProfile($currentUser, $post['name'], $post['email'], $post['address1'], $post['address2'], $post['city'], $post['state'], $post['zip']);
			    header("Refresh:0");
            } catch (Exception $e){
                echo '<script type="text/javascript">';
                echo $e->getMessage();
                echo '</script>';
            }
			
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Profile</title>
	<link rel="stylesheet" href="../output.css">
</head>

<body class="bg-cover bg-center flex items-center justify-center h-screen" background=../images/Refinery.jpg>
	<div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
		<div class="navbar">
			<ul>
			<li class="font-semibold text-gray-800 mb-4"><a class="active button-left">My Profile</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a href="../FuelQuote.php">New Quote</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a href="../history.php">View Quotes</a></li>
			</ul>
		</div>
		<h2 class="text-2xl mb-4">Welcome, <span class="font-semibold"><?php echo $user->getName() ?></span></h2>
		<div class="block text-sm p-2" id="showProfile">
			<label class="font-semibold" for="username">Username</label><br>
			<span id="username"><?php echo $user->getUsername()?></span><br><br>

			<label class="font-semibold" for="name">Name</label><br>
			<span id="name"><?php echo $user->getName()?></span><br><br>

			<label class="font-semibold" for="email">Email</label><br>
			<span id="email"><?php echo $user->getEmail()?></span><br><br>

			<label class="font-semibold" for="address1">Address 1</label><br>
			<span id="address1"><?php echo $user->getAddress1()?></span><br><br>

			<label class="font-semibold" for="address2">Address 2 (optional)</label><br>
			<span id="address2"><?php echo $user->getAddress2()?></span><br><br>

			<label class="font-semibold" for="city">City</label><br>
			<span id="city"><?php echo $user->getCity()?></span><br><br>

			<label class="font-semibold" for="province">State</label><br>
			<span id="currentState"><?php echo $user->getState()?></span><br><br>

			<label class="font-semibold" for="zip">Zip Code</label><br>
			<span id="zip"><?php echo $user->getZip()?></span><br><br>

			<button class="mt-4 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300" id='editProfileButton' onclick="toggleEdit()">Edit Profile</button>
		</div>

		<div class="hidden text-sm p-2" id="editProfile">

			<form method="POST" id="profileEditForm" novalidate>

                <div class="formGroup">
                    <label class="font-semibold" for="name">Name</label><br>
                    <input  required
                            minlength="5"
                            custommaxlength="50"
                            type="text" 
                            name="name" 
                            id="name"
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getName()?>" 
                            ><br>
                    <span class="error font-semibold text-red-700"></span><br>
                </div>

				<div class="formGroup">
                    <label class="font-semibold" for="email">Email</label><br>
                    <input  required
                            minlength="5"
                            custommaxlength="100"
                            type="email" 
                            name="email" 
                            id="email"
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getEmail()?>" 
                            ><br>
                    <span class="error font-semibold text-red-700"></span><br>
                </div>

				<div class="formGroup">
                    <label class="font-semibold" for="address1">Address 1</label><br>
                    <input  required
                            minlength="5"
                            custommaxlength="100"
                            type="text" 
                            name="address1" 
                            id="address1"
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getAddress1()?>" 
                            ><br>
                    <span class="error font-semibold text-red-700"></span><br>
                </div>

				<div class="formGroup">
                    <label class="font-semibold" for="address2">Address 2 (optional)</label><br>
                    <input  custommaxlength="100"
                            type="text" 
                            name="address2" 
                            id="address2"
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getAddress2()?>"><br>
                    <span class="error font-semibold text-red-700"></span><br>
                </div>

				<div class="formGroup">
                    <label class="font-semibold" for="city">City</label><br>
                    <input  required
                            minlength="3"
                            custommaxlength="100"
                            type="text" 
                            name="city" 
                            id="city"
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getCity()?>" 
                            ><br>
                    <span class="error font-semibold text-red-700"></span><br>
                </div>			

				<div class="formGroup">
                    <label class="font-semibold" for="select">State</label><br>
                    <select required name="state" id="select" minlength="2" custommaxlength="2" class="w-full p-2 border border-gray-300 rounded-md">
                        <?php foreach ($states as $state): ?>
                            <option value="<?php echo $state; ?>" <?php if ($state == $user->getState()) echo 'selected'; ?>>
                                <?php echo $state; ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>
                    <span class="error font-semibold text-red-700"></span><br>
	            </div>		

                <div class="formGroup">
                    <label class="font-semibold" for="zip">Zip Code</label><br>
                    <input  required
                            minlength="5"
                            custommaxlength="9"
                            type="text" 
                            name="zip" 
                            id="zip"
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getZip()?>" 
                            ><br>
                    <span class="error font-semibold text-red-700"></span><br>
                </div>			

				<input type="submit" value="submit" class="mt-4 bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300" id="submitProfileButton">
			</form>
		</div>
	</div>

	</div>
    <script src="profile.js"></script>
</body>

</html>
