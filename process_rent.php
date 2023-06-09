<?php
session_start();
require_once('db_credentials.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the signin page
    header("Location: signin.php");
    exit();
}

// Retrieve and store the user ID from the database
$userId = null;
$username = $_SESSION['username'];
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $pickupDate = $_POST['pickup_date'];
    $endDate = $_POST['end_date'];
    $carId = $_POST['car_id'];

    // Insert the rental data into the rentals table
    $sql = "INSERT INTO rentals (car_id, user_id, pickup_date, end_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $carId, $userId, $pickupDate, $endDate);
    $stmt->execute();

    // Check if the rental is successfully added
    if ($stmt->affected_rows > 0) {
        // Redirect to the rent success page
        header("Location: main.php");
        exit();
    } else {
        // An error occurred, redirect back to the rent page with an error message
        header("Location: rent.php?id=$carId&error=1");
        exit();
    }
}

// If the form is not submitted or there is an error, redirect back to the rent page
header("Location: rent.php?id=$carId");
exit();

$conn->close();
?>
