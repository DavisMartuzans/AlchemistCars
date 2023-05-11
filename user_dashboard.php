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
    <?php if(isset($_SESSION["username"])) { ?>
      <li><a href="logout.php">Logout</a></li>
    <?php } ?>
  </ul>
</nav>

</header>
<body>
    <h2 class="welcome">Welcome to AlchemistCars</h2>
    <p class="about">Here you can find a variety of awesome cars. </p>
    <p class="about">If you find anything you like, contact us and meet us</p>
  <div class="car-filter">
    <label for="make">Make:</label>
    <select id="make">
      <option value="all">All</option>
      <option value="Mercedes-Benz">Mercedes-Benz</option>
      <option value="Audi">Audi</option>
      <option value="BMW">BMW</option>
      <option value="Volvo">Volvo</option>
      <option value="Mazda">Mazda</option>
    </select>
    
    <label for="model">Model:</label>
    <select id="model">
      <option value="all">All</option>
      <option value="E200">E200</option>
      <option value="A6">A6</option>
      <option value="330i">330i</option>
      <option value="S60R">S60R</option>
      <option value="MX5">MX5</option>
      <option value="E63">E63</option>
    </select>
    
    <label for="year">Year:</label>
    <select id="year">
      <option value="all">All</option>
      <option value="1993">1993</option>
      <option value="1994">1994</option>
      <option value="2002">2002</option>
      <option value="2005">2005</option>
      <option value="2006">2006</option>
    </select>
    
    <button class="filterButton" id="filterButton">Filter</button>
  </div>
    <ul id="carList">
    <div class="card">
        <img src="Components/bmwe46.jpg" alt="Car 1" style="width:100%">
        <h3>BMW 330i</h3>
        <p class="title">Make: BMW</p>
        <p>Model: 330i</p>
        <p>Year: 2002</p>
        <p>Price: €5000</p>
        <a href="330i.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/audia6c4.jpg" alt="Car 2" style="width:100%">
        <h3>Audi A6 C4</h3>
        <p class="title">Make: Audi</p>
        <p>Model: A6</p>
        <p>Year: 1994</p>
        <p>Price: €3000</p>
        <a href="A6.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/w210.jpeg" alt="Car 3" style="width:100%">
        <h3>Mercedes-Benz E200</h3>
        <p class="title">Make: Mercedes-Benz</p>
        <p>Model: E200</p>
        <p>Year: 2002</p>
        <p>Price: €2500</p>
        <a href="E200.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/volvos60.jpg" alt="Car 4" style="width:100%">
        <h3>Volvo S60R</h3>
        <p class="title">Make: Volvo</p>
        <p>Model: S60R</p>
        <p>Year: 2005</p>
        <p>Price: €12000</p>
        <a href="s60r.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/mazdamx5.jpg" alt="Car 5" style="width:100%">
        <h3>Mazda MX5</h3>
        <p class="title">Make: Mazda</p>
        <p>Model: MX5</p>
        <p>Year: 1993</p>
        <p>Price: €15200</p>
        <a href="mx5.php"><button class="learn-more">Learn More</button></a>
      </div>
      <div class="card">
        <img src="Components/W211.jpg" alt="Car 6" style="width:100%">
        <h3>Mercedes-Benz E63</h3>
        <p class="title">Make: Mercedes-Benz</p>
        <p>Model: E63</p>
        <p>Year: 2006</p>
        <p>Price: €11000</p>
        <a href="e63.php"><button class="learn-more">Learn More</button></a>
      </div>
    </ul>
<script>
// get the select elements
const makeSelect = document.getElementById("make");
const modelSelect = document.getElementById("model");
const yearSelect = document.getElementById("year");

// add event listener to the filter button
filterButton.addEventListener("click", filterCars);

// filter the car list based on the selected options
function filterCars() {
  const make = makeSelect.value;
  const model = modelSelect.value;
  const year = yearSelect.value;

  const cars = carList.querySelectorAll(".card");

  cars.forEach(function(car) {
    const makeMatch = (make === "all" || car.querySelector(".title").textContent.includes(make));
    const modelMatch = (model === "all" || car.querySelector("p:nth-of-type(2)").textContent.includes(model));
    const yearMatch = (year === "all" || car.querySelector("p:nth-of-type(3)").textContent.includes(year));

    if (makeMatch && modelMatch && yearMatch) {
      car.style.display = "block";
    } else {
      car.style.display = "none";
    }
  });
}

</script>
</body>
</html>