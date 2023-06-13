

<!DOCTYPE html>

<html>

<head>

    <title>Stocks</title>

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

    

    <h1>Inventory Table</h1> <br><br>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by product name">
        </div>
        <table id="inventoryTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Expired</th>
                    <th>Stock Available</th>
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

                $sql = "SELECT * FROM pharm_stock";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $rowNumber = 1;
                    while ($row = $result->fetch_assoc()) {
                        $medicineName = $row['medicineName'];
                        $stockVolume = $row['stockVolume'];
                        $expiryDate = $row['expiryDate'];

                        $stockAvailable = $stockVolume ;
                        $expired = strtotime($expiryDate) < strtotime(date("Y-m-d")) ? 'Expired' : 'Not Expired';

                        echo "<tr>";
                        echo "<td>$rowNumber</td>";
                        echo "<td>$medicineName</td>";
                        echo "<td>$expired</td>";
                        echo "<td>$stockAvailable</td>";
                        echo "</tr>";

                        $rowNumber++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No inventory records found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        //  search functionality
        var searchInput = document.getElementById("searchInput");
        var inventoryTable = document.getElementById("inventoryTable");
        var rows = inventoryTable.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            var searchValue = searchInput.value.toUpperCase();

            for (var i = 0; i < rows.length; i++) {
                var productName = rows[i].getElementsByTagName("td")[1];

                if (productName) {
                    var productNameText = productName.textContent || productName.innerText;

                    if (productNameText.toUpperCase().indexOf(searchValue) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        });
    </script>
    
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

