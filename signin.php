<?php
session_start();

require_once('db_credentials.php');

// Establish database connection
$db = mysqli_connect($servername, $username, $password, $dbname);

if (!$db) {
  // Handle connection error
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $myemail = mysqli_real_escape_string($db, $_POST['email']);
  $mypassword = mysqli_real_escape_string($db, $_POST['password']);
  $res = mysqli_query($db, "SELECT id, password, admin FROM users WHERE email = '$myemail'");
  $row = mysqli_fetch_assoc($res);

  if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
    $error = "Please enter a valid email address.";
  } elseif (empty($myemail) || empty($mypassword)) {
    $error = "Please enter your email and password.";
  } elseif (!$row || !password_verify($mypassword, $row['password'])) {
    $error = "Your Login Email or Password is invalid";
  } else {
    $_SESSION['login_user'] = $myemail;
    header($row['admin'] ? "Location: admin_dashboard.php" : "Location: main.php");
    exit(); // Ensure script execution is stopped after redirecting
  }
}

// Close the database connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

  <div class="center-form">
	<form action="" method="post">
		<label for="email">Email:</label><br>
		<input type="email" name="email" class = "box"><br>

		<label for="password">Password:</label><br>
		<input type="password" name="password" class = "box"><br><br>

		<input type="submit" value="Sign in">
    <a href=signup.php>I dont have a account!</a>
	</form>
  <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if (isset($error)){echo $error;}; ?></div>
  </div>
</body>
</html>