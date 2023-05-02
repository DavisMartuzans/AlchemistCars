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
      <li><a id="open-form" >Sign In</a></li>
    </ul>
  </nav>
<body>
<form action="signup.php" method="post">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email">
  
  <label for="password">Password:</label>
  <input type="password" id="password" name="password">
  
  <input type="submit" value="Sign In">
</form>
<?php
session_start();
require_once 'config.php';

if (isset($_POST['signup'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

	if (mysqli_query($conn, $sql)) {
		$_SESSION['success'] = 'Account created successfully';
		header('Location: index.php');
	} else {
		$_SESSION['error'] = 'Error: ' . mysqli_error($conn);
		header('Location: signup.php');
	}
}

mysqli_close($conn);
?>

</body>
</html>