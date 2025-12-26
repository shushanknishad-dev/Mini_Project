<?php
session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: employee login.html");
    exit();
}


$reservation_id = $_POST['reservation_id'];

$conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    $sql = "DELETE FROM reservations WHERE reservation_id = $reservation_id ";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Reservation cancelled successfully!');
                window.location.href = 'employee dashboard.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

?>