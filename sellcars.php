<?php
session_start();
require_once('db_credentials.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle the uploaded image
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_type = $_FILES['image']['type'];
    $image_size = $_FILES['image']['size'];

    // Check if the file is an image
    if (strpos($image_type, 'image') !== false) {
        // Move the uploaded image to the desired directory
        $target_directory = 'Components/';
        $target_file = $target_directory . basename($image_name);

        if (move_uploaded_file($image_tmp, $target_file)) {
            // Image uploaded successfully, insert the car details into the database
            $sql = "INSERT INTO cars (make, model, year, price, description, image)
            VALUES ('$make', '$model', '$year', '$price', '$description', '$image_name')";

            if ($conn->query($sql) === TRUE) {
                // Record created successfully, redirect to a success page
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Invalid file type. Only image files are allowed.";
    }

    $conn->close();
}
?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Sell Your Car</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>
  
<?php include 'includes/navbar.php'; ?>

<body>
<div class="selling-form">
    <div class="selling-container">
    <form class="sellcars" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  <h2>Sell Your Car</h2>
  
  <label for="make">Make:</label>
  <input type="text" id="make" name="make" required>

  <label for="model">Model:</label>
  <input type="text" id="model" name="model" required>

  <label for="year">Year:</label>
  <input type="number" id="year" name="year" required min="0" >

  <label for="price">Price:</label>
  <input type="number" id="price" name="price" required min="0">

  <label for="description">Description:</label>
  <textarea id="description" name="description" required></textarea>

  <label for="image">Upload Image:</label>
  <input type="file" id="image" name="image" accept="image/*" required>

  <input class="filterButton" type="submit" value="Submit">
</form>

    </div>
</div>

</body>
<style>
  /* Selling form */
  .selling-form {
    position: relative;
    top: 80px;
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
  }

  .selling-container {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
  }

  .selling-container h1 {
    margin-top: 0;
  }

  .selling-container label {
    display: block;
    margin-bottom: 5px;
  }

  .selling-container input,
  .selling-container textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: 'Lato', sans-serif;
  }

  .selling-container .filterButton {
    background-color:#454545;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  .selling-container .filterButton:hover {
    background-color: #000000;
  }

</style>
</html>
