<?php
session_start();


if (!isset($_SESSION['customer_id'])) {
    header("Location: customer login.html");
    exit();
}

$customer_id = $_SESSION['customer_id'];

$conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $amount = $_POST["amount"];

    
    $sql = "INSERT INTO payments (customer_id, amount)
            VALUES ('$customer_id', '$amount')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert(' $amount ₹ Payment successful!');
                window.location.href = 'customer dashboard.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

?>
