<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Contact us!</title>
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
</header>
<body>
  <div class="container">
    <div class="text-container">
      <h1>Contact Us</h1>
      <p>Phone: +371 25577052</p>
      <p>E-mail: contacts@alchemistcars.lv</p>
    </div>
  </div>
  <!-- Google maps address -->
<div class="map-wrapper">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2176.5768736965742!2d24.179247951646435!3d56.93891720726135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eece044123a401%3A0xd357dc05a50e0ea0!2zRMSBcnpjaWVtYSBpZWxhIDY0LCBMYXRnYWxlcyBwcmlla8WhcGlsc8STdGEsIFLEq2dhLCBMVi0xMDcz!5e0!3m2!1slv!2slv!4v1680898529500!5m2!1slv!2slv" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div> 
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
</body>
</html>