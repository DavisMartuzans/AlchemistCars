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

<?php include 'includes/footer.php'; ?>
</body>
</html>
