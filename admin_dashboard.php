<?php
// Check if the user is logged in and is an admin
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

require_once('db_credentials.php');

// Retrieve the list of cars from the database
$stmt = $conn->prepare("SELECT * FROM cars");
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-car'])) {
        $carId = $_POST['delete-car'];

        // Delete the car from the database
        $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
        $stmt->bind_param("i", $carId);
        $stmt->execute();
        $stmt->close();

        // Redirect to the admin dashboard after deleting the car
        header("Location: admin_dashboard.php");
        exit();
    }
}

// Retrieve the list of users from the database
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Process the delete request if applicable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-user'])) {
        $userId = $_POST['delete-user'];

        // Delete the user from the database
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        // Redirect to the admin dashboard after deleting the user
        header("Location: admin_dashboard.php");
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
  <title>Admin Dashboard</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<header>
        <img src="Components/AlchemistCars.PNG" alt="Company Logo" id="logo">
        <nav>
          <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="parts.php">Parts</a></li>
            <li><a href="sellcars.php">Sell Your Car</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="leasing.php">Leasing</a></li>
            <?php
    if(isset($_SESSION['username'])) {
        // Check if the user is an admin and display the admin dashboard link
        if($_SESSION['role'] === 'admin') {
            echo '<li><a href="admin_dashboard.php">Admin Dashboard</a></li>';
        } else {
            // User is not an admin, display the account page link
            echo '<li><a href="account.php">Account</a></li>';
        }
        // User is signed in
        echo '<li><a href="logout.php">Logout</a></li>';
    } else {
        // User is not signed in
        echo '<li><a href="signin.php">Sign In</a></li>';
    }
    ?>
          </ul>
        </nav>
      </header>
<body>
  <h2>Admin Dashboard</h2>
  
  <h3>Users List</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
      <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="delete-user" value="<?php echo $user['id']; ?>">
            <button type="submit">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h3>Cars</h3>
  <table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Make</th>
      <th>Model</th>
      <th>Year</th>
      <th>Price</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cars as $car): ?>
    <tr>
      <td><?php echo $car['id']; ?></td>
      <td><?php echo $car['make']; ?></td>
      <td><?php echo $car['model']; ?></td>
      <td><?php echo $car['year']; ?></td>
      <td><?php echo $car['price']; ?></td>
      <td>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <input type="hidden" name="delete-car" value="<?php echo $car['id']; ?>">
          <button type="submit">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</body>
<style>
    h2 {
  text-align: center;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

table th,
table td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

table th {
  background-color: #f2f2f2;
}

table td {
  vertical-align: middle;
}

button {
  padding: 5px 10px;
  background-color: #ff5e5e;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #e63737;
}

</style>
</html>
