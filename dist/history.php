<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Fuel Quote History</title>
</head>
<?php
include 'connection.php';
?>
<body class="bg-cover bg-center flex items-center justify-center h-screen" background=images/Refinery.jpg>     

    <div class="container mx-auto my-36 p-6 bg-white max-w-6xl rounded shadow-md">
        <div class="navbar">
			<ul>
			<li class="font-semibold text-gray-800 mb-4"><a href="profile/profile.php" class="button-left">My Profile</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a href="FuelQuote.php">New Quote</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a class="active">View Quotes</a></li>
			</ul>
		</div>

        <h2 class="text-2xl font-semibold mb-4">Fuel Quote History</h2>
        <table id="history" style="width:100%">
        <style>
             table, th, td {
              border: 1px solid black;
              border-collapse: collapse;
            }
        </style>
            <thead>
                <tr bgcolor="#D6EEEE">
                    <th>id</th>
                    <th>date</th>
                    <th>address</th>
                    <th>Gallons Requested</th>
                    <th>Price/Gallon</th>
                    <th>Total Amount Due</th>
                </tr>
            </thead>
                <?php
                //History page.
                $CurrentUser = $_SESSION["CurrentUser"];
                $registeredUsers = $_SESSION["Users"];
                if(isset($_SESSION["History"][$CurrentUser])) //If there is some value associated with key $currentUser in the history table
                {
                    $currentUserRecords = $_SESSION["History"][$CurrentUser];

                    // echo sizeof($currentUserRecords);
                    for($i = 0; $i < sizeof($currentUserRecords); $i++)
                    {
                        $id = $currentUserRecords[$i]["id"];
                        $date = $currentUserRecords[$i]["date"];
                        $address = $currentUserRecords[$i]["address1"];
                        $gallons = $currentUserRecords[$i]["gallons"];
                        $pricePerGallon = $currentUserRecords[$i]["suggestPrice"];
                        $totalPrice = $currentUserRecords[$i]["totalPrice"];
                        //Display all of these on webpage
                        // echo "here";
                        echo "\t<tr bgcolor=\"white\">\n";
                        echo "\t\t<td>$id</td>\n";
                        echo "\t\t<td>$date</td>\n";
                        echo "\t\t<td>$address</td>\n";
                        echo "\t\t<td>$gallons</td>\n";
                        echo "\t\t<td>$pricePerGallon</td>\n";
                        echo "\t\t<td>$totalPrice</td>\n";
                        echo "\t</tr>\n";
                    }
    

                }
                else // There is NO history to show for this user. Do Nothing / show blanks
                {
                    // echo "$CurrentUser";
                }
                //END HISTORY INSTRUCTIONS

    //Management
    
                // Printing results in HTML
                ?>
        </table>
    </div>
</body>
