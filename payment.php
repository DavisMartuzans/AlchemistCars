<?php
session_start();

// Retrieve order information based on the session variables set from the previous pages
$orderType = $_SESSION['order_type'];
$orderDetails = '';

if ($orderType == 'car') {
    $orderDetails = 'Car: ' . $_SESSION['car_name'] . ', Price: $' . $_SESSION['car_price'];
} elseif ($orderType == 'part') {
    $orderDetails = 'Part: ' . $_SESSION['part_name'] . ', Price: $' . $_SESSION['part_price'];
} elseif ($orderType == 'rent') {
    $orderDetails = 'Rental: ' . $_SESSION['rental_details'] . ', Price: $' . $_SESSION['rental_price'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <!-- Include CSS stylesheets and other necessary resources -->
</head>

<body>
    <div class="container" id="payment-form">
        <div class="container">
            <form action="payment_process.php" method="post">
                <div class="row">
                    <div class="col">
                        <h3 class="title">Billing Address</h3>
                        <!-- Display order details here -->
                        <p><?php echo $orderDetails; ?></p>

                        <div class="inputBox">
                            <label for="name">Full Name:</label>
                            <input type="text" id="name" placeholder="Enter your full name" required>
                        </div>

                        <!-- Other billing address fields -->

                    </div>
                    <div class="col">
                        <h3 class="title">Payment</h3>
                        <div class="inputBox">
                            <label for="cardName">Name On Card:</label>
                            <input type="text" id="cardName" placeholder="Enter card name" required>
                        </div>

                        <!-- Other payment fields -->

                    </div>
                </div>
                <input type="submit" value="Proceed to Checkout" class="submit_btn">
            </form>
        </div>
    </div>
</body>

</html>
