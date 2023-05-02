<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercedes-Benz E200</title>
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
      <script src="script.js"></script>
      <main>
        <section>
          <button onclick="goBack()">Back</button>
          <h1>Mercedes-Benz E200</h1>
          <div class="boxed-text">
            <p>Looking for a luxurious and stylish ride that also delivers impressive performance and handling? Look<br> no further than this stunning Mercedes Benz E200 from 2002!</p>
            <p>This sleek sedan boasts a powerful 2.0-liter four-cylinder engine that delivers smooth and responsive<br> performance, making it a joy to drive in any situation. Plus, with its advanced suspension system and<br> responsive steering, you'll feel confident and in control on any road.</p>
            <p>But it's not just about performance - this Mercedes Benz also offers exceptional comfort and convenience,<br> with a spacious and luxurious interior that's designed to pamper you and your passengers. With its plush<br> leather seats, high-quality materials, and advanced features like climate control and a premium sound<br> system, you'll feel like you're traveling in your own private oasis.</p>
            <p>And with its stunning design and attention to detail, this Mercedes Benz E200 is sure to turn heads wherever<br> you go. Whether you're cruising down the highway or pulling up to a fancy restaurant, you'll be the envy<br> of everyone around you.</p>
            <p>So if you're looking for a car that combines style, performance, and luxury, look no further than this stunning<br> Mercedes Benz E200 from 2002. With its impressive features and exceptional performance, it's sure to provide<br> an unforgettable driving experience. Don't miss out on this opportunity - come see it for yourself today!</p>
          </div>
        </section>
        <div>
          <img src="Components/w210.jpeg" class="car-image" alt="Mercedes-Benz E200 2002">
        </div>
        <button class="price-button">€2500</button>
        <button class="rent"><a href="rent.php">Rent</a></button>
      </main>
</body>
</html>