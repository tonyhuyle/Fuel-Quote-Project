<?php
    #require('../PhpFiles/FuelQuoteModule.php');
    #require('../PhpFiles/FuelQuoteValidation.php');
    use PhpFiles\FuelQuoteModule;
    use PhpFiles\FuelQuoteValidation;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $Form = new FuelQuoteModule($_POST);
        $validate = new FuelQuoteValidation($Form);
        $this->validate->validateGallons();
        echo empty($this->validate->errors());
        echo $_POST['date'];

    }
    if(isset($_POST['submit'])){
        echo 'form submitted';

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

    <div class="container mx-auto my-36 p-6 bg-white max-w-6xl rounded shadow-md">
        <div class="navbar">
			<ul>
			<li class="font-semibold text-gray-800 mb-4"><a href="profile/profile.html" class="button-left">My Profile</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a class="active">New Quote</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a href="history.html">View Quotes</a></li>
			</ul>
		</div>
        <div class ="p-2 text-2xl text-center"> Fuel Quote Form
        </div>
            <div class="m-2">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <h2 class="font-semibold">Gallons of Oil to request</h2>
                    <input class = "h-10 box-border border-2" type="number" required name = "gallons" min="0" value="0" step="0.01" style="width:750px;">
                    <h2 class = "mt-10 font-semibold">Delivery Address</h2>
                    <input class = "h-10 box-border border-2" placeholder="123HillsLane" name = address style="width:750px">
                    <h2 class = "mt-10 font-semibold">Delivery Date</h2>
                    <input class = "h-10 box-border border-2" type="date" name = "date">
                    <h2 class="mt-10 font-semibold">Suggested Price Per Gallon</h2>
                    <input class = "h-10 box-border border-2" placeholder="Sample Price: 3.02" type="text" style="width:750px" readonly>
                    <h2 class="mt-10 font-semibold">Total Price</h2>
                    <input class = "h-10 box-border border-2" placeholder="Sample Price: 3.02" type="text" style="width:750px" readonly>
                    <input type = "submit" value="submit" name="submit" class="rounded shadow-md block p-3">
                </form>
            </div>
    </div>
</body>
