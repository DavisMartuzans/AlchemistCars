<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Sign Up</h1>
    <form action="signup.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <input type="text" name="email" placeholder="Email" required>
      <button type="submit">Sign Up</button>
    </form>
  </div>
</body>
<style>
  .container {
  width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
}

h1 {
  text-align: center;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
}

button[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #45a049;
}

</style>
</html>
<?php
require_once('db_credentials.php');

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$email = $_POST['email'];

// Validate passwords and username
// ...

// Validate email
if (empty($email)) {
    die("Error: Email cannot be empty.");
}

// Prepare and execute SQL statement
$stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $username, $password, $email);

// Execute the statement and handle the result
if ($stmt->execute()) {
    echo "Sign up successful! Redirecting to sign-in page...";
    header("Refresh: 2; URL=signin.php"); // Redirect to sign-in page after 2 seconds
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

