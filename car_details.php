<?php
session_start();

require_once('db_credentials.php');

// Pārbauda, vai cars ID ir nodots URL
if (!isset($_GET['id'])) {
    // Ja cars ID nav norādīts, novirza automašīnu lapu
    header("Location: cars.php");
    exit();
}

// Iegūst automašīnas datus no datubāzes, izmantojot norādīto ID
$carId = $_GET['id'];
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $carId);
$stmt->execute();
$result = $stmt->get_result();

// Iegūst automašīnas datus
if ($result->num_rows === 0) {
    // Ja nekāda automašīna nav atrasta ar norādīto ID, novirza uz automašīnu lapu
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>

<?php include 'includes/navbar.php'; ?>

<body>
    <div class="container">
        <h2>Car Details - <?php echo $car['make'] . ' ' . $car['model']; ?></h2>
        <div class="car-info">
            <img src="Components/<?php echo $car['image']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>">
            <h3><?php echo $car['make'] . ' ' . $car['model']; ?></h3>
            <p>Price: $<?php echo $car['price']; ?></p>
            <p>Year: <?php echo $car['year']; ?></p>
            <p>Description: <?php echo $car['description']; ?></p>

            <a href="rent.php?id=<?php echo $carId; ?>" class="rent-button">Rent</a>
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
