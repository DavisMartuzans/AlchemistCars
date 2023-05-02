<?php
require_once('db_credentials.php');

$make = $_POST['make'];
$model = $_POST['model'];
$year = $_POST['year'];
$price = $_POST['price'];
$description = $_POST['description'];
$contact = $_POST['contact'];

$sql = "INSERT INTO cars (make, model, year, price, description, contact)
VALUES ('$make', '$model', '$year', '$price', '$description', '$contact')";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("New record created successfully");</script>';
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
