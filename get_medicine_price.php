<?php
// Retrieve the selected medicine from the query string
$medicine = $_GET['medicine'];

// Connect to the database
$sname= "localhost";
$unmae= "root";
$password = "";
$db_name = "Pharmacy_db";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the medicine price from the database
$sql = "SELECT productPrice FROM pharm_stock WHERE medicineName = '$medicine'";
$result = mysqli_query($conn, $sql);

// Get the price value
if ($row = mysqli_fetch_assoc($result)) {
    $price = $row['productPrice'];
} else {
    $price = "";
}

// Close the database connection
mysqli_close($conn);

// Return the price as the response
echo $price;
?>





