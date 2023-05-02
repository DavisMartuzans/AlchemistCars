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
<form action="login.php" method="post">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email">
  
  <label for="password">Password:</label>
  <input type="password" id="password" name="password">
  
  <input type="submit" value="Sign In">
</form>
<?php
// start the session
session_start();

// check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // redirect the user to the home page
  header("Location: home.php");
  exit();
}

// check if the login form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get the email and password submitted by the user
  $email = $_POST['email'];
  $password = $_POST['password'];

  // connect to the database
  $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

  // check if the connection was successful
  if (!$conn) {
    die('Could not connect to database: ' . mysqli_error($conn));
  }

  // prepare the SQL query to fetch the user with the given email and password
  $query = "SELECT id FROM users WHERE email = '$email' AND password = '$password'";

  // execute the query and get the result
  $result = mysqli_query($conn, $query);

  // check if the query was successful
  if (!$result) {
    die('Could not fetch user: ' . mysqli_error($conn));
  }

  // check if a user was found with the given credentials
  if (mysqli_num_rows($result) == 1) {
    // fetch the user's ID
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];

    // set the session variable for the authenticated user
    $_SESSION['user_id'] = $user_id;

    // redirect the user to the home page
    header("Location: home.php");
    exit();
  } else {
    // show an error message if no user was found with the given credentials
    echo 'Invalid email or password.';
  }

  // close the database connection
  mysqli_close($conn);
}
?>

</body>
</html>