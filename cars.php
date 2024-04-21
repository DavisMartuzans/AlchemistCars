<?php
require_once('db_credentials.php');

// Get cars from the database
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

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
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Welcome to AlchemistCars</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
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
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <!-- Select field for car make -->
            <label for="make">Make:</label>
            <select id="make" name="make">
                <option value="">All Makes</option>
                <?php
                // Find and output unique makes from the cars list
                $unique_makes = array_unique(array_column($cars, 'make'));
                foreach ($unique_makes as $make) {
                    // Determine if this make is selected
                    $selected = isset($_GET['make']) && $_GET['make'] === $make ? 'selected' : '';
                    // Output option with make and selected attribute
                    echo '<option value="' . $make . '" ' . $selected . '>' . $make . '</option>';
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
                    $selected = isset($_GET['model']) && $_GET['model'] === $model ? 'selected' : '';
                    // Output option with model and selected attribute
                    echo '<option value="' . $model . '" ' . $selected . '>' . $model . '</option>';
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
            // Filter cars by 'make'
            $filtered_cars = array_filter($filtered_cars, function ($car) {
                return $car['make'] === $_GET['make'];
            });
        }

        // Check if URL has 'model' set and it's not empty
        if (isset($_GET['model']) && $_GET['model'] !== '') {
            // Filter cars by 'model'
            $filtered_cars = array_filter($filtered_cars, function ($car) {
                return $car['model'] === $_GET['model'];
            });
        }

        // Iterate through filtered cars and output information
        foreach ($filtered_cars as $car) {
            echo '<div class="card">';
            echo '<img src="Components/' . $car['image'] . '" alt="' . $car['make'] . ' ' . $car['model'] . '" style="width:100%">';
            echo '<h3>' . $car['make'] . ' ' . $car['model'] . '</h3>';
            echo '<p class="price">Price: $' . $car['price'] . '</p>';
            echo '<p>Year: ' . $car['year'] . '</p>';
            echo '<button id="learn-more"><a href="' . $car['details_url'] . '">View Car</a></button>';
            echo '</div>';
        }
        ?>
    </ul>
</section>
<style>
    /* Mašīnu filtrs */
#car-filter {
    margin: 0 auto;
    max-width: 600px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#car-filter form {
    display: inline-flex;
    flex-direction: row;
    gap: 10px;
}

#car-filter label {
    flex-basis: 100%;
}

#car-filter select,
#car-filter input[type="submit"] {
    margin: 10px 0;
    padding: 5px;
    border-radius: 5px;
}

#car-filter select {
    flex-basis: calc(33.33% - 10px);
}

#car-filter input[type="submit"] {
    flex-basis: 100%;
    background-color: #454545;
    color: #fff;
    border: none;
    cursor: pointer;
}

#car-filter input[type="submit"]:hover {
    background-color: #454545;
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

/* Mašīnu kārtis */
.card {
    width: 300px;
    height: 400px;
    box-shadow: 2px 2px 5px #ccc;
    border-radius: 10px;
    overflow: hidden;
    margin: 10px;
    display: inline-block;
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
</style>
</body>
</html>
