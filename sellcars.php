<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Sell Your Car</title>
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
      <?php
            if(isset($_SESSION['username'])) {
                // User is signed in
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                // User is not signed in
                echo '<li><a href="signin.php">Sign In</a></li>';
            }
            ?>
    </ul>
  </nav>
  
</header>
<body>
<div class="selling-form">
  	<div class="selling-container">
      <h1>Sell Your Car</h1>
      <form class="sellcars" action="process_sell_form.php" method="post">
        <label for="make">Make:</label>
        <input type="text" id="make" name="make" required>
  
        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>
  
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required>
  
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>
  
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
  
        <label for="contact">Contact Information:</label>
        <textarea id="contact" name="contact" required></textarea>
  
        <input class="filterButton" type="submit" value="Submit">
      </form>
    </div>
</body>
<style>
  /* Sell your car form */
.selling-form {
  max-width: 200px;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
</style>
</html>