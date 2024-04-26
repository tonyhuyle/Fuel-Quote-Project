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
            <li class="font-semibold text-gray-800 mb-4" syle="float:right"><a href="logout.php">Logout</a></li> <!-- Changed href here -->
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
                    <th>Fuel Quote ID</th>
                    <th>Delivery Date</th>
                    <th>address</th>
                    <th>Gallons Requested</th>
                    <th>Price/Gallon</th>
                    <th>Total Amount Due</th>
                </tr>
            </thead>
                <?php
                    // echo $currentUser;

                    if(!isset($_SESSION["CurrentUser"])){
                        header("Location: login.php");
                    }
                    else{
                        $currentUser = $_SESSION["CurrentUser"];
                    // Connecting, selecting database
                        global $pdo;
                        // $dbconn = pg_connect("dbname=my_project")
                        // or die('Could not connect: ' . pg_last_error());
                    // Performing SQL query
                    // $name1 = "d0ca07c1-b0e2-4b79-8554-4ab885314813";    
                        $query = "SELECT quoteid, deliverydate, deliveryaddress, gallonsrequested, suggestedprice, totalamountdue FROM fuelquotehistory where userid = ?;";
                        // $result = pg_query($query) or die('Query failed: ' . pg_last_error());
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$currentUser]);
                        $result = $stmt->fetchAll();
                    // echo $query;
                    // Printing results in HTML
                    foreach ($result as $line) {
                        echo "\t<tr bgcolor=\"white\">\n";
                        echo "\t\t<td>$line[0]</td>\n";
                        echo "\t\t<td>$line[1]</td>\n";
                        echo "\t\t<td>$line[2]</td>\n";
                        echo "\t\t<td>$line[3]</td>\n";
                        echo "\t\t<td>$line[4]</td>\n";
                        echo "\t\t<td>$line[5]</td>\n";
                        echo "\t</tr>\n";
                    }
                }
                    ?>

        </table>
    </div>
</body>
