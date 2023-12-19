<?php
session_start();
require_once('db_credentials.php');

// Pārbauda, vai lietotājs ir pierakstījies, ja nav tad aizsūta uz galveno lapu
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Apstrādā paroles maiņas formu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pārbauda, vai iesniegta paroles maiņas forma
    if (isset($_POST['current-password']) && isset($_POST['new-password'])) {
        $currentPassword = $_POST['current-password'];
        $newPassword = $_POST['new-password'];

        // Iegūst lietotāja paroli no datubāzes
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $stmt->close();

        // Pārbauda, vai parole ir pareiza
        if ($currentPassword === $storedPassword) {
            // Atjauno lietotāja paroli datubāzē
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $newPassword, $username);
            $stmt->execute();
            $stmt->close();

            // Novirza uz konta lapu
            header("Location: account.php?password_changed=1");
            exit();
        } else {
            // Novirza uz konta lapu ar kļūdas ziņojumu
            header("Location: account.php?error=invalid_password");
            exit();
        }
    }

    // Pārbauda, vai iesniegta dzēšanas forma
    if (isset($_POST['delete-account'])) {
        // Dzēš lietotāju no datubāzes
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();

        session_unset();

        session_destroy();
      
        header("Location: index.php");
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
    <a class="navbar-brand" href="index.php">AlchemistCars</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
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
                        // Priekš administrātora
                        if ($_SESSION['role'] === 'admin') {
                            echo '<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a></li>';
                        }
                        // Priekš lietotāja
                        echo '<li class="nav-item"><a class="nav-link" href="account.php">Account Settings</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    } else {
                        // Priekš vieša
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
