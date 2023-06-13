

<!DOCTYPE html>

<html>

<head>

    <title>List</title>

    <link rel="stylesheet" type="text/css" href="Dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


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

    
    <h1>Pharmacy Product List</h1>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search">
        </div>
        <table id="productTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Info</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Action</th>
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
                    while ($row = $result->fetch_assoc()) {
                        $productId = $row['id'];
                        $medCode = $row['medCode'];
                        $medicineName = $row['medicineName'];
                        $productCategory = $row['productCategory'];
                        $productPrice = $row['productPrice'];

                        echo "<tr>";
                        echo "<td>$productId</td>";
                        echo "<td>$medCode <br> - $medicineName<br> ($productCategory)</td>";
                        echo "<td>$productCategory</td>";
                        echo "<td>$productPrice</td>";
                        echo "<td>";
                        echo "<button class='add-button' onclick='addProduct($medCode)'><i class='fas fa-plus'></i></button>";  
                        echo "<button class='delete-button' onclick='deleteProduct($medCode)'><i class='fas fa-trash'></i></button>";                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No products found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        
        <script>
        function addProduct(medCode) {
            // Add your logic to handle deleting the product
            // You can use JavaScript or make an AJAX request to the server
            console.log("Deleting product with ID " + productId);
        }

        function deleteProduct(medCode) {
           // Send an AJAX request to delete the product from the database
           var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Remove the table row when the product is successfully deleted
                    var row = document.getElementById("productRow_" + productId);
                    row.parentNode.removeChild(row);
                }
            };
            xhttp.open("GET", "delete_product.php?medCode=" + medCode, true);
            xhttp.send();
        }
        

        // Filter table rows based on search input
        document.getElementById("searchInput").addEventListener("keyup", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("productTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Index 1 corresponds to the Product Info column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
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



