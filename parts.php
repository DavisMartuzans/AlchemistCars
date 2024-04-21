<?php
// Sāk sesiju
session_start();

// Pārbauda, vai lietotājs ir pierakstījies
if (!isset($_SESSION['username'])) {
    // Novirza uz pierakstīšanās lapu vai rāda kļūdas ziņojumu
    header("Location: signin.php");
    exit();
}

// Pievieno datubāzes piekļuves datus
require_once('db_credentials.php');

// Pārbauda, vai forma ir nosūtīta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iegūst formas datus
    $partName = $_POST["partName"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_FILES["image"]["name"];

    // Nosaka mērķa direktoriju, lai saglabātu augšupielādētos attēlus
    $targetDir = "Components/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    // Pārvieto augšupielādēto failu uz mērķa direktoriju
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Ievieto daļas datus datubāzē
        $sql = "INSERT INTO parts (part_name, description, price, image) VALUES ('$partName', '$description', '$price', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo "Part added successfully";
            // Novirza uz citu lapu pēc veiksmīgas formas nosūtīšanas
            header("Location: parts.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Izgūst detaļas no datubāzes
$sql = "SELECT * FROM parts";
$result = $conn->query($sql);

// Aizver datubāzes pieslēgumu
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

<?php include 'includes/navbar.php'; ?>

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
            echo '<form action="buy.php" method="post">';
            echo '<input type="submit" value="Buy" class="btn btn-primary">';
            echo '</form>';
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
      font-weight: bold;
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }

    .about {
      font-size: 20px;
      text-align: center;
      margin-bottom: 20px;
    }
    
    /* Parts */
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
