<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Contact us!</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>

<?php include 'includes/navbar.php'; ?>

<body>
  <div class="contact-container">
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
</body>
<style>
  /* Contact page */
.contact-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 30%;
}
.text-container {
  text-align: center;
}

.text-container p {
  display: inline-block;
  margin: 0 10px;
}
/*Google maps*/
.map-wrapper {
  position: relative;
  height: 0;
  overflow: hidden;
  padding-bottom: 56.25%; /* 16:9 aspect ratio */
}
.map-wrapper iframe {
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 80%;
  height: 80%;
}
</style>
</html>