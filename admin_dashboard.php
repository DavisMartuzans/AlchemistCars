<?php
// Check if the user is logged in and is an admin
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

require_once('db_credentials.php');

// Delete a car card
if (isset($_POST['delete_car'])) {
    $carId = $_POST['car_id'];
    
    // Prepare and execute SQL statement to delete the car card
    $stmt = $conn->prepare("DELETE FROM car_cards WHERE id = ?");
    $stmt->bind_param("i", $carId);
    
    if ($stmt->execute()) {
        // Car card deleted successfully
        echo "Car card deleted!";
    } else {
        echo "Error deleting car card: " . $stmt->error;
    }
    
    $stmt->close();
}

// Delete a user
if (isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];
    
    // Prepare and execute SQL statement to delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        // User deleted successfully
        echo "User deleted!";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
    
    $stmt->close();
}

// Get car cards
$query = "SELECT * FROM car_cards";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Admin Dashboard</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
  <h2>Admin Dashboard</h2>
  
  <h3>Car Cards</h3>
  <?php
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          ?>
          <div class="card">
            <img src="<?php echo $row['image_url']; ?>" alt="Car" style="width:100%">
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            <form action="" method="POST">
              <input type="hidden" name="car_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="delete_car">Delete</button>
            </form>
          </div>
          <?php
      }
  } else {
      echo "No car cards found.";
  }
  ?>
  
  <h3>Users</h3>
  <?php
  // Get users
  $query = "SELECT * FROM users";
  $result = $conn->query($query);
  
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
