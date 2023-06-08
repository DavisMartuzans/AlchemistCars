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
      <li><a href="contact.php">Contact</a></li>
      <?php
      if(isset($_SESSION['username'])) {
          if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') {
              echo '<li><a href="parts.php">Parts</a></li>';
              echo '<li><a href="sellcars.php">Sell Your Car</a></li>';
              echo '<li><a href="leasing.php">Leasing</a></li>';
          }
          if($_SESSION['role'] === 'admin') {
              echo '<li><a href="admin_dashboard.php">Admin Dashboard</a></li>';
          }
          echo '<li><a href="logout.php">Logout</a></li>';
          echo '<li><a href="account.php">Account</a></li>';
      } else {
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
<style>
  /* Welcome */
.welcome {
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 30px;
  text-align: center;
  margin-bottom: 20px;
}
.about {
  font-size: 20px;
  text-align: center;
  margin-bottom: 20px;
}

/* Car filter*/
.car-filter {
  margin: 0 auto;
  max-width: 600px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.car-filter form {
  display: flex;
  flex-wrap: wrap;
}

.car-filter label {
  flex-basis: 100%;
}

.car-filter select,
.car-filter input[type="submit"] {
  margin: 10px 0;
  padding: 5px;
  border-radius: 5px;
}

.car-filter select {
  flex-basis: calc(33.33% - 10px);
}

.car-filter input[type="submit"] {
  flex-basis: 100%;
  background-color: #454545;
  color: #fff;
  border: none;
  cursor: pointer;
}

.car-filter input[type="submit"]:hover {
  background-color: #454545;
}

.filterButton{
  width: 100%;
  padding: 10px;
  background-color: #454545;
  color: white;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.filterButton:hover {
  background-color: #000;
}

/* car cards */
.card {
  width: 300px;
  height: 400px;
  box-shadow: 2px 2px 5px #ccc;
  border-radius: 10px;
  overflow: hidden;
  margin: 10px;
  display: inline-block; /* added this line */
}

.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.card h3 {
  margin: 10px;
  font-size: 18px;
}

.card p {
  margin: 10px;
  font-size: 14px;
}

.learn-more{
  width: 100%;
  padding: 10px;
  background-color: #454545;
  color: white;
  font-size: 16px;
  border: none;
  cursor: pointer;
}
.learn-more:hover {
  background-color: #000;
}
</style>
</html>