<?php
session_start();
require_once('db_credentials.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Welcome to AlchemistCars</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>

<body>
<?php include 'includes/navbar.php'; ?>

<section id="welcome-section">
    <div id="welcome-background"></div>
    <div class="welcome-text">
        <h2 id="welcome">Welcome to AlchemistCars</h2>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // For logged-in users
            echo '<p class="about">You are logged in as ' . $_SESSION['username'] . '</p>';
            echo '<p class="about">Here you can find a variety of awesome cars.</p>';
            echo '<p class="about">If you find anything you like, contact us and meet us.</p>';
        } else {
            // For guests
            echo '<p class="about">Here you can find a variety of awesome cars.</p>';
            echo '<p class="about">If you find anything you like, please sign in to access additional features.</p>';
        }
        ?>
        <a class="about" href="cars.php">Get your car today</a>
    </div>


</section>
<style>
/*Laipni lūdzam ekrāns */
#welcome-background{
  background-image: url("Components\mbbackground4k.jpg");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  filter: blur(8px);
  -webkit-filter: blur(8px);
}

.welcome-text{
    background-color: rgb(0, 0, 0); /* Fallback color */
    background-color: rgba(0, 0, 0, 0.1); /* Black w/opacity/see-through */
    color: white;
    font-weight:bold;
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    width: 80%;
    padding: 20px;
    text-align: center;
}
/* Laipni lūdzam teksts */
#welcome{
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 60px;
    font-weight:bold;
    color: white;
    text-align: center;
    margin-bottom: 20px;
}

.about {
    font-size: 20px;
    color: white;
    text-align: center;
    margin-bottom: 20px;
}
#learn-more {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    border: 1px solid #3498db; /* Border color */
    color: #ffffff; /* Text color */
    background-color: #3498db; /* Background color */
    border-radius: 5px; /* Rounded corners */
}

#learn-more {
    background-color: #2980b9;
    border-color: #2980b9; 
}
</style>
</body>
</html>
