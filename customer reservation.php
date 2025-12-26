<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reservation Portal</title>

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-color: var(--light-bg);
            display: flex;
            min-height: 100vh;
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
            margin-bottom:20px;
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
            padding: 30px;
            flex: 1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }




        .make-new-reservation{
            background: #1877F2;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .make-new-reservation:hover {
            background: #005dcf;
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
        .cancle-row{
            display:flex;
            gap:12px;
            align-items:center;
        }
        .cancle-button{
            background: red;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
        }   
      
        
    </style>
</head>

<body>

    <?php
    session_start();

    // If user is not logged in
    if (!isset($_SESSION['customer_id'])) {
        header("Location: customer login.html");
        exit();
    }

    $customer_id = $_SESSION['customer_id'];

    $conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");
// Fetch reservation for this customer
    $sql = "SELECT * FROM reservations WHERE customer_id = $customer_id";
    $result = $conn->query($sql);

    // print all reservation details
    ?>
    <div class="sidebar">
        <h2>Customer Panel </h2>
        <a href="customer dashboard.php" class="active"> Dashboard</a>
        <a href="customer reservation.php"> My Reservations</a>
        <a href="payment.html"> Payments</a>
        <a href="customer profile.php"> Profile</a>
        <a href="help.html"> Help</a>
    </div>

    <div class="main">

        <!-- HEADER -->
        <div class="header">
            <h1>My reservations</h1>


            <a href="make new reservation.php">
                <button class="make-new-reservation"> Make New Reservation</button>
            </a>
        </div>

        <!-- RESERVATION TABLE -->
        <h2>Your Reservation History</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Seats</th>
                <th>Status</th>
                <th>Time</th>
            </tr>
            
             <!-- if($result && $result->num_rows>0){ -->
            
          
            <?php if( $result->num_rows>0){?>
            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['reservation_date']; ?></td>
                    <td><?php echo $row['guests']; ?></td>
                    <td class="cancle-row"><span class="status"><?php echo $row['status']; ?>
                  </span> <form action="customer cancel reservation.php" method="POST">
                 <input type="hidden" name="reservation_id" value="<?php echo $row['reservation_id']; ?>">
                 <button class="cancle-button" type="submit" name="cancel-button"> Cancel</button>
</form>
</td>
                    <td><?php echo $row['reservation_time']; ?></td>
                </tr>
            <?php }?>
        <?php } else { ?>
                <tr>
                    <td colspan="4">No reservations found.</td>
                </tr>
            <?php } ?>
        </table>

    </div>
</body>

</html>