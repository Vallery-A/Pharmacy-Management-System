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
    // Retrieve the patient data from the form
    $number = $_POST["number"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $location = $_POST["location"];
    $gender = $_POST["gender"];

    // Insert the patient data into the database
    $sql = "INSERT INTO patients (number, name, age, email, location, gender)
            VALUES ('$number', '$name', '$age', '$email', '$location', '$gender')";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the form after successful insertion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error adding patient: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>

<html>

<head>

    <title>Add Patient</title>

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

    
    <h1>Add Patients</h1>
    
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
        <label for="number">Phone Number:</label>
        <input type="text" id="number" name="number" required>
    </div>

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="age">Age:</label>
        <input type="text" id="age" name="age" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
    </div>

    <div class="form-group">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>

    <button type="submit" class="button button-primary">Add Patient</button>
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
