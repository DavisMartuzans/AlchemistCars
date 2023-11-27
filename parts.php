<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to sign in page or display an error message
    header("Location: signin.php");
    exit();
}

require_once('db_credentials.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $partName = $_POST["partName"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_FILES["image"]["name"];

    // Set the target directory to store the uploaded images
    $targetDir = "Components/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert the part data into the database
        $sql = "INSERT INTO parts (part_name, description, price, image) VALUES ('$partName', '$description', '$price', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo "Part added successfully";
            // Redirect to a different page after successful form submission
            header("Location: parts.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Retrieve parts from the database
$sql = "SELECT * FROM parts";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Parts</title>
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
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<body>
  <h2 class="welcome">Welcome To The Parts Page</h2>
  <h3 class="about"><a href="#" onclick="toggleForm()">Click here</a> to sell your parts</h3>

  <!-- Car part selling form -->
  <div id="partForm" class="part-form" style="display: none;">
    <h2>Sell Your Parts</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
      <label for="partName">Part Name:</label>
      <input type="text" name="partName" required>

      <label for="description">Description:</label>
      <textarea name="description" required></textarea>

      <label for="price">Price:</label>
      <input type="number" name="price" required>

      <label for="image">Image:</label>
      <input type="file" name="image" accept="image/*" required>

      <input type="submit" value="Sell Part">
    </form>
  </div>

  <div class="part-list">
    <h2>Available Parts:</h2>
    <?php
    // Check if there are parts in the result set
    if ($result->num_rows > 0) {
        // Loop through each part and display it
        while ($row = $result->fetch_assoc()) {
            echo '<div class="part-item">';
            echo '<h3>' . $row['part_name'] . '</h3>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<p>Price: $' . $row['price'] . '</p>';
            echo '<img src="Components/' . $row['image'] . '" alt="Part Image">';
            echo '</div>';
        }
    } else {
        echo '<p>No parts available</p>';
    }
    ?>
  </div>
</body>

<script>
  function toggleForm() {
    var form = document.getElementById("partForm");
    if (form.style.display === "none") {
      form.style.display = "block";
    } else {
      form.style.display = "none";
    }
  }
</script>

<style>
    /* Welcome */
    .welcome {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 30px;
        text-align: center;
        margin-bottom: 20px;
    }

    .about {
        font-size: 20px;
        text-align: center;
        margin-bottom: 20px;
    }
    
/*Parts*/
.part-list {
  margin-top: 20px;
}

.part-item {
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
}

.part-item h3 {
  font-size: 18px;
  margin-top: 0;
}

.part-item p {
  margin: 5px 0;
}

.part-item img {
  width: 100%;
  max-width: 200px;
  height: auto;
  margin-top: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

</style>

</html>
