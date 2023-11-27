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

// Retrieve the list of parts from the database
$stmt = $conn->prepare("SELECT * FROM parts");
$stmt->execute();
$result = $stmt->get_result();
$parts = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Process the delete request if applicable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-part'])) {
        $partId = $_POST['delete-part'];

        // Delete the part from the database
        $stmt = $conn->prepare("DELETE FROM parts WHERE id = ?");
        $stmt->bind_param("i", $partId);
        $stmt->execute();
        $stmt->close();

        // Redirect to the admin dashboard after deleting the part
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

  <h3>Cars List</h3>
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
<h3>Parts List</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Part Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($parts as $part): ?>
      <tr>
        <td><?php echo $part['id']; ?></td>
        <td><?php echo $part['part_name']; ?></td>
        <td><?php echo $part['description']; ?></td>
        <td><?php echo $part['price']; ?></td>
        <td><img src="Components/<?php echo $part['image']; ?>" alt="<?php echo $part['part_name']; ?>" width="100"></td>
        <td>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="delete-part" value="<?php echo $part['id']; ?>">
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
