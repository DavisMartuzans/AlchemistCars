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
</header>
<script type="text/javascript" src="script.js"></script>

<body>
    <h2 class="welcome">Welcome to AlchemistCars</h2>
    <p class="about">Here you can find a variety of awesome cars. </p>
    <p class="about">If you find anything you like, contact us and meet us</p>
    <form method="get">
      <label for="make">Make:</label>
      <select name="make" id="make">
        <option value="bmw">BMW</option>
        <option value="mercedes">Mercedes-Benz</option>
        <option value="audi">Audi</option>
      </select>
      <label for="model">Model:</label>
      <select type="submit" id="model">
        <option value="330i">330i</option>
        <option value="e200">E200</option>
        <option value="a6">A6</option>
      </select>
      <label for="year">Year:</label>
      <select name="year" id="year">
        <option value="2002">2002</option>
        <option value="1994">1994</option>
      </select>
      <br><br>
      <input type="submit" name="submit" value="Filter">
    </form>
    <section>
      <div class="card">
        <img src="Components/bmwe46.jpg" alt="Car 5" style="width:100%">
        <h3>BMW 330i</h3>
        <p class="title">Make: BMW</p>
        <p>Model: 330i</p>
        <p>Year: 2002</p>
        <p>Price: €5000</p>
        <a href="/Cars/330i.html"><button>Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/audia6c4.jpg" alt="Car 6" style="width:100%">
        <h3>Audi A6 C4</h3>
        <p class="title">Make: Audi</p>
        <p>Model: A6</p>
        <p>Year: 1994</p>
        <p>Price: €3000</p>
        <a href="Cars/A6.html"><button>Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/w210.jpeg" alt="Car 9" style="width:100%">
        <h3>Mercedes-Benz E200</h3>
        <p class="title">Make: Mercedes-Benz</p>
        <p>Model: E200</p>
        <p>Year: 2002</p>
        <p>Price: €2500</p>
        <a href="Cars/E200.html"><button>Learn More</button></a>
      </div>
    </section>
<script type="text/javascript" src="/cars.php"></script>
</body>
</html>