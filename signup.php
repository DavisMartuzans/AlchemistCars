<?php
require_once('db_credentials.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $myname = $_POST['name'];
  $myemail = $_POST['email'];
  $mypassword = $_POST['password'];

  // Validates user input
  if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
    $error = "Please enter a valid email address.";
  } elseif (empty($myname) || empty($myemail) || empty($mypassword)) {
    $error = "Please enter your name, email, and password.";
  } else {
    // Checks if email already exists
    $chk_query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($db, $chk_query);
    mysqli_stmt_bind_param($stmt, "s", $myemail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      $error = "Error: Email already exists in the database.";
    } else {
      // Inserts user data into the database
      $insert_query = "INSERT INTO users (name, email, password, admin) VALUES (?, ?, ?, 0)";
      $stmt = mysqli_prepare($db, $insert_query);
      $hashed_password = password_hash($mypassword, PASSWORD_DEFAULT);
      mysqli_stmt_bind_param($stmt, "sss", $myname, $myemail, $hashed_password);
      if (mysqli_stmt_execute($stmt)) {
        $_SESSION['login_user'] = $myemail;
        header("Location: main.php");
        exit();
      } else {
        echo "Error: " . mysqli_error($db);
      }
    }
  }
  mysqli_close($db);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
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
    <label for="name">Name:</label><br>
		<input type="name" name="name" class = "box"><br>

		<label for="email">Email:</label><br>
		<input type="email" name="email" class = "box"><br>

		<label for="password">Password:</label><br>
		<input type="password" name="password" class = "box"><br><br>

		<input type="submit" value="Register">
    <div style = "font-size:14px; color:#cc0000; margin-top:10px"><?php if (isset($error)){echo $error;}; ?></div>
	</form>
  </div>
</body>
</html>