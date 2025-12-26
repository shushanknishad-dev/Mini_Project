<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST["email"];
$pass  = $_POST["password"];

$sql = "SELECT * FROM customers WHERE email='$email' AND password='$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $user = $result->fetch_assoc();
    
 
    $_SESSION['customer_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    // echo "Login 
    successful! Welcome, " . $user['username'];
    // header("Location: customer dashboard.php");
    echo "<script>alert('Login successful! Welcome, " . $user['username'] . "');</script>";
    echo "<script>window.location.href = 'customer dashboard.php';</script>";
 
    exit();

  
}
else {
    echo"<script>alert('Invalid email or password.')</script>";
    echo "<script>window.location.href = 'customer login.html';</script>";

           
}

$conn->close();
?>
