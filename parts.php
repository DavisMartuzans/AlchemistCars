<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Parts</title>
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
  <h2 class="welcome">Welcome to the parts page</h2>
<div class="car-filter">
<label for="make">Make:</label>
    <select id="make">
      <option value="all">All</option>
      <option value="Mercedes-Benz">Mercedes-Benz</option>
      <option value="Audi">Audi</option>
      <option value="BMW">BMW</option>
      <option value="Mazda">Mazda</option>
    </select>
    
    <label for="model">Model:</label>
    <select id="model">
      <option value="all">All</option>
      <option value="E200">E200</option>
      <option value="A6">A6</option>
      <option value="330i">330i</option>
      <option value="MX5">MX5</option>
    </select>
    
    <label for="year">Year:</label>
    <select id="year">
      <option value="all">All</option>
      <option value="2002">2002</option>
      <option value="1993">1993</option>
      <option value="1994">1994</option>
    </select>

    <button class="filterButton" id="filterButton">Filter</button>
</div>    
    <ul id="carList">
    <div class="card">
        <img src="Components/Axel.jpg" alt="Part 1" style="width:100%">
        <h3>Axle Shaft - Right Rear</h3>
        <p class="title">Make: BMW</p>
        <p>Model: 330i</p>
        <p>Year: 2002</p>
        <p>Price: €700</p>
        <a href="330i.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/c4headlights.jpg" alt="Part 2" style="width:100%">
        <h3>Front Headlights</h3>
        <p class="title">Make: Audi</p>
        <p>Model: A6</p>
        <p>Year: 1994</p>
        <p>Price: €50</p>
        <a href="A6.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/w210frontbumper.jpg" alt="Part 3" style="width:100%">
        <h3>Front Bumper</h3>
        <p class="title">Make: Mercedes-Benz</p>
        <p>Model: E200</p>
        <p>Year: 2002</p>
        <p>Price: €200</p>
        <a href="E200.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components\mx5headlights.jpg" alt="Part 4" style="width:100%">
        <h3>Front Headlights</h3>
        <p class="title">Make: Mazda</p>
        <p>Model: MX5</p>
        <p>Year: 1993</p>
        <p>Price: €140</p>
        <a href="mx5.php"><button class="learn-more">Learn More</button></a>
      </div>
    </ul>
  <script>
  const filterButton = document.querySelector("#filterButton");
const carList = document.querySelector("#carList");

filterButton.addEventListener("click", () => {
  const make = document.querySelector("#make").value;
  const model = document.querySelector("#model").value;
  const year = document.querySelector("#year").value;

  for (let i = 0; i < carList.children.length; i++) {
    const car = carList.children[i];
    const carMake = car.querySelector(".title").textContent.split(": ")[1];
    const carModel = car.querySelector("p:nth-of-type(2)").textContent.split(": ")[1];
    const carYear = car.querySelector("p:nth-of-type(3)").textContent.split(": ")[1];

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