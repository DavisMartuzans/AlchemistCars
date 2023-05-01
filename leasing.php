<!DOCTYPE html>
<html>
  <head>
    <title>Leasing</title>
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
        
        <form id="leasing-form">
          <label for="make">Make:</label>
          <select id="make">
            <option value="">--Select Make--</option>
            <option value="mercedesbenz">Mercedes-Benz</option>
            <option value="bmw">BMW</option>
            <option value="audi">Audi</option>
          </select>
          
          <label for="model">Model:</label>
          <select id="model">
            <option value="">--Select Model--</option>
            <!-- options for Mercedes-Benz models -->
            <optgroup label="Mercedes-Benz">
              <option value="e200">E200</option>
            </optgroup>
            <!-- options for BMW models -->
            <optgroup label="BMW">
              <option value="3.series">3.series</option>
            </optgroup>
            <!-- options for Audi models -->
            <optgroup label="Audi">
              <option value="a6">A6</option>
            </optgroup>
          </select>
          
          <label for="year">Year:</label>
          <select id="year">
            <option value="">--Select Year--</option>
            <option value="2022">2002</option>
            <option value="2021">1994</option>
          </select>
          
          <label for="lease-term">Lease Term:</label>
          <select id="lease-term">
            <option value="">--Select Lease Term--</option>
            <option value="12">12 Months</option>
            <option value="24">24 Months</option>
            <option value="36">36 Months</option>
            <option value="48">48 Months</option>
            <option value="60">60 Months</option>
          </select>
          
          <button type="submit">Search</button>
        </form>
        
        <div id="results">
          <!-- results of the car search will be displayed here -->
        </div>
        
      </div>
    </section>
    <script src="script.js"></script>
  </body>
</html>