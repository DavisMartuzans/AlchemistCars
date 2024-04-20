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

<?php include 'includes/navbar.php'; ?>

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
