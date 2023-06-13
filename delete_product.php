<?php
// Handle the AJAX request to delete the product from the database
if (isset($_GET['medCode'])) {
    $medCode = $_GET['medCode'];

    // database operations to delete the product
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "Pharmacy_db";
    
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);
    
    if (!$conn) {

    echo "Connection failed!";

}

    // Delete the product from the database
    $sql = "DELETE FROM pharm_stock WHERE medCode = $medCode";
    $result = $conn->query($sql);

    if ($result) {
        echo "Product with ID $medCode successfully deleted.";
    } else {
        echo "Error deleting product with ID $medCode: " . $conn->error;
    }

    $conn->close();
} else {
    // Send an error response if the product ID is not provided
    echo "Invalid request. Product ID not provided.";
}
?>
