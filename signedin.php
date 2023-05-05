<!DOCTYPE html>
<html>
<head>
	<title>Logged In</title>
</head>
<body>
	<h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
	<p>You are now logged in.</p>
	<p><a href="account.php">Account settings</a></p>
	<p><a href="logout.php">Log out</a></p>
    
    <?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
  header("Location: signin.php");
  exit();
}
?>
</body>
</html>
