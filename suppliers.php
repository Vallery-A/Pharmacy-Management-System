
<!DOCTYPE html>

<html>

<head>

    <title>suppliers</title>

    <link rel="stylesheet" type="text/css" href="Dash.css">

</head>

<body>

<div class="sidebar">
    <h2>Sidebar</h2>
    <ul id="side">
        <li><a href="add_patient.php">Patient/Customer</a></li>
        <li><a href="stock.php">Inventory/Stock</a></li>
        <li><a href="med_list.php">Medicine List</a></li>
        <li><a href="create_invoice.php">Invoices</a></li>
        <li><a href="sales.php">Pharmacy Sales</a></li>
        <li><a href="expired.php">Expired Meds</a></li>
        <li><a href="suppliers.php">Suppliers</a></li>
        <li><a href="userlog.php">Users</a></li>
    </ul>
</div>
  
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

    
    <h1>Supplier List</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="supplier_name">Supplier Name:</label>
        <input type="text" id="supplier_name" name="supplier_name" required>
        <label for="supplier_email">Supplier Email:</label>
        <input type="email" id="supplier_email" name="supplier_email" required>
        <button type="submit" name="add_supplier">Add Supplier</button>
    </form>
    <h1>List of Suppliers</h1>
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

    // Insert new supplier into the database if form is submitted
    if (isset($_POST['add_supplier'])) {
        $supplierName = $_POST['supplier_name'];
        $supplierEmail = $_POST['supplier_email'];
        $sql = "INSERT INTO suppliers (supplierName, supplierEmail) VALUES ('$supplierName', '$supplierEmail')";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Supplier added successfully.</p>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Retrieve suppliers from the database
    $query = "SELECT * FROM suppliers";
    $result = mysqli_query($conn, $query);

    // Display the table of suppliers
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Supplier Name</th><th>Supplier Email</th><th>Restock Medicine</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['supplierName'] . "</td>";
            echo "<td>" . $row['supplierEmail'] . "</td>";
            echo "<td><a href='restock_form.php?supplier_name=" . urlencode($row['supplierName']) . "'>Restock Medicine</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No suppliers found.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

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

