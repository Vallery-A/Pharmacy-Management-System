<?php

$sname= "localhost";
$unmae= "root";
$password = "";

$db_name = "Pharmacy_db";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection failed!";

}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the invoice ID from the URL query string
    $invoiceId = $_GET["invoice_number"];

    // Retrieve the updated invoice data from the form
    $invoiceNumber = $_POST["invoice_number"];
    $date = $_POST["date"];
    $customer = $_POST["customer"];

    // Update the invoice in the database
    $sql = "UPDATE invoices SET invoice_number='$invoice_number', date='$date', customer='$customer' WHERE id='$invoice_number'";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the dashboard after successful update
        header("Location: create_invoice.php");
        exit;
    } else {
        echo "Error updating invoice: " . $conn->error;
    }
}

// Retrieve the invoice ID from the URL query string
$invoiceId = $_GET["invoice_number"];

// Retrieve the invoice data from the database
$sql = "SELECT * FROM invoices WHERE id='$invoice_number'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    // Fetch the invoice data
    $row = $result->fetch_assoc();
    $invoiceNumber = $row["invoice_number"];
    $date = $row["date"];
    $customer = $row["customer"];
} else {
    // Redirect back to the dashboard if the invoice is not found
    header("Location: edit_invoice.php");
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="Dash.css">

</head>

<body>

<div id="wrapper">

</div>

<div id="banner">
    <h2>PHARMACY MANAGEMENT SYSTEM</h2>

</div>

<div id="navigation">
    <ul id="nav">
        <li><a href="#">sign up</a></li>
        <li><a href="Dashboard.php">Home</a></li>
        <li><a href="add_patient.php">Add Patient</a></li>

    </ul> 
                    

</div>
    <div>
        <h1>Edit Invoice</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="invoice_number">Invoice Number:</label>
                <input type="text" id="invoice_number" name="invoice_number" value="<?php echo $invoiceNumber; ?>" required>
            </div>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $date; ?>" required>
            </div>

            <div class="form-group">
                <label for="customer">Customer:</label>
                <input type="text" id="customer" name="customer" value="<?php echo $customer; ?>" required>
            </div>

            <button type="submit" class="button">Update</button>
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Pharmacy Management System. All rights reserved.</p>
    </footer>
</body>
</html>
