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
      <li><a id="open-form" >Sign In</a></li>
    </ul>
  </nav>
  
</header>
<div id="form-container">
  <div class="form-header">
    <h2>Sign In</h2>
    <button id="close-form">X</button>
  </div>
  <form>
    <input type="text" placeholder="Email">
    <input type="password" placeholder="Password">
    <button>Confirm!</button>
  </form>
  <p>Don't have an account? <a href="#">Sign up</a></p>
</div>
  <div class="form-container">
  	<div class="container">
      <h1>Sell Your Car</h1>
      <form class="sellcars" action="sell.php" method="post">
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
  
        <input type="submit" value="Submit">
      </form>
    </div>
<body>
  <script src="script.js"></script>
</body>
</html>