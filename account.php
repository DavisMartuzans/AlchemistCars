<?php
session_start();
require_once('db_credentials.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>My Account</title>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="account-container">
    <h1><?php echo $username; ?> Account</h1>
    <h3>Account Information</h3>
    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>

    <h3>Change Password</h3>
    <?php
    if (isset($_GET['password_changed'])) {
        echo '<p class="success-message">Parole veiksmīgi mainīta.</p>';
    } elseif (isset($_GET['error'])) {
        $error = $_GET['error'];
        // Parāda kļūdas ziņojumu, ja esošā parole nav pareiza
        if ($error === 'invalid_password') {
            echo '<p class="error-message">Nepareiza esošā parole.</p>';
        }
    }
    ?>
    <form class="password-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="current-password">Current Password:</label>
        <input type="password" id="current-password" name="current-password" required>

        <label for="new-password">New Password:</label>
        <input type="password" id="new-password" name="new-password" required>

        <input class="password-button" type="submit" value="Change Password">
    </form>

    <h3>Delete Account</h3>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="submit" class="delete-button" name="delete-account" value="Delete Account">
    </form>
</div>

<style>
    html,
    body {
        height: auto;
        width: auto;
        font-family: 'Lato';font-size: 15px;
    }

    /* Nav bar */
    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        background-color: #f2f2f2;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
    }
    #logo {
        height: 50px;
        margin-right: 20px;
    }

    nav ul {
        display: flex;
        list-style: none;
        margin: 20;
        padding: 0;
    }

    nav a {
        display: block;
        padding:10px 15px;
        color: #333;
        text-decoration: none;
    }

    .success-message {
        color: green;
    }

    .error-message {
        color: red;
    }
</style>
</body>
</html>
