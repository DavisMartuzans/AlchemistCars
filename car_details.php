<?php
session_start();

require_once('db_credentials.php');

// Check if car ID is passed in the URL
if (!isset($_GET['id'])) {
    // If car ID is not specified, redirect to the cars listing page
    header("Location: cars.php");
    exit();
}

// Get car data from the database using the specified ID
$carId = $_GET['id'];
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $carId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch car data
if ($result->num_rows === 0) {
    // If no car is found with the specified ID, redirect to the cars listing page
    header("Location: cars.php");
    exit();
}

$car = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Details - <?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }

        .car-info img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .car-details {
            text-align: center;
        }

        .car-details h3 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .car-details p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .car-details p span {
            font-weight: bold;
        }

        .car-details .price {
            font-size: 36px;
            color: #007bff;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .action-buttons a {
            display: inline-block;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .rent-button {
            background-color: #007bff;
            color: #fff;
        }

        .rent-button:hover {
            background-color: #0056b3;
        }

        .buy-button {
            background-color: #28a745;
            color: #fff;
        }

        .buy-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <div class="car-info">
        <img src="Components/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>">
        <div class="car-details">
            <h3><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h3>
            <p class="price">$<?php echo htmlspecialchars(number_format($car['price'], 2)); ?></p>
            <p><span>Year:</span> <?php echo htmlspecialchars($car['year']); ?></p>
            <p><span>Description:</span> <?php echo htmlspecialchars($car['description']); ?></p>
            <div class="action-buttons">
                <a href="rent.php?id=<?php echo htmlspecialchars($carId); ?>" class="rent-button">Rent</a>
                <a href="buy.php?id=<?php echo htmlspecialchars($carId); ?>" class="buy-button">Buy</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
