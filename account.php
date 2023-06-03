<?php
session_start();

// Check if user is not signed in, redirect to main page
if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

// Retrieve user data from the session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$address = $_SESSION['address'];

// Process password change form submission if applicable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the password change form was submitted
    if (isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
        // Process the password change logic here
        // ...
    }
}

// Process account deletion if applicable
if (isset($_POST['delete-account'])) {
    // Process the account deletion logic here
    // ...
    // Redirect to the main page after account deletion
    header("Location: main.php");
    exit();
}

// Process sign out if applicable
if (isset($_POST['sign-out'])) {
    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the signed out main page
    header("Location:main.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>My Account</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
  <header>
    <img src="Components/AlchemistCars.PNG" alt="Company Logo" id="logo">
    <nav>
      <ul>
        <li><a href="main.php">Home</a></li>
        <li><a href="parts.php">Parts</a></li>
        <li><a href="sellcars.php">Sell Your Car</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="leasing.php">Leasing</a></li>
        <li><form action="logout.php" method="post"><button type="submit" name="sign-out" style="border:none; background-color: transparent; cursor: pointer;">Sign Out</button></form></li>
      </ul>
    </nav>
  </header>
  
  <div class="account-container">
    <h1>My Account</h1>
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <h3>Account Information</h3>
    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Address:</strong> <?php echo $address; ?></p>
    
    <h3>Change Password</h3>
    <form class="password-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <label for="current-password">Current Password:</label>
      <input type="password" id="current-password" name="current-password" required>
      
      <label for="new-password">New Password:</label>
      <input type="password" id="new-password" name="new-password" required>
      
      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>
      
      <input class="password-button" type="submit" value="Change Password">
    </form>
    
    <h3>Delete Account</h3>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="submit" class="delete-button" name="delete-account" value="Delete Account">
    </form>
  </div>
</body>
</html>