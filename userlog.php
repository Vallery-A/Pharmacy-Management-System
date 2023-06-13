
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

    
    <h2>Log Activity </h2>

  <form method="POST">
    <input type="text" name="search" placeholder="Search by User Name">
    <input type="submit" value="Search">
  </form>

  <?php
  // Database connection details
  $sname= "localhost";
  $unmae= "root";
  $password = "";

  $db_name = "Pharmacy_db";

  // Create a connection
  $conn = new mysqli($sname, $unmae, $password, $db_name);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if search form submitted
  if (isset($_POST['search'])) {
    $search = $_POST['search'];
    // Prepare a SQL statement to retrieve filtered data
    $stmt = $conn->prepare("SELECT * FROM user_logs WHERE username LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
  } else {
    // Prepare a SQL statement to retrieve all data
    $result = $conn->query("SELECT * FROM user_logs");
  }

  if ($result->num_rows > 0) {
    echo '<table>
          <tr>
            <th>User Name</th>
            <th>Activity</th>
            <th>Activity Time</th>
          </tr>';
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
      echo '<tr>
              <td>' . $row["username"] . '</td>
              <td>' . $row["activity"] . '</td>
              <td>' . $row["activity_time"] . '</td>
            </tr>';
    }
    echo '</table>';
  } else {
    echo 'No results found.';
  }

  // Close the connection
  $conn->close();
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

