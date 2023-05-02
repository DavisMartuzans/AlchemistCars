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
    
    <label for="make">Make:</label>
    <select id="make">
      <option value="all">All</option>
      <option value="Mercedes-Benz">Mercedes-Benz</option>
      <option value="Audi">Audi</option>
      <option value="BMW">BMW</option>
    </select>
    
    <label for="model">Model:</label>
    <select id="model">
      <option value="all">All</option>
      <option value="E200">E200</option>
      <option value="A6">A6</option>
      <option value="330i">330i</option>
    </select>
    
    <label for="year">Year:</label>
    <select id="year">
      <option value="all">All</option>
      <option value="2002">2002</option>
      <option value="1994">1994</option>
    </select>
    
    <button id="filterButton">Filter</button>
    
    <ul id="carList">
    <div class="card">
        <img src="Components/bmwe46.jpg" alt="Car 5" style="width:100%">
        <h3>BMW 330i</h3>
        <p class="title">Make: BMW</p>
        <p>Model: 330i</p>
        <p>Year: 2002</p>
        <p>Price: €5000</p>
        <a href="330i.php"><button>Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/audia6c4.jpg" alt="Car 6" style="width:100%">
        <h3>Audi A6 C4</h3>
        <p class="title">Make: Audi</p>
        <p>Model: A6</p>
        <p>Year: 1994</p>
        <p>Price: €3000</p>
        <a href="A6.php"><button>Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/w210.jpeg" alt="Car 9" style="width:100%">
        <h3>Mercedes-Benz E200</h3>
        <p class="title">Make: Mercedes-Benz</p>
        <p>Model: E200</p>
        <p>Year: 2002</p>
        <p>Price: €2500</p>
        <a href="E200.php"><button>Learn More</button></a>
      </div>
    </ul>
    
    <script>
const filterButton = document.querySelector("#filterButton");
const carList = document.querySelector("#carList");

filterButton.addEventListener("click", () => {
  const make = document.querySelector("#make").value;
  const model = document.querySelector("#model").value;
  const year = document.querySelector("#year").value;

  // Loop through each car in the list
  for (let i = 0; i < carList.children.length; i++) {
    const car = carList.children[i];
    const carMake = car.querySelector(".title").textContent.split(": ")[1];
    const carModel = car.querySelector("p:nth-of-type(2)").textContent.split(": ")[1];
    const carYear = car.querySelector("p:nth-of-type(3)").textContent.split(": ")[1];

    // Hide the car if it doesn't match the selected filter
    if ((make === "all" || carMake === make) && (model === "all" || carModel === model) && (year === "all" || carYear === year)) {
      car.style.display = "";
    } else {
      car.style.display = "none";
    }
  }
});
    </script>
</body>
</html>