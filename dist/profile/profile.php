 <?php
 	require( __DIR__ . '/../../PhpFiles/profileManagement.php');
	require( __DIR__ . '/../../PhpFiles/profileValidation.php');
	require(__DIR__ . '/../connection.php');
	use PhpFiles\userProfile; 
	use PhpFiles\profileValidation;
	// hardcode session variable
	if(!array_key_exists("CurrentUser", $_SESSION)){
		header("Location: ../login.php");
	}
	else{
		$currentUser = $_SESSION["CurrentUser"];
		$user = new userProfile($currentUser, 
								$_SESSION['Users'][$currentUser]['name'], 
								$_SESSION['Users'][$currentUser]['address1'], 
								$_SESSION['Users'][$currentUser]['address2'], 
								$_SESSION['Users'][$currentUser]['city'], 
								$_SESSION['Users'][$currentUser]['state'], 
								$_SESSION['Users'][$currentUser]['zip'],
                                $_SESSION['Users'][$currentUser]['email']);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		// Update the user's profile information 
		$post = array(
			'name' => htmlspecialchars($_POST['name']),
			'email' => htmlspecialchars($_POST['email']),
			'address1' => htmlspecialchars($_POST['address1']),
			'address2' => htmlspecialchars($_POST['address2']),
			'city' => htmlspecialchars($_POST['city']),
			'state' => htmlspecialchars($_POST['state']),
			'zip' => htmlspecialchars($_POST['zip']),
		);
		$validate = new profileValidation($post);
		$validate->is_valid();
		$errors = $validate->errors();
		if(!empty($errors))
		{
            echo '<script type="text/javascript">';
            echo 'alert("Something went wrong, please make sure all submissions are valid");';
            echo '</script>';
		}
		else{
			$user->updateProfile($post['name'], $post['email'], $post['address1'], $post['address2'], $post['city'], $post['state'], $post['zip']);
			header("Location: profile.php");
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
		<h2 class="text-2xl mb-4">Welcome, <span class="font-semibold"><?php echo $user->getName() ?></span>!</h2>
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

			<button class="rounded shadow-md block p-3" id='editProfileButton' onclick="toggleEdit()">Edit Profile</button>
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
                    <span class="error text-red-700"></span><br>
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
                    <span class="error text-red-700"></span><br>
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
                    <span class="error text-red-700"></span><br>
                </div>

				<div class="formGroup">
                    <label class="font-semibold" for="address2">Address 2 (optional)</label><br>
                    <input  custommaxlength="100"
                            type="text" 
                            name="address2" 
                            id="address2"
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getAddress2()?>"><br>
                    <span class="error text-red-700"></span><br>
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
                    <span class="error text-red-700"></span><br>
                </div>			

				<div class="formGroup">
                    <label class="font-semibold" for="select">State</label><br>
                    <select required
                            name="state" 
                            id="select" 
                            minlength="2" 
                            custommaxlength="2" 
                            class="w-full p-2 border border-gray-300 rounded-md" 
                            value="<?php echo $user->getState()?>" 
                            >
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
                    <span class="error text-red-700"></span><br>
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
                    <span class="error text-red-700"></span><br>
                </div>			

				<input type="submit" value="submit" class="rounded shadow-md block p-3" id="submitProfileButton">
			</form>
		</div>
	</div>

	</div>
    <script src="profile.js"></script>
</body>

</html>
