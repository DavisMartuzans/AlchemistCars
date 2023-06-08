<?php
session_start();
require_once('db_credentials.php');

// Check if car ID is provided in the URL
if (!isset($_GET['id'])) {
    // If car ID is missing, redirect back to the cars page
    header("Location: cars.php");
    exit();
}

// Retrieve the car details from the database using the provided ID
$carId = $_GET['id'];
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $carId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the car data
if ($result->num_rows === 0) {
    // If no car found with the given ID, redirect back to the cars page
    header("Location: cars.php");
    exit();
}

$car = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Details - <?php echo $car['make'] . ' ' . $car['model']; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<header>
  <img src="Components/AlchemistCars.PNG" alt="Company Logo" id="logo">
  <nav>
    <ul>
      <li><a href="main.php">Home</a></li>
      <li><a href="contact.php">Contact</a></li>
      <?php
      if(isset($_SESSION['username'])) {
          if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') {
              echo '<li><a href="parts.php">Parts</a></li>';
              echo '<li><a href="sellcars.php">Sell Your Car</a></li>';
              echo '<li><a href="leasing.php">Leasing</a></li>';
          }
          if($_SESSION['role'] === 'admin') {
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
<body>
    <div class="container">
        <h2>Car Details - <?php echo $car['make'] . ' ' . $car['model']; ?></h2>
        <div class="car-info">
            <img src="Components/<?php echo $car['image']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>">
            <h3><?php echo $car['make'] . ' ' . $car['model']; ?></h3>
            <p>Price: $<?php echo $car['price']; ?></p>
            <p>Year: <?php echo $car['year']; ?></p>
            <p>Description: <?php echo $car['description']; ?></p>
        </div>
    </div>
    <style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.car-info {
  max-width: 600px;
  padding: 30px;
  background-color: #fff;
  margin: 30px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
}

.car-info h2 {
  font-size: 24px;
  margin-bottom: 10px;
}

.car-info img {
  width: 100%;
  max-height: 400px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 20px;
}

.car-info h3 {
  font-size: 20px;
  margin-bottom: 10px;
}

.car-info p {
  font-size: 16px;
  margin-bottom: 8px;
}

.car-info p:last-child {
  margin-bottom: 0;
}

.car-info p span {
  font-weight: bold;
}

.car-info p.description {
  margin-top: 15px;
}

@media (max-width: 768px) {
  .container {
    padding: 20px;
  }
}
    </style>
</body>
</html>
