<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Management System - Sign Up</title>
    <link rel="stylesheet" type="text/css" href="Dash.css">
</head>
<body>
    <div class="containersign">
        <h2>Sign Up</h2>
        <form method="POST" action="signup.php">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email Address" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="text" name="pharmacy_name" placeholder="Pharmacy Name" required><br>
            <button type="submit" name="signup">Sign Up</button>
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Pharmacy Management System. All rights reserved.</p>
    </footer>

</body>
</html>

<?php
// Database configuration
$sname= "localhost";
$unmae= "root";
$password = "";

$db_name = "Pharmacy_db";

// Create a database connection
$conn = new mysqli($sname, $unmae, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signup'])) {
     // Retrieve user input from the form
     $name = $_POST['name'];
     $email = $_POST['email'];
     $password = $_POST['password'];
     $pharmacyName = $_POST['pharmacy_name'];
 
 
     // Save the user details to the database
     $sql = "INSERT INTO users (user_name, email, password, pharmacy_name) VALUES ('$name', '$email', '$password', '$pharmacyName')";

    if ($conn->query($sql) === TRUE) {
        // User details saved successfully
        $verificationCode = generateVerificationCode(); // Generate a verification code
        $verificationLink = "https://yourdomain.com/verify.php?code=$verificationCode"; // Construct the verification link

        // Send the email with the verification link to the user's email address
        $subject = "Account Verification - Pharmacy Management System";
        $message = "Dear $name,\n\nPlease click the following link to verify your account:\n$verificationLink";
        $headers = "From: your-email@example.com"; // Set the appropriate sender email address

        if (mail($email, $subject, $message, $headers)) {
            // Email sent successfully
            echo "Thank you for signing up! An account verification email has been sent to your email address.";
        } else {
            // Error sending email
            echo "Oops! An error occurred while sending the verification email. Please try again later.";
        }
    } else {
        // Error saving user details to the database
        echo "Oops! An error occurred while signing up. Please try again later.";
    }
}

// Function to generate a random verification code
function generateVerificationCode() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < 10; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

// Close the database connection
$conn->close();
?>
