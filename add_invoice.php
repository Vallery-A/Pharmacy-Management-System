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
    // Retrieve the invoice data from the form
    $invoiceNumber = $_POST["invoice_number"];
    $date = $_POST["date"];
    $customer = $_POST["customer"];

    // Insert the invoice data into the database
    $sql = "INSERT INTO invoices (invoice_number, date, customer) VALUES ('$invoiceNumber', '$date', '$customer')";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the dashboard after successful creation
        header("Location: create_invoices.php");
        exit;
    } else {
        echo "Error creating invoice: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>

<html>

<head>

    <title>Add Invoice</title>

    <link rel="stylesheet" type="text/css" href="Dash.css">

</head>

<body>
  
  <div class="content">
    <div class="header">
      <div class="logo">
        <h2>Logo</h2>
      </div>
      <div class="menu-toggle">
        <span class="hamburger" onclick="toggleMenu()">&#9776;</span>
      </div>
      <ul class="menu" id="menu">
        <li><a href="signup.php">sign up</a></li>
        <li><a href="Dashboard.php">Home</a></li>
        <li><a href="add_patient.php">Add Patient</a></li>
      </ul>
    </div>

    
    <h1>Create Invoice</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="invoice_number">Invoice Number:</label>
                <input type="text" id="invoice_number" name="invoice_number" required>
            </div>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="customer">Customer:</label>
                <input type="text" id="customer" name="customer" required>
            </div>

            <button type="submit" class="button button-primary">Create</button>
        </form>

  <script>
    // JavaScript function to toggle the menu on smaller screens
    function toggleMenu() {
      var menu = document.getElementById("menu");
      menu.classList.toggle("show");
    }
  </script>


    <footer>
        <p>&copy; <?php echo date("Y"); ?> Pharmacy Management System. All rights reserved.</p>
    </footer>
    
</body>
</html>
