<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer login.html");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$reservation_id = $_POST['reservation_id'];

$conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    $sql = "DELETE FROM reservations WHERE reservation_id = $reservation_id AND customer_id = $customer_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Reservation cancelled successfully!');
                window.location.href = 'customer reservation.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

?>
