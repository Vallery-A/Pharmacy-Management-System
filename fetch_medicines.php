<?php
// Connect to the database
$dbConnection = mysqli_connect('sname', 'unmae', 'password', 'Pharmacy_db');

// Fetch medicine names from the database
$query = "SELECT medicineName FROM pharm_stock";
$result = mysqli_query($dbConnection, $query);

$medicineData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $medicineData[] = $row;
}

// Return the medicine data as JSON
header('Content-Type: application/json');
echo json_encode($medicineData);
?>
