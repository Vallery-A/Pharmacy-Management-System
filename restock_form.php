

<!DOCTYPE html>

<html>

<head>

    <title>Dashboard</title>

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

    
    <?php
    // Connect to the MySQL database
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    
    $db_name = "Pharmacy_db";
    
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    // Check the database connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve supplier information from the database
    if (isset($_GET['supplier_name'])) {
        $supplierName = $_GET['supplier_name'];
    } else {
        $supplierName = "Unknown Supplier";
    }

     // Handle form submission
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $medicineName = $_POST['medicine_name'];
        $quantity = $_POST['quantity'];
        $receivedByWhen = $_POST['received_by_when'];

        // Redirect to compose email on Gmail
        $emailSubject = "Restock Order for $medicineName";
        $emailBody = "Dear $supplierName,\n\nI would like to place an order to restock $medicineName. Please provide $quantity units by $receivedByWhen.\n\nThank you.\n\nSincerely,\n[Your Name]";
        $gmailComposeUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=&su=" . urlencode($emailSubject) . "&body=" . urlencode($emailBody);
        echo "<script>window.location.href = '$gmailComposeUrl';</script>";
        exit;
    }


    // Close the database connection
    mysqli_close($conn);
    ?>

    <h1><?php echo $supplierName; ?> - Restock Medicine</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="supplier_name" value="<?php echo $supplierName; ?>">
        <label for="medicine_name">Medicine Name:</label>
        <input type="text" id="medicine_name" name="medicine_name" required>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>
        <label for="received_by_when">Received By:</label>
        <input type="date" id="received_by_when" name="received_by_when" required><br><br>
        <button type="submit">Restock</button>
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

