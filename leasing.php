<?php
session_start();
require_once('db_credentials.php');

// Iegūst automašīnas, kas pieejamas nomai, no datubāzes
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

// Pārbauda, vai lietotājs ir pierakstījies
$loggedIn = isset($_SESSION['username']);

// Pārbauda, vai nomas forma ir iesniegta
if ($loggedIn && isset($_POST['car_id'], $_POST['lease_duration'])) {
    // Iegūst lietotāja ID no sesijas
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : '';

    // Iegūst automašīnas ID un nomas ilgumu no formas
    $carId = $_POST['car_id'];
    $leaseDuration = $_POST['lease_duration'];

    // Pārbauda, vai lietotāja ID pastāv lietotāju tabulā
    $verifySql = "SELECT id FROM users WHERE id = '$userId'";
    $verifyResult = $conn->query($verifySql);

    if ($verifyResult->num_rows > 0 && $userId !== '') {
        // Ievieto nomas informāciju datubāzē
        $insertSql = "INSERT INTO leases (car_id, user_id, duration) VALUES ('$carId', '$userId', '$leaseDuration')";
        if ($conn->query($insertSql) === TRUE) {
            echo "Noma veiksmīgi izveidota.";
        } else {
            echo "Kļūda, veidojot nomu: " . $conn->error;
        }
    } else {
        echo "Nederīgs lietotāja ID.";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>
<body>
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
                        // Priekš administrātora
                        if ($_SESSION['role'] === 'admin') {
                            echo '<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a></li>';
                        }
                        // Priekš lietotāja
                        echo '<li class="nav-item"><a class="nav-link" href="account.php">Account Settings</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    } else {
                        // Priekš vieša
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
                echo '<option value="12">12 Months</option>';
                echo '<option value="24">24 Months</option>';
                echo '<option value="36">36 Months</option>';
                echo '<option value="48">48 Months</option>';
                echo '<option value="60">60 Months</option>';
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
