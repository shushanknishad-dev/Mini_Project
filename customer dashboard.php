<?php
session_start();

// If user is not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer login.html");
    exit();
}

// Get logged in user ID
$customer_id = $_SESSION['customer_id'];

// Example: Fetch customer info
$conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");

$sql = "SELECT * FROM customers WHERE id = $customer_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$username = $user['username'];
$email    = $user['email'];
$phone    = $user['phone'];

$sql = "SELECT * FROM reservations WHERE customer_id = $customer_id";
$result = $conn->query($sql);


// echo "Welcome, " . $user['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial;
        }

        body {
            display: flex;
            background: #f3f3f3;
        }

    .sidebar{
            height:100vh;
            width:250px;
            background:#1877F2;
            padding-top:20px;
            position:fixed;
            left:0;
            top:0;
        }

        .sidebar h2{
            color:white;
            text-align:center;
            margin-top:25px;
            margin-bottom: 10px;
            
        }

        .sidebar a{
            display:block;
            padding:15px 20px;
            color:white;
            text-decoration:none;
        }

        .sidebar a:hover{
            background:#005dcf;
        }


        .main {
            margin-left: 250px;
            padding: 25px;
            width: 100%;

        }

        h1 {
            margin-bottom: 10px;
        }

        button {
            background: #1877F2;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 1200px;
        }

        button a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }


        .stats {
            display: flex;
            gap: 20px;
            margin: 25px 0;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;

            width: 200px;
            margin-bottom: 20px;
        }

        .card h3 {
            margin-bottom: 10px;
        }


        table {
            width: 100%;
            background: white;
            border: 1px solid whitesmoke;
            border-radius: 10px;

            margin-bottom: 30px;

        }

        th,
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1877F2;
            color: white;
        }


        .profile-container {
            background: white;
            padding: 20px;
            border-radius: 10px;

        }

        .profile-container p {
            margin: 8px;
        }


        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            background-color: #28a745;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Customer Panel</h2>
        <a href="customer dashboard.php" class="active">Dashboard</a>
        <a href="customer reservation.php">My Reservations</a>
        <a href="payment.html">Payments</a>
        <a href="customer profile.php">Profile</a>
        <a href="help.html">Help</a>
    </div>

    <div class="main">
        <h1><?php echo "Welcome, " . $user['username']; ?></h1>

        <button>
            <a href="make new reservation.php">+ Make a New Reservation</a>
        </button>

        <div class="stats">
            <!-- counting total reservations -->
            <?php
            $count_sql = "SELECT COUNT(*) as total FROM reservations WHERE customer_id = $customer_id";
            $count_result = $conn->query($count_sql);
            $count_row = $count_result->fetch_assoc();
            $total_reservations = $count_row['total'];
            ?>
            <div class="card">
                <h3>Total Reservations</h3>
                <p><?php echo $total_reservations; ?></p>
            </div>
           
            <!-- calculating total payments -->
            <?php
            $payment_sql = "SELECT SUM(amount) as total_payments FROM payments WHERE customer_id = $customer_id";
            $payment_result = $conn->query($payment_sql);
            $payment_row = $payment_result->fetch_assoc();
            $total_payments = $payment_row['total_payments'];
            ?>
            <div class="card">
                <h3> Total Payments </h3>
                <p><?php 
                // echo "₹" .$total_payments; 
                if($total_payments==0){
                    echo "₹ 0.00";
                }
                else{
                     echo "₹ $total_payments";
                }
                ?></p>
            </div>
        </div>

        <h2>My Reservations</h2>

        <table>
            <tr>
                <th>Date</th>
                <th>Seats</th>
                <th>Status</th>
                <th>Time</th>
            </tr>
            <?php if ($result && $result->num_rows > 0) { ?>
                <?php for ($i = 0; $i < 4; $i++) {
                    $row = $result->fetch_assoc();
                    if(!$row) break;
                ?>
                    <tr>
                        <td><?php echo $row['reservation_date']; ?></td>
                        <td><?php echo $row['guests']; ?></td>
                        <td><span class="status"><?php echo $row['status']; ?></span></td>
                        <td><?php echo $row['reservation_time']; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No reservations found.</td>
                </tr>
            <?php } ?>
        </table>

        <div class="profile-container">
            <h2>My Profile</h2>
            <p><b><?php echo "Username: " . $user['username']; ?></b> </p>
            <p><b><?php echo "Email: " . $user['email']; ?></b> </p>
            <p><b><?php echo "Phone: " . $user['phone']; ?></b> </p>

        </div>

    </div>

</body>

</html>