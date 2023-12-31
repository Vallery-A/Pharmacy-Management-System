

<!DOCTYPE html>

<html>

<head>

    <title>Expired drugs</title>

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

    
    <h1>Expired Medicines</h1>
    <table>
        <thead>
            <tr>
                <th>Medicine Name</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            
        
        <?php
        // Fetch expired medicines from the database
        $sname= "localhost";
        $unmae= "root";
        $password = "";

        $db_name = "Pharmacy_db";

        $conn = mysqli_connect($sname, $unmae, $password, $db_name);

        if (!$conn) {

           echo "Connection failed!";
        }

            $sql = "SELECT medicineName, expiryDate FROM pharm_stock WHERE expiry_date < CURDATE()";
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $medicineName = $row['medicineName'];
                    $expiryDate = $row['expiryDate'];

                    echo "<tr>";
                    echo "<td>$medicineName</td>";
                    echo "<td>$expiryDate</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No expired medicines found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
        </table>

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

