<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Sign Up</title>
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
  <h1>Sign Up</h1>
  <form method="POST" action="signup.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br><br>
    <input type="submit" value="Sign Up">
  </form>

  <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];

  require_once('db_credentials.php');


  // prepare statement and bind parameters
  $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);

  // execute statement
  if (mysqli_stmt_execute($stmt)) {
    echo "<p>Sign up successful!</p>";
  } else {
    echo "<p>Error: " . mysqli_stmt_error($stmt) . "</p>";
  }

  // close statement and connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>

</body>
</html>
