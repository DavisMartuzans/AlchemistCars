<?php
session_start();
require_once('db_credentials.php');

// Retrieve the cars available for lease from the database
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

// Check if the user is logged in
$loggedIn = isset($_SESSION['username']);

// Process the lease request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $carId = $_POST['car_id'];
    $leaseDuration = $_POST['lease_duration'];
    $userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session

    // Insert the lease data into the leases table
    $sql = "INSERT INTO leases (car_id, user_id, duration) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $carId, $userId, $leaseDuration);
    $stmt->execute();

    // Check if the lease is successfully added
    if ($stmt->affected_rows > 0) {
        // Redirect to the lease success page or display a success message
        header("Location: leasing.php");
        exit();
    } else {
        // An error occurred, redirect back to the leasing page with an error message
        header("Location: leasing.php?error=1");
        exit();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Lease a Car</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
<header>
    <img src="Components/AlchemistCars.PNG" alt="Company Logo" id="logo">
    <nav>
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php
            if ($loggedIn) {
                if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') {
                    echo '<li><a href="parts.php">Parts</a></li>';
                    echo '<li><a href="sellcars.php">Sell Your Car</a></li>';
                    echo '<li><a href="leasing.php">Leasing</a></li>';
                }
                if ($_SESSION['role'] === 'admin') {
                    echo '<li><a href="admin_dashboard.php">Admin Dashboard</a></li>';
                }
                echo '<li><a href="logout.php">Logout</a></li>';
                echo '<li><a href="account.php">Account</a></li>';
            } else {
                echo '<li><a href="signin.php">Sign In</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Lease a Car</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="car-info">';
            echo '<img src="Components/' . $row['image'] . '" alt="' . $row['make'] . ' ' . $row['model'] . '">';
            echo '<h3>' . $row['make'] . ' ' . $row['model'] . '</h3>';
            echo '<p>Price: $' . $row['price'] . '</p>';
            echo '<p>Year: ' . $row['year'] . '</p>';
            echo '<p>Description: ' . $row['description'] . '</p>';

            if ($loggedIn) {
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="car_id" value="' . $row['id'] . '">';
                echo '<label for="lease_duration">Lease Duration:</label>';
                echo '<select name="lease_duration" id="lease_duration">';
                echo '<option value="1">1 Month</option>';
                echo '<option value="3">3 Months</option>';
                echo '<option value="6">6 Months</option>';
                echo '</select>';
                echo '<button type="submit" class="lease-button">Lease Now</button>';
                echo '</form>';
            } else {
                echo '<p>Please sign in to lease a car.</p>';
            }

            echo '</div>';
        }
    } else {
        echo '<p>No cars available for lease at the moment.</p>';
    }
    ?>
</div>

</body>
<style>
.container {
  max-width: 960px;
  margin: 0 auto;
  padding: 20px;
}

/* Leasing Page Styles */
.car-info {
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 20px;
}

.car-info img {
  width: 100%;
  height: auto;
}

.car-info h3 {
  margin-top: 10px;
  margin-bottom: 5px;
}

.car-info p {
  margin: 0;
}

.lease-button {
  display: inline-block;
  padding: 8px 16px;
  background-color: #333;
  color: #fff;
  text-decoration: none;
  border-radius: 4px;
  margin-top: 10px;
}

.lease-button:hover {
  background-color: #555;
}
</style>
</html>
