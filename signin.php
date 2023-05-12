<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Sign in</title>
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
</header>
<body>
<form method="POST" action="signin.php">
	<label for="username">Username:</label>
	<input type="text" id="username" name="username"><br>

	<label for="password">Password:</label>
	<input type="password" id="password" name="password"><br>

	<label for="user_type">User type:</label>
	<select id="user_type" name="user_type">
		<option value="user">User</option>
		<option value="admin">Admin</option>
	</select><br>

	<input type="submit" value="Sign in">
  <a href="signup.php">Don't have a account!</a>
</form>
  <?php

require_once('db_credentials.php');

// Get form data
$username = $_POST["username"];
$password = $_POST["password"];
$user_type = $_POST["user_type"];

// Prepare SQL statement
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND user_type='$user_type'";

// Execute SQL statement
$result = $conn->query($sql);

// Check if user exists
if ($result->num_rows > 0) {
	// User exists, redirect to dashboard
	if ($user_type == "admin") {
		header("Location: admin_dashboard.php");
	} else {
		header("Location: user_dashboard.php");
	}
} else {
	// User doesn't exist, show error message
	echo "Invalid username or password.";
}


// Close database connection
$conn->close();
?>


</body>
</html>
