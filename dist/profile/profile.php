 <?php
 	require( __DIR__ . '/../../PhpFiles/profileManagement.php');
	use PhpFiles\userProfile; 
	use PhpFiles\profileValidation;
	// hardcode session variable
	$_SESSION['username'] = "JohnDoe123";
	// Check if the user is authenticated
	if(!isset($_SESSION['username'])) { 
		// Redirect to login page if not
		header("Location: ../login.php");
		exit();
	}
	else {	
		// Create a new user profile object
		$user = new userProfile($_SESSION['username']);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Update the user's profile information 
		$validate = new profileValidation($_POST);
		$validate->is_valid();
		$errors = $validate->errors();
		if(!empty($errors))
		{
			echo "Errors found";
			exit();
		}
		else{
			$user->updateProfile($_POST['name'], $_POST['email'], $_POST['address1'], $_POST['address2'], $_POST['city'], $_POST['state'], $_POST['zip']);
			header("Refresh:0");
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
		<h2 class="text-2xl mb-4">Welcome, <span class="font-semibold">John Doe</span>!</h2>
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

			<button class="rounded shadow-md block p-3" onclick="toggleEdit()"> Edit Profile </button>
		</div>

		<div class="hidden text-sm p-2" id="editProfile">
			<span id="editError" class="text-red-500"></span><br>
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
				<label class="font-semibold" for="name">Name</label><br>
				<input type="text" id="name" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $user->getName()?>"><br>
				<span id="nameError" class="text-red-500"></span><br>

				<label class="font-semibold" for="email">Email</label><br>
				<input type="email" id="email" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $user->getEmail()?>"><br>
				<span id="emailError" class="text-red-500"></span><br>

				<label class="font-semibold" for="address1">Address 1</label><br>
				<input type="text" id="address1" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $user->getAddress1()?>"><br>
				<span id="address1Error" class="text-red-500"></span><br>

				<label class="font-semibold" for="address2">Address 2 (optional)</label><br>
				<input type="text" id="address2" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $user->getAddress2()?>"><br>
				<span id="address2Error" class="text-red-500"></span><br>

				<label class="font-semibold" for="city">City</label><br>
				<input type="text" id="city" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $user->getCity()?>"><br>
				<span id="cityError" class="text-red-500"></span><br>

				<label class="font-semibold" for="state">State</label><br>
				<select id="state" class="w-full p-2 border border-gray-300 rounded-md">
					<option value="AL">AL</option>
					<option value="AK">AK</option>
					<option value="AZ">AZ</option>
					<option value="AR">AR</option>
					<option value="CA">CA</option>
					<option value="CO">CO</option>
					<option value="CT">CT</option>
					<option value="DE">DE</option>
					<option value="FL">FL</option>
					<option value="GA">GA</option>
					<option value="HI">HI</option>
					<option value="ID">ID</option>
					<option value="IL">IL</option>
					<option value="IN">IN</option>
					<option value="IA">IA</option>
					<option value="KS">KS</option>
					<option value="KY">KY</option>
					<option value="LA">LA</option>
					<option value="ME">ME</option>
					<option value="MD">MD</option>
					<option value="MA">MA</option>
					<option value="MI">MI</option>
					<option value="MN">MN</option>
					<option value="MS">MS</option>
					<option value="MO">MO</option>
					<option value="MT">MT</option>
					<option value="NE">NE</option>
					<option value="NV">NV</option>
					<option value="NH">NH</option>
					<option value="NJ">NJ</option>
					<option value="NM">NM</option>
					<option value="NY">NY</option>
					<option value="NC">NC</option>
					<option value="ND">ND</option>
					<option value="OH">OH</option>
					<option value="OK">OK</option>
					<option value="OR">OR</option>
					<option value="PA">PA</option>
					<option value="RI">RI</option>
					<option value="SC">SC</option>
					<option value="SD">SD</option>
					<option value="TN">TN</option>
					<option value="TX">TX</option>
					<option value="UT">UT</option>
					<option value="VT">VT</option>
					<option value="VA">VA</option>
					<option value="WA">WA</option>
					<option value="WV">WV</option>
					<option value="WI">WI</option>
					<option value="WY">WY</option>
				</select><br>
				<span id="stateError" class="text-red-500"></span><br>

				<label class="font-semibold" for="zip">Zip Code</label><br>
				<input type="text" id="zip" class="w-full p-2 border border-gray-300 rounded-md" value="<?php echo $user->getZip()?>"><br>
				<span id="zipError" class="text-red-500"></span><br>

				<input type="submit" value="Submit" class="rounded shadow-md block p-3" onclick="validateProfile()">
			</form>
		</div>
	</div>
	<script src="profile.js"></script>
</body>

</html>
