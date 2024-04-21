<?php
session_start();
require_once('db_credentials.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['user_id'];
    $carId = $_POST['car_id'];
    $fullName = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $zipCode = $_POST['zip'];
    $cardName = $_POST['cardName'];
    $cardNumber = $_POST['cardNum'];
    $expMonth = $_POST['expMonth'];
    $expYear = $_POST['expYear'];
    $cvv = $_POST['cvv'];

    // Insert billing address into billing_addresses table
    $billingSql = "INSERT INTO billing_addresses (user_id, full_name, email, address, country, city, zip_code) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $billingStmt = $conn->prepare($billingSql);
    $billingStmt->bind_param("issssss", $userId, $fullName, $email, $address, $country, $city, $zipCode);
    $billingStmt->execute();

    // Insert payment information into payment_info table
    $paymentSql = "INSERT INTO payment_info (user_id, card_name, card_number, exp_month, exp_year, cvv) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $paymentStmt = $conn->prepare($paymentSql);
    $paymentStmt->bind_param("isssii", $userId, $cardName, $cardNumber, $expMonth, $expYear, $cvv);
    $paymentStmt->execute();

    // Close database connection
    $conn->close();

    // Redirect to a success page or perform other actions
    header("Location: success.php");
    exit();
} else {
    // If the form is not submitted via POST method, redirect back to the form page
    header("Location: rent_car.php?id=" . $carId);
    exit();
}
?>
