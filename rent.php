<?php
session_start();
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
      <li><a href="parts.php">Parts</a></li>
      <li><a href="sellcars.php">Sell Your Car</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="leasing.php">Leasing</a></li>
      <?php
            if(isset($_SESSION['username'])) {
                // User is signed in
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                // User is not signed in
                echo '<li><a href="signin.php">Sign In</a></li>';
            }
            ?>
    </ul>
  </nav>
</header>
<body>
	<form action="rent.php" method="post">
		<label for="car">Select a Car:</label>
		<select id="car" name="car">
			<option value="Mercedes-Benz E200">Mercedes-Benz E200</option>
      <option value="Mercedes-Benz E63">Mercedes-Benz E63</option>
      <option value="Volvo S60R">Volvo S60R</option>
			<option value="Audi A6">Audi A6</option>
			<option value="BMW 330i">BMW 330i</option>
      <option value="Mazda MX5">Mazda MX5</option>
		</select>
		<br><br>
		<label for="pickup_date">Pick-up Date:</label>
		<input type="date" id="pickup_date" name="pickup_date">
		<br><br>
		<label for="return_date">Return Date:</label>
		<input type="date" id="return_date" name="return_date">
		<br><br>
		<input type="submit" value="Submit">
	</form>
  <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $car = $_POST['car'];
  $pickup_date = $_POST['pickup_date'];
  $return_date = $_POST['return_date'];

  require_once('db_credentials.php');

  $sql = "INSERT INTO car_rentals (car, pickup_date, return_date)
  VALUES ('$car', '$pickup_date', '$return_date')";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

</body>
</html>