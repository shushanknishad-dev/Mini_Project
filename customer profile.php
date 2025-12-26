
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>

  <style>
   

    body {
      margin: 0;
      font-family:  sans-serif;
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

  
    

    button {
      background: #1877F2;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover { background:#005dcf; }


   
   
     .profile-container{
            background:white;
            width: 300px;
            padding:20px;
            border: 2px solid black;
            border-radius:10px;
            
          
        }

        .logout{
          display: flex;
          justify-content: center;
          align-items: center;
          text-align: center;
          text-decoration: none;

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
  $sql = "SELECT * FROM customers WHERE id='$customer_id'";
  $result = $conn->query($sql);
  $user = $result->fetch_assoc();
  $username = $user['username'];
  $email    = $user['email'];
  $phone    = $user['phone'];
  ?>
  <div class="sidebar">
    <h2>Customer Panel</h2>
    <a href="customer dashboard.php" class="active"> Dashboard</a>
    <a href="customer reservation.php"> My Reservations</a>
    <a href="payment.html"> Payments</a>
    <a href="#"> Profile</a>
    <a href="help.html"> Help</a>
</div>

  <div class="main">

 
    <div class="header">
      <h1></h1>


      <a href="make new reservation.php">
        <button> Make New Reservation</button>
      </a>
    </div>




    
   
    <div class="profile-container">
      <h2>My Profile</h2>

      <p><b>Username:</b> <?php echo $username; ?> </p>
      <p><b>Email:</b> <?php echo $email; ?></p>
      <p><b>Phone:</b> <?php echo $phone; ?> </p>
      <a class="logout" onclick="message()" href="role.html"> <button>
           Logout
      </button></a>
    </div>
     

  </div>
  <script>
  function message(){
    alert("Logged out successfully!");
  }
  </script>
  

</body>
</html>

