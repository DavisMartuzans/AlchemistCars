<!DOCTYPE html>
<html>
  <head>
    <title>Lease a Car</title>
    <link rel="stylesheet" href="style.css">
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

      <section id="leasing">
  <div class="container">
    <h1>Leasing Options</h1>
    
    <form id="leasing-form" method="post">
      <label for="make">Make:</label>
      <select id="make" name="make">
        <option value="">Select Make</option>
        <option value="mercedesbenz">Mercedes-Benz</option>
        <option value="bmw">BMW</option>
        <option value="audi">Audi</option>
        <option value="Volvo">Volvo</option>
        <option value="Mazda">Mazda</option>s
      </select>
      
      <label for="model">Model:</label>
      <select id="model" name="model">
        <option value="">Select Model</option>
        <!-- options for Mercedes-Benz models -->
        <optgroup label="Mercedes-Benz">
          <option value="e200">E200</option>
          <option value="e63">E63</option>
        </optgroup>
        <!-- options for BMW models -->
        <optgroup label="BMW">
          <option value="3.series">3.series</option>
        </optgroup>
        <!-- options for Audi models -->
        <optgroup label="Audi">
          <option value="a6">A6</option>
        </optgroup>
        <!-- options for Mazda models -->
        <optgroup label="Mazda">
          <option value="mx5">MX5</option>
        </optgroup>
        <!-- options for Volvo models -->
        <optgroup label="Volvo">
          <option value="s60r">S60R</option>
        </optgroup>
      </select>

      <label for="year">Year:</label>
      <select id="year" name="year">
        <option value="">Select Year</option>
        <option value="1993">1993</option>
        <option value="1994">1994</option>
        <option value="2022">2002</option>
        <option value="2005">2005</option>
        <option value="2006">2006</option>
      </select>
      
      <label for="lease-term">Lease Term:</label>
      <select id="lease-term" name="lease-term">
        <option value="">Select Lease Term</option>
        <option value="12">12 Months</option>
        <option value="24">24 Months</option>
        <option value="36">36 Months</option>
        <option value="48">48 Months</option>
        <option value="60">60 Months</option>
      </select>
      
      <button type="submit" name="submit">Search</button>
    </form>
  </div>
</section>
<?php

// Check if the form is submitted
if (isset($_POST['submit'])) {

  require_once('db_credentials.php');

  // Get the form data
  $make = $_POST['make'];
  $model = $_POST['model'];
  $year = $_POST['year'];
  $lease_term = $_POST['lease-term'];

  // Prepare and execute the SQL statement to insert the data into the database table
  $stmt = $conn->prepare("INSERT INTO leasing (make, model, year, lease_term) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $make, $model, $year, $lease_term);
  $stmt->execute();

  // Close the database connection
  $stmt->close();
  $conn->close();

  exit();
}
?>
    <script src="script.js"></script>
  </body>
</html>