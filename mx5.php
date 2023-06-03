<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mazda MX-5</title>
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
      <main>
        <section>
          <h1>Mazda MX-5</h1>
         <div class="boxed-text">
          <p>The Mazda MX-5, also known as the Miata, is a two-seater sports car that was first introduced in 1989. </p>
          <p>Engine: The 1993 MX-5 features a 1.6-liter inline-four engine that produces 116 horsepower and 100 lb-ft of torque. The engine is paired with a five-speed manual transmission and provides quick and responsive acceleration.</p>
          <p>Design: The MX-5 has a classic and timeless design that has remained popular over the years. The car features a sleek and aerodynamic shape, with a long hood and short overhangs. The 1993 model also has pop-up headlights, which add to its sporty look.</p>
          <p>Overall, the Mazda MX-5 is a fun and affordable sports car that provides a pure driving experience. It is a great choice for drivers who want a car that is enjoyable to drive, without breaking the bank.</p>
        </div>
        </section>
        <div>
          <img src="Components/mazdamx5.jpg" class="car-image" alt="Mazda MX-5 1993">
        </div>
        <button class="price-button">€5000</button>
        <?php
        if(isset($_SESSION['username'])) {
            // User is signed in
            echo '<button class="rent"><a href="rent.php">Rent</a></button>';
        } else {
            // User is not signed in
            echo '<p>If you want to rent this car, please <a href="signin.php">sign in</a> or <a href="signup.php">sign up</a>.</p>';
        }
        ?>
      </main>
</body>
</html>