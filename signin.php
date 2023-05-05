<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>AlchemistCars</title>
  <link href="better.css" rel="stylesheet" type="text/css" />
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
<form action="signin.php" method="post" id="signin-form">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username" required>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>

  <input type="submit" value="Sign In">
</form>

<?php
// Get the user's input from the form
$username = $_POST['username'];
$password = $_POST['password'];

require_once('db_credentials.php');

// Retrieve the user's password hash from the users table
$sql = "SELECT password FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  // Verify the password hash
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    // Start a session and redirect to the logged-in page
    session_start();
    $_SESSION['username'] = $username;
    header('Location: loggedin.php');
  } else {
    // Display an error message if the password is incorrect
    echo "Incorrect password";
  }
} else {
  // Display an error message if the username is not found
  echo "Username not found";
}

// Close the database connection
$conn->close();
?>

</body>
</html>
