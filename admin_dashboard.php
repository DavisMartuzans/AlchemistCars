<?php
// Pārbauda, vai ir pierakstījies kā administrators
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

require_once('db_credentials.php');

// Iegūst automašīnu sarakstu no datubāzes
$stmt = $conn->prepare("SELECT * FROM cars");
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Apstrādā dzēšanas pieprasījumu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-car'])) {
        $carId = $_POST['delete-car'];

        // Dzēš automašīnu no datubāzes
        $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
        $stmt->bind_param("i", $carId);
        $stmt->execute();
        $stmt->close();

        // Novirza uz administratora informācijas paneli pēc automašīnas dzēšanas
        header("Location: admin_dashboard.php");
        exit();
    }
}

// Iegūst lietotāju sarakstu no datubāzes
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Apstrādā dzēšanas pieprasījumu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-user'])) {
        $userId = $_POST['delete-user'];

        // Dzēš lietotāju no datubāzes
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        // Novirza uz administratora informācijas paneli pēc lietotāja dzēšanas
        header("Location: admin_dashboard.php");
        exit();
    }
}

// Iegūst detaļu sarakstu no datubāzes
$stmt = $conn->prepare("SELECT * FROM parts");
$stmt->execute();
$result = $stmt->get_result();
$parts = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Apstrādā dzēšanas pieprasījumu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-part'])) {
        $partId = $_POST['delete-part'];

        // Dzēš detaļu no datubāzes
        $stmt = $conn->prepare("DELETE FROM parts WHERE id = ?");
        $stmt->bind_param("i", $partId);
        $stmt->execute();
        $stmt->close();

        // Novirza uz administratora informācijas paneli pēc detaļas dzēšanas
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

<?php include 'includes/navbar.php'; ?>

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
