<?php
session_start();

require_once('db_credentials.php');

// Check if the user is not signed in, redirect to the main page
if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

// Retrieve user data from the session
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Process password change form submission if applicable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the password change form was submitted
    if (isset($_POST['current-password']) && isset($_POST['new-password'])) {
        $currentPassword = $_POST['current-password'];
        $newPassword = $_POST['new-password'];

        // Retrieve the user's current password from the database
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $stmt->close();

        // Verify if the current password is correct
        if ($currentPassword === $storedPassword) {
            // Update the user's password in the database
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $newPassword, $username);
            $stmt->execute();
            $stmt->close();

            // Redirect to the account page with a success message
            header("Location: account.php?password_changed=1");
            exit();
        } else {
            // Redirect to the account page with an error message
            header("Location: account.php?error=invalid_password");
            exit();
        }
    }

    // Check if the delete account form was submitted
    if (isset($_POST['delete-account'])) {
        // Delete the user account from the database
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();

        // Clear all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Redirect to the main page after account deletion
        header("Location: main.php");
        exit();
    }
}

$conn->close();
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="main.php">AlchemistCars</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="main.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contacts</a>
      </li>
      <?php
            if (isset($_SESSION['username'])) {
                if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') {
                    echo '<li class="nav-item"> <a class="nav-link" href="parts.php">Parts</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="sellcars.php">Sell Your Car</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="leasing.php">Leasing</a></li>';
                }
            }
            ?>
      
      
   <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
        if (isset($_SESSION['username'])) {
                        // For admin content in the header
                        if ($_SESSION['role'] === 'admin') {
                            echo '<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a></li>';
                        }
                        // For signed-in in users
                        echo '<li class="nav-item"><a class="nav-link" href="account.php">Account Settings</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    } else {
                        // For not signed-in users
                        echo '<li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>';
                    }
        ?>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
  
  <div class="account-container">
    <h1><?php echo $username; ?> Account</h1>
    <h3>Account Information</h3>
    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    
    <h3>Change Password</h3>
    <?php
    if (isset($_GET['password_changed'])) {
        echo '<p class="success-message">Password changed successfully.</p>';
    } elseif (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error === 'invalid_password') {
            echo '<p class="error-message">Invalid current password.</p>';
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
