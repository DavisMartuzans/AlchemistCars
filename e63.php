<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercedes-Benz E63</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cars.css">
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
          <h1>Mercedes-Benz E63</h1>
         <div class="boxed-text">
          <p>The Mercedes Benz E63 AMG is a high-performance luxury sedan that was first introduced in 2006.</p>
          <p>Engine: The E63 AMG is powered by a 6.2-liter V8 engine that produces 507 horsepower and 465 lb-ft of torque. This engine is paired with a seven-speed automatic transmission and can accelerate from 0 to 60 mph in just 4.3 seconds.</p>
          <p>Design: The E63 AMG has a sleek, aerodynamic design that sets it apart from other luxury sedans. The car features a sporty front grille, aggressive air intakes, and 19-inch alloy wheels.</p>
          <p>Overall, the Mercedes Benz E63 AMG is a powerful and luxurious sedan that offers exceptional performance, comfort, and safety. It is a great choice for drivers who want a high-performance vehicle that also provides a premium driving experience.</p> 
        </div>
        </section>
        <div>
          <img src="Components/w211.jpg" class="car-image" alt="Mercedes-Benz E63 2006">
        </div>
        <button class="price-button">€6700</button>
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