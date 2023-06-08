<?php
require_once('db_credentials.php');

// Process sign-up form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $email = $_POST['email'] ?? '';

    // Validate form data
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($confirm_password)) {
        $errors[] = "Confirm password is required.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    }

    if (empty($errors)) {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();

        // Redirect to the sign-in page
        header("Location: signin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<header>
  <img src="Components/AlchemistCars.PNG" alt="Company Logo" id="logo">
  <nav>
    <ul>
      <li><a href="main.php">Home</a></li>
      <li><a href="contact.php">Contact</a></li>
      <?php
      if(isset($_SESSION['username'])) {
          if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') {
              echo '<li><a href="parts.php">Parts</a></li>';
              echo '<li><a href="sellcars.php">Sell Your Car</a></li>';
              echo '<li><a href="leasing.php">Leasing</a></li>';
          }
          if($_SESSION['role'] === 'admin') {
              echo '<li><a href="admin_dashboard.php">Admin Dashboard</a></li>';
          }
          echo '<li><a href="logout.php">Logout</a></li>';
          echo '<li><a href="account.php">Account</a></li>';
      } else {
          echo '<li><a href="signin.php">Sign In</a></li>';
      }
      ?>
    </ul>
  </nav>
</header>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <?php if (!empty($errors)) { ?>
            <ul class="error-list">
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Sign Up</button>
            <a href="signin.php">I already have an account!</a>
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
