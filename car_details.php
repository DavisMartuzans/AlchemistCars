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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="index.php">AlchemistCars</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contacts</a>
      </li>
      <?php
            if (isset($_SESSION['username'])) {
                if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') {
                    echo '<li class="nav-item"> <a class="nav-link" href="parts.php">Parts</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="sellcars.php">Sell Your Car</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="leasing.php">Leasing</a></li>';
                }
            }
            ?>
      
      
   <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
        if (isset($_SESSION['username'])) {
                        // For admin content in the header
                        if ($_SESSION['role'] === 'admin') {
                            echo '<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a></li>';
                        }
                        // For signed-in in users
                        echo '<li class="nav-item"><a class="nav-link" href="account.php">Account Settings</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    } else {
                        // For not signed-in users
                        echo '<li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>';
                    }
        ?>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

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
