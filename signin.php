<?php
require_once('db_credentials.php');

// Process sign-in form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            // Start session and store user data
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on user role
            if ($_SESSION['role'] == 'user') {
                header("Location: main.php"); // Redirect to user-specific page
                exit();
            } elseif ($_SESSION['role'] == 'admin') {
                header("Location: main.php"); // Redirect to admin-specific page
                exit();
            } else {
                $error_message = "Invalid role!";
            }
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "Invalid username!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>

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

<body>
    <div class="login-box">
        <h2>Sign In</h2>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="user-box">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="user-box">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign In</button>
            <a href="signup.php">I don't have an account!</a>
        </form>
    </div>
    <style>
/* Sign-in Page Styles */
.login-box {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

form {
  width: 400px;
  padding: 30px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.user-box {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  color: #333;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button[type="submit"] {
  display: block;
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  background-color: #333;
  color: #fff;
  cursor: pointer;
}

a {
  color: #333;
  text-decoration: none;
}

.error {
  color: #ff0000;
  margin-bottom: 10px;
}
    </style>
</body>
</html>
