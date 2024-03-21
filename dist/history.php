<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Fuel Quote History</title>
</head>

<body class="bg-cover bg-center flex items-center justify-center h-screen" background=images/Refinery.jpg>     

    <div class="container mx-auto my-36 p-6 bg-white max-w-6xl rounded shadow-md">
        <div class="navbar">
			<ul>
			<li class="font-semibold text-gray-800 mb-4"><a href="profile/profile.html" class="button-left">My Profile</a></li>
			<li class="font-semibold text-gray-800 mb-4"><a href="FuelQuote.html">New Quote</a></li>
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
                    // Connecting, selecting database
                    $dbconn = pg_connect("dbname=my_project")
                        or die('Could not connect: ' . pg_last_error());
                    // Performing SQL query
                    $name1 = "190566c4-1b55-47ab-8a07-ff18765e6e5e";    
                    $query = "SELECT id, date, address, gallons, price, total FROM history where owner = '%s';";
                    $query = sprintf($query, $name1);
                    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
                    // echo $query;
                    // Printing results in HTML
                    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                        echo "\t<tr bgcolor=\"white\">\n";
                        foreach ($line as $col_value) {
                            echo "\t\t<td>$col_value</td>\n";
                        }
                        echo "\t</tr>\n";
                    }

                    pg_free_result($result);

                    pg_close($dbconn);
                    ?>
        </table>
    </div>
</body>
