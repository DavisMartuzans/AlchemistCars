<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Sign In</h2>
        <form method="POST" action="signin.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign In</button>
            <a href="signup.php">I don't have a account!</a>
        </form>
    </div>
    <style>
      .container {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-group {
    margin-bottom: 10px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

    </style>
</body>
</html>
<?php
require_once('db_credentials.php');

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute SQL statement
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Start session and store user data
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['username'];

        // Redirect to signed-in page
        header("Location: main.php");
        exit();
    } else {
        echo "Invalid password!";
    }
} else {
    echo "Invalid username!";
}

$stmt->close();
$conn->close();
?>

