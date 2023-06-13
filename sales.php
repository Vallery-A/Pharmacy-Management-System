

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

    
    <h1>Medicine Order Form</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <label for="customer">Customer Name:</label>
        <select name="customer" id="customer" required>
        <option value="">Choose customer</option>

            <?php
            // Connect to the database
            $sname= "localhost";
            $unmae= "root";
            $password = "";
            $db_name = "Pharmacy_db";

            $conn = mysqli_connect($sname, $unmae, $password, $db_name);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch customer names from the database
            $sql = "SELECT name FROM patients";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $name = $row['name'];
                    echo "<option value='$name'>$name</option>";
                }
            } else {
                echo "<option value=''>No customers found</option>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </select>

        <br><br>

        <label for="medicine">Medicine Ordered:</label>
        <select name="medicine" id="medicine" onchange="fetchMedicinePrice()" required>
            <option value="">Select Medicine</option>
            <?php
            // Connect to the database
            $sname= "localhost";
            $unmae= "root";
            $password = "";
            $db_name = "Pharmacy_db";

            $conn = mysqli_connect($sname, $unmae, $password, $db_name);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch medicine names from the database
            $sql = "SELECT medicineName FROM pharm_stock";
            $result = mysqli_query($conn, $sql);
            
            // Create dropdown options for medicine names
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['medicineName'] . "'>" . $row['medicineName'] . "</option>";
            }


           // Close the database connection
            mysqli_close($conn);
            ?>
        </select>

        <br><br>

        <label for="price">Price:</label>
        <input type="text" name="price" id="price" readonly>

        <br><br>

        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity">

        <br><br>

        <label for="cashier">Cashier Name:</label>
        <input type="text" name="cashier" id="cashier">

        <br><br>

        <label for="payment">Payment Method:</label>
        <select id="payment" name="payment" required>
                <option value="">Select a payment method</option>
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Mobile Payment">Mobile Payment</option>
            </select>

        <br><br>

        <input type="submit" value="Submit">
        <button type="button" onclick="printReceipt()">Print Receipt</button>

    </form>

    <h2>Medicine Order List</h2>
    <table>
        <tr>
            <th>Customer Name</th>
            <th>Medicine Ordered</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Cashier Name</th>
            <th>Payment Method</th>
        </tr>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $customer = $_POST['customer'];
            $medicine = $_POST['medicine'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $cashier = $_POST['cashier'];
            $payment = $_POST['payment'];

            // Connect to the database
            $sname= "localhost";
            $unmae= "root";
            $password = "";
            $db_name = "Pharmacy_db";

            $conn = mysqli_connect($sname, $unmae, $password, $db_name);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }


            // Get the available stock quantity for the selected medicine
            $stockSql = "SELECT stockVolume FROM pharm_stock WHERE medicineName = '$medicine'";
            $stockResult = mysqli_query($conn, $stockSql);
            $stockRow = mysqli_fetch_assoc($stockResult);
            $stockQuantity = $stockRow['stockVolume'];

            // Check if there is sufficient stock available
            if ($quantity > $stockQuantity) {
                echo "Insufficient stock!";
            } else {
                // Insert the order into the database
                $sql = "INSERT INTO sales (customerName, orderName, price, quantity, cashierName, paymentMethod) VALUES ('$customer', '$medicine', '$price', '$quantity', '$cashier', '$payment')";
                
                if (mysqli_query($conn, $sql)) {
                echo "Order added successfully!";
                    $stockOut = $stockQuantity - $quantity;

                    // Update the stock quantity in the database
                    $updateStockSql = "UPDATE pharm_stock SET stockVolume = '$stockOut' WHERE medicineName = '$medicine'";
                    mysqli_query($conn, $updateStockSql);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }

            // Close the database connection
            mysqli_close($conn);
        }

        // Connect to the database
        $sname= "localhost";
        $unmae= "root";
        $password = "";
        $db_name = "Pharmacy_db";

        $conn = mysqli_connect($sname, $unmae, $password, $db_name);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch orders from the database
        $sql = "SELECT * FROM sales";
        $result = mysqli_query($conn, $sql);

        // Create table rows for orders
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['customerName'] . "</td>";
            echo "<td>" . $row['orderName'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['cashierName'] . "</td>";
            echo "<td>" . $row['paymentMethod'] . "</td>";
            echo "</tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>

    <script>
        function fetchMedicinePrice() {
            var medicine = document.getElementById("medicine").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("price").value = this.responseText;
                }
            };
            xhttp.open("GET", "get_medicine_price.php?medicine=" + medicine, true);
            xhttp.send();
        }

        function printReceipt() {
            var customer = document.getElementById("customer").value;
            var medicine = document.getElementById("medicine").value;
            var price = document.getElementById("price").value;
            var quantity = document.getElementById("quantity").value;
            var cashier = document.getElementById("cashier").value;
            var payment = document.getElementById("payment").value;

            var receiptWindow = window.open('', '_blank');
            var receiptContent =  "<h2>Receipt</h2>" +
            "<p><strong>Customer Name:</strong> " + customer + "</p>" +
            "<p><strong>Medicine Ordered:</strong> " + medicine + "</p>" +
            "<p><strong>Price:</strong> " + price + "</p>" +
            "<p><strong>Quantity:</strong> " + quantity + "</p>" +
            "<p><strong>Cashier Name:</strong> " + cashier + "</p>" +
            "<p><strong>Payment Method:</strong> " + payment + "</p>";

            receiptWindow.document.open();
            receiptWindow.document.write(receiptContent);
            receiptWindow.document.close();
            receiptWindow.print();}
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

