<?php
$servername = "localhost";
$username = "root";
$password = "aug9y3bg";
$db = "restaurant";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST["username"];
$pass = $_POST["password"];
$email = $_POST["email"];
$mob  = $_POST["mobile"];

$sql = "INSERT INTO customers (username, email, phone, password)
        VALUES ('$user', '$email', '$mob', '$pass')";

if ($conn->query($sql) === TRUE) {
    // echo "Registered successfully!";
    session_start();
    $_SESSION['customer_id'] = $conn->insert_id;
    echo "<script>alert('Signup successful!');</script>";
   echo "<script>window.location.href = 'customer dashboard.php';</script>";
    
} else {
    
    echo "Error: ". $conn->error;
}

$conn->close();
?>
