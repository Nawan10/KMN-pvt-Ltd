<?php
// Establish database connection

require "dbh.inc.php";
// $connect = mysqli_connect("localhost", "root", "", "kmn (pvt) ltd");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the item parameter is set and not empty
if(isset($_GET['item']) && !empty($_GET['item'])) {
    // Sanitize the input to prevent SQL injection
    $itemName = mysqli_real_escape_string($connect, $_GET['item']);

    // Query to fetch item cost based on the selected item name
    $query = "SELECT Item_Cost FROM item WHERE Item_Name = '$itemName'";

    $result = mysqli_query($connect, $query);

    if($result && mysqli_num_rows($result) > 0) {
        // Fetch the item cost from the result set
        $row = mysqli_fetch_assoc($result);
        $itemCost = $row['Item_Cost'];

        // Return the item cost as response
        echo $itemCost;
    } else {
        // Item not found or query failed
        echo "Error: Item not found";
    }
} else {
    // Item parameter not set or empty
    echo "Error: Invalid request";
}

// Close database connection
mysqli_close($connect);
?>
