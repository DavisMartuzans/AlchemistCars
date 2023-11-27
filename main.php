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
    <title>Welcome to AlchemistCars</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
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
    <a class="navbar-brand" href="main.php">AlchemistCars</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="main.php">Home</a>
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
<h2 id="welcome">Welcome to AlchemistCars</h2>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // For signed-in users
    echo '<p class="about">You are logged in as ' . $_SESSION['username'] . '</p>';
    echo '<p class="about">Here you can find a variety of awesome cars.</p>';
    echo '<p class="about">If you find anything you like, contact us and meet us.</p>';
    // Additional content for logged-in users
} else {
    // For non-logged-in users
    echo '<p class="about">Here you can find a variety of awesome cars.</p>';
    echo '<p class="about">If you find anything you like, please sign in to access additional features.</p>';
}
?>

<div id="car-filter">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <label for="make">Make:</label>
        <select id="make" name="make">
            <option value="">All Makes</option>
            <!-- Add options for available car makes from the database -->
            <?php
            $unique_makes = array_unique(array_column($cars, 'make'));
            foreach ($unique_makes as $make) {
                $selected = isset($_GET['make']) && $_GET['make'] === $make ? 'selected' : '';
                echo '<option value="' . $make . '" ' . $selected . '>' . $make . '</option>';
            }
            ?>
        </select>

        <label for="model">Model:</label>
        <select id="model" name="model">
            <option value="">All Models</option>
            <!-- Add options for available car models from the database -->
            <?php
            $unique_models = array_unique(array_column($cars, 'model'));
            foreach ($unique_models as $model) {
                $selected = isset($_GET['model']) && $_GET['model'] === $model ? 'selected' : '';
                echo '<option value="' . $model . '" ' . $selected . '>' . $model . '</option>';
            }
            ?>
        </select>

        <input type="submit" value="Filter" id="filterButton">
    </form>
</div>

<ul id="carList">
    <?php
    // Car filter
    $filtered_cars = $cars;
    if (isset($_GET['make']) && $_GET['make'] !== '') {
        $filtered_cars = array_filter($filtered_cars, function ($car) {
            return $car['make'] === $_GET['make'];
        });
    }

    if (isset($_GET['model']) && $_GET['model'] !== '') {
        $filtered_cars = array_filter($filtered_cars, function ($car) {
            return $car['model'] === $_GET['model'];
        });
    }

    foreach ($filtered_cars as $car) {
        echo '<div class="card">';
        echo '<img src="Components/' . $car['image'] . '" alt="' . $car['make'] . ' ' . $car['model'] . '" style="width:100%">';
        echo '<h3>' . $car['make'] . ' ' . $car['model'] . '</h3>';
        echo '<p class="price">Price: $' . $car['price'] . '</p>';
        echo '<p>Year: ' . $car['year'] . '</p>';
        echo '<button id="learn-more"><a href="' . $car['details_url'] . '">View Details</a></button>';
        echo '</div>';
    }
    ?>
</ul>

<style>
    /* Welcome */
    #welcome {
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

    /* Car filter */
    #car-filter {
        margin: 0 auto;
        max-width: 600px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #car-filter form {
        display: flex;
        flex-wrap: wrap;
    }

    #car-filter label {
        flex-basis: 100%;
    }

    #car-filter select,
    #car-filter input[type="submit"] {
        margin: 10px 0;
        padding: 5px;
        border-radius: 5px;
    }

    #car-filter select {
        flex-basis: calc(33.33% - 10px);
    }

    #car-filter input[type="submit"] {
        flex-basis: 100%;
        background-color: #454545;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    #car-filter input[type="submit"]:hover {
        background-color: #454545;
    }

    #filterButton {
        width: 100%;
        padding: 10px;
        background-color: #454545;
        color: white;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    #filterButton:hover {
        background-color: #000;
    }

    /* Car cards */
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

    #learn-more{

    }
</style>

</body>
</html>
