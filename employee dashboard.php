<?php
session_start();

// If user is not logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: employee login.html");
    exit();
}

// Get logged in user ID
$employee_id = $_SESSION['employee_id'];

// Example: Fetch customer info
$conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");

$sql = "SELECT * FROM employees WHERE id = $employee_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$username = $user['username'];
?>
    
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Restaurant Dashboard</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial;
        }

        body{
            display:flex;
            background:#f3f3f3;
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

        .sidebar a:hover,
        .sidebar a.active{
            background:#005dcf;
        }

        .main{
            margin-left:250px;
            padding:25px;
            width:100%;
           
        }

        h1{
            margin-bottom:10px;
        }

        /* button{
            background:#1877F2;
            padding:10px 15px;
            border:none;
            border-radius:6px;
            cursor:pointer;
            margin-left: 1000px;
        } */

        /* button a{
            color:white;
            text-decoration:none;
            font-weight:bold;
        } */

   
        .stats{
            display:flex;
            gap:20px;
            margin:25px 0;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:10px;

            width:200px;
            margin-bottom: 20px;
        }

        .card h3{
            margin-bottom:10px;
        }

        
        table{
            width:100%;
            background:white;
            border:1px solid whitesmoke;
            border-radius: 10px;
            
            margin-bottom:30px;
         
        }

        th, td{
            padding:12px 15px;
            border-bottom:1px solid #ddd;
            text-align:left;
        }

        th{
            background:#1877F2;
            color:white;
        }

        
        .profile-container{
            background:white;
            padding:20px;
            border-radius:10px;
          
        }

        .profile-container p{
            margin:8px ;
        }
        h2{
            margin-bottom:15px; 

        }
        .status{
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
        .cancel-button{
           
            background-color:red;
            color: white;
          padding: 8px 14px;
            border: none;
            border-radius: 6px;
        }
      

    </style>
</head>

<body>

<div class="sidebar">
    <h2>Customer Panel</h2>
    <a href="employee dashboard.php" class="active">Dashboard</a>
  
    <!-- <a href="payment.html">Payments</a> -->
     <a href="employee profile.php">profile</a>
   
    <a href="help.html">Help</a>
</div>

<div class="main">
    <h1>Welcome , <?php echo $username; ?></h1>

    <!-- <button>
        <a href="make new reservation.html">+ Make a New Reservation</a>
    </button> -->
      <?php
            $count_sql = "SELECT COUNT(*) as total FROM reservations";
            $count_result = $conn->query($count_sql);
            $count_row = $count_result->fetch_assoc();
            $total_reservations = $count_row['total'];
            ?>
   
    <div class="stats">
        <div class="card">
            <h3>Total Reservations</h3>
            <p><?php echo $total_reservations; ?></p>
        </div>

             <?php
            $payment_sql = "SELECT SUM(amount) as total_payments FROM payments";
            $payment_result = $conn->query($payment_sql);
            $payment_row = $payment_result->fetch_assoc();
            $total_payments = $payment_row['total_payments'];
            ?>
            
         <div class="card">
            <h3>Total Earning</h3>
            <p><?php if($total_payments==0){
                    echo "₹ 0.00";
                }
                else{
                     echo "₹ $total_payments";
                } ?></p>
        </div>


       
    </div>



    <h2>All Reservations</h2>

    <?php
    $sql = "SELECT * FROM reservations";
    $result = $conn->query($sql);

    ?>
   

    <table>
    

        <tr>
            <th> </th>
            <th>Seats</th>
            <th>Status</th>
            <th>Time</th>
        </tr>
    <?php if ($result && $result->num_rows > 0) { ?>
                <?php while($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['reservation_date']; ?></td>
                        <td><?php echo $row['guests']; ?></td>
                        <td class="cancle-row"><span class="status"><?php echo $row['status']; ?></span>
                    <form action="employee cancel reservation.php" method="POST">
                 <input type="hidden" name="reservation_id" value="<?php echo $row['reservation_id']; ?>">
                 <button class="cancel-button" type="submit" name="cancel-button"> Cancel</button>
                </form></td>
                        <td><?php echo $row['reservation_time']; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No reservations found.</td>
                </tr>
            <?php } ?>
        </table>

</div>

</body>
</html> 