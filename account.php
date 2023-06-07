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
    if (isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
        $currentPassword = $_POST['current-password'];
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];

        // Retrieve the user's current password from the database
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        $stmt->close();

        // Verify if the current password is correct
        if (password_verify($currentPassword, $hashedPassword)) {
            // Verify if the new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $stmt->bind_param("ss", $newHashedPassword, $username);
                $stmt->execute();
                $stmt->close();

                // Redirect to the account page with a success message
                header("Location: account.php?password_changed=1");
                exit();
            } else {
                // Redirect to the account page with an error message
                header("Location: account.php?error=password_mismatch");
                exit();
            }
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
        <li><form action="logout.php" method="post"><button type="submit" name="sign-out" style="border:none; background-color: transparent; cursor: pointer;">Sign Out</button></form></li>
      </ul>
    </nav>
  </header>
  
  <div class="account-container">
    <h1>My Account</h1>
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <h3>Account Information</h3>
    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    
    <h3>Change Password</h3>
    <?php
    if (isset($_GET['password_changed'])) {
        echo '<p class="success-message">Password changed successfully.</p>';
    } elseif (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error === 'password_mismatch') {
            echo '<p class="error-message">New password and confirm password do not match.</p>';
        } elseif ($error === 'invalid_password') {
            echo '<p class="error-message">Invalid current password.</p>';
        }
    }
    ?>
    <form class="password-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <label for="current-password">Current Password:</label>
      <input type="password" id="current-password" name="current-password" required>
      
      <label for="new-password">New Password:</label>
      <input type="password" id="new-password" name="new-password" required>
      
      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>
      
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
