<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>

<!DOCTYPE html>

<html>

<head>

    <title>Dashboard</title>

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

    
    <h1>Content</h1>
        <table>
            <caption>Pharmacy Patients</caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            <?php
             $sname= "localhost";
             $unmae= "root";
             $password = "";

             $db_name = "Pharmacy_db";

             $conn = mysqli_connect($sname, $unmae, $password, $db_name);

                if (!$conn) {
                    echo "Connection failed!";
                }

                // Retrieve data from the database
                $sql = "SELECT * FROM patients";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Display data in the table rows
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["number"] . '</td>';
                        echo '<td>' . $row["age"] . '</td>';
                        echo '<td>' . $row["gender"] . '</td>';
                        echo '<td>' . $row["email"] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No data found.</td></tr>';
                }

                // Close the database connection
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


</div>


</body>

</html>

<?php 

}else{

     header("Location: index.php");

     exit();

}

 ?>