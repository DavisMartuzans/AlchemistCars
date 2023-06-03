<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audi A6</title>
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
          <h1>Audi A6</h1>
          <div class="boxed-text">
            <p>Looking for a classic luxury car that's both stylish and practical? Look no further than this stunning Audi A6 from 1994!</p>
            <p>With its sleek design and attention to detail, this Audi A6 is sure to turn heads wherever you go. From its distinctive grille to its aerodynamic curves and lines, this car exudes class and sophistication.</p>
            <p>But it's not just about looks - this Audi A6 also offers exceptional performance and handling, thanks to its advanced suspension system and responsive steering. Whether you're cruising down the highway or navigating winding back roads, you'll feel confident and in control at all times.</p>
            <p>Inside, this Audi A6 offers a spacious and comfortable cabin that's designed to cater to your every need. With its plush leather seats, advanced climate control system, and premium sound system, you'll feel like you're traveling in your own private oasis.</p>
            <p>And with its advanced safety features, including anti-lock brakes and airbags, you can rest assured that you and your passengers will be well protected on every journey.</p>
          </div>
        </section>
        <div>
          <img src="Components/audia6c4.jpg" class="car-image" alt="Audi A6 1994">
        </div>
        <button class="price-button">€3000</button>
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