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
      <li><a href="signin.php" >Sign In</a></li>
    </ul>
  </nav>
<body>
<form action="signup.php" method="POST">
  <label for="username">Username:</label>
  <input type="text" name="username" id="username" required>

  <label for="email">Email:</label>
  <input type="email" name="email" id="email" required>

  <label for="full_name">Full Name:</label>
  <input type="text" name="full_name" id="full_name" required>

  <label for="password">Password:</label>
  <input type="password" name="password" id="password" required>

  <input type="submit" value="Sign Up">
</form>


<?php
// Get the user's input from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Hash the password using bcrypt
$password_hash = password_hash($password, PASSWORD_DEFAULT);

require_once('db_credentials.php');

// Insert the user's information into the users table
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hash')";
if ($conn->query($sql) === TRUE) {
  // Start a session and redirect to the logged-in page
  session_start();
  $_SESSION['username'] = $username;
  header('Location: signedin.php');
} else {
  // Display an error message if the username is already taken
  echo "Username already taken";
}

// Close the database connection
$conn->close();
?>

</body>
</html>