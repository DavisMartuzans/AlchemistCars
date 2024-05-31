<?php
session_start(); // Start the session at the beginning of the script

require_once('db_credentials.php');

// Get cars from the database
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Store cars in an array
$cars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Create URL related to cars_id
        $details_url = "car_details.php?id=" . $row['id'];
        $row['details_url'] = $details_url;
        $cars[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to AlchemistCars</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<section id="cars-section">
    <div id="car-filter">
        <!-- Filtering form with two select fields and a submit button -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
            <!-- Select field for car make -->
            <label for="make">Make:</label>
            <select id="make" name="make">
                <option value="">All Makes</option>
                <?php
                // Find and output unique makes from the cars list
                $unique_makes = array_unique(array_column($cars, 'make'));
                foreach ($unique_makes as $make) {
                    // Determine if this make is selected
                    $selected = (isset($_GET['make']) && $_GET['make'] === $make) ? 'selected' : '';
                    // Output option with make and selected attribute
                    echo '<option value="' . htmlspecialchars($make) . '" ' . $selected . '>' . htmlspecialchars($make) . '</option>';
                }
                ?>
            </select>

            <!-- Select field for car model -->
            <label for="model">Model:</label>
            <select id="model" name="model">
                <option value="">All Models</option>
                <?php
                // Find and output unique models from the cars list
                $unique_models = array_unique(array_column($cars, 'model'));
                foreach ($unique_models as $model) {
                    // Determine if this model is selected
                    $selected = (isset($_GET['model']) && $_GET['model'] === $model) ? 'selected' : '';
                    // Output option with model and selected attribute
                    echo '<option value="' . htmlspecialchars($model) . '" ' . $selected . '>' . htmlspecialchars($model) . '</option>';
                }
                ?>
            </select>

            <!-- Submit button to submit the filtering form -->
            <input type="submit" value="Filter" id="filterButton">
        </form>
    </div>

    <ul id="carList">
        <?php
        // Copying the initial cars array to $filtered_cars variable
        $filtered_cars = $cars;

        // Check if URL has 'make' set and it's not empty
        if (isset($_GET['make']) && $_GET['make'] !== '') {
            $make = $conn->real_escape_string($_GET['make']); // Sanitize user input
            // Filter cars by 'make'
            $filtered_cars = array_filter($filtered_cars, function ($car) use ($make) {
                return $car['make'] === $make;
            });
        }

        // Check if URL has 'model' set and it's not empty
        if (isset($_GET['model']) && $_GET['model'] !== '') {
            $model = $conn->real_escape_string($_GET['model']); // Sanitize user input
            // Filter cars by 'model'
            $filtered_cars = array_filter($filtered_cars, function ($car) use ($model) {
                return $car['model'] === $model;
            });
        }

        // Iterate through filtered cars and output information
        foreach ($filtered_cars as $car) {
            echo '<div class="card">';
            echo '<img src="Components/' . htmlspecialchars($car['image']) . '" alt="' . htmlspecialchars($car['make']) . ' ' . htmlspecialchars($car['model']) . '" style="width:100%">';
            echo '<h3>' . htmlspecialchars($car['make']) . ' ' . htmlspecialchars($car['model']) . '</h3>';
            echo '<p class="price">Price: $' . htmlspecialchars($car['price']) . '</p>';
            echo '<p>Year: ' . htmlspecialchars($car['year']) . '</p>';
            echo '<button id="learn-more"><a href="' . htmlspecialchars($car['details_url']) . '">View Car</a></button>';
            echo '</div>';
        }
        ?>
    </ul>
</section>

<style>
    /* Car filter */
#car-filter {
    margin: 0 auto;
    max-width: 600px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#car-filter form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

#car-filter label {
    margin-bottom: 5px;
}

#car-filter select,
#car-filter input[type="submit"] {
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

#car-filter select {
    width: 100%;
}

#car-filter input[type="submit"] {
    background-color: #454545;
    color: #fff;
    border: none;
    cursor: pointer;
}

#car-filter input[type="submit"]:hover {
    background-color: #000;
}

#filterButton {
    width: 100%;
    padding: 10px;
    background-color: #454545;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

#filterButton:hover {
    background-color: #000;
}

/* Car cards */
.card {
    width: 300px;
    height: 400px;
    box-shadow: 2px 2px 5px #ccc;
    border-radius: 10px;
    overflow: hidden;
    margin: 10px;
    display: inline-block;
    text-align: center;
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card h3 {
    margin: 10px;
    font-size: 18px;
}

.card p {
    margin: 10px;
    font-size: 14px;
}

.card a {
    text-decoration: none;
    color: inherit;
}

.card button {
    margin-top: 10px;
    padding: 10px;
    border: none;
    background-color: #454545;
    color: white;
    cursor: pointer;
}

.card button:hover {
    background-color: #000;
}
</style>
</body>
</html>
