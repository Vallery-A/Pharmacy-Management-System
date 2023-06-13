<?php

$sname= "localhost";
$unmae= "root";
$password = "";

$db_name = "Pharmacy_db";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection failed!";

}

// Check if the invoice ID is provided
if (isset($_GET["invoice_number"])) {
    // Retrieve the invoice ID from the URL query string
    $invoiceId = $_GET["invoice_number"];

    // Delete the invoice from the database
    $sql = "DELETE FROM invoices WHERE id='$invoice_number'";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the dashboard after successful deletion
        header("Location: create_invoice.php");
        exit;
    } else {
        echo "Error deleting invoice: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
