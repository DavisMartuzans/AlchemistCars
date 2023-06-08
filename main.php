<?php
session_start();
require_once('db_credentials.php');

// Retrieve the sold cars from the database
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

// Store the fetched car data in an array
$cars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Create the details_url using the car's ID
        $details_url = "car_details.php?id=" . $row['id'];
        $row['details_url'] = $details_url;
        $cars[] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>AlchemistCars</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
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
  <h2 class="welcome">Welcome to AlchemistCars</h2>
  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
      // Display additional features for signed-in users
      echo '<p class="about">You are logged in as ' . $_SESSION['username'] . '</p>';
      echo '<p class="about">Here you can find a variety of awesome cars.</p>';
      echo '<p class="about">If you find anything you like, contact us and meet us.</p>';
      // Display additional content or features for logged-in users
  } else {
      // Show generic content for non-logged-in users
      echo '<p class="about">Here you can find a variety of awesome cars.</p>';
      echo '<p class="about">If you find anything you like, please sign in to access additional features.</p>';
  }
  ?>
<ul id="carList">
    <?php
    foreach ($cars as $car) {
        echo '<div class="card">';
        echo '<img src="Components/' . $car['image'] . '" alt="' . $car['make'] . ' ' . $car['model'] . '" style="width:100%">';
        echo '<h3>' . $car['make'] . ' ' . $car['model'] . '</h3>';
        echo '<p class="title">Make: ' . $car['make'] . '</p>';
        echo '<p>Model: ' . $car['model'] . '</p>';
        echo '<p>Year: ' . $car['year'] . '</p>';
        echo '<p>Price: $' . $car['price'] . '</p>';
        echo '<a href="' . $car['details_url'] . '"><button class="learn-more">Learn More</button></a>';
        echo '</div>';
    }
    ?>
</ul>
  <style>
    /* Welcome */
    .welcome {
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 30px;
      text-align: center;
      margin-bottom: 20px;
    }

    .about {
      font-size: 20px;
      text-align: center;
      margin-bottom: 20px;
    }

    /* Car filter*/
    .car-filter {
      margin: 0 auto;
      max-width: 600px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .car-filter form {
      display: flex;
      flex-wrap: wrap;
    }

    .car-filter label {
      flex-basis: 100%;
    }

    .car-filter select,
    .car-filter input[type="submit"] {
      margin: 10px 0;
      padding: 5px;
      border-radius: 5px;
    }

    .car-filter select {
      flex-basis: calc(33.33% - 10px);
    }

    .car-filter input[type="submit"] {
      flex-basis: 100%;
      background-color: #454545;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    .car-filter input[type="submit"]:hover {
      background-color: #454545;
    }

    .filterButton {
      width: 100%;
      padding: 10px;
      background-color: #454545;
      color: white;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .filterButton:hover {
      background-color: #000;
    }

    /* car cards */
    .card {
      width: 300px;
      height: 400px;
      box-shadow: 2px 2px 5px #ccc;
      border-radius: 10px;
      overflow: hidden;
      margin: 10px;
      display: inline-block;
    }

    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .card h3 {
      margin: 10px;
      font-size: 18px;
    }

    .card p {
      margin: 10px;
      font-size: 14px;
    }

    .learn-more {
      width: 100%;
      padding: 10px;
      background-color: #454545;
      color: white;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .learn-more:hover {
      background-color: #000;
    }
  </style>
</body>
</html>
