<?php
session_start();

// If user is not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "aug9y3bg", "restaurant");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id'];

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST["name"];
    $guests = $_POST["guests"];
    $date = $_POST["date"];
    $time  = $_POST["time"];

    $sql = "INSERT INTO reservations (customer_id, full_name, guests, reservation_date, reservation_time)
            VALUES ('$customer_id', '$full_name', '$guests', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Reservation made successfully!');
                window.location.href = 'customer dashboard.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make New Reservation</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-image: url('sliced-carrots-bowl-vegetables-towel-blue-table (1).jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .reservation-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 300px;
        }

        h1 {
            text-align: center;
            color: #1256b8;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        button {
            width: 100%;
            background: #1877F2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1256b8;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #1877F2;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <form class="reservation-form" method="post" action="">
        <h1>Make a Reservation</h1>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>

        <label for="guests">Number of Guests</label>
        <select id="guests" name="guests" required>
            <option value="">Select guests</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6+</option>
        </select>

        <label for="date">Date</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Time</label>
        <input type="time" id="time" name="time" required>

        <button type="submit">Confirm Reservation</button>

        <a href="customer dashboard.php" class="back-link">← Back to Dashboard</a>
    </form>
</body>

</html>
