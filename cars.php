<?php
$cars = array(
  array("make" => "bmw", "model" => "330i", "year" => 2002),
  array("make" => "bmw", "model" => "328i", "year" => 1994),
  array("make" => "mercedes", "model" => "E200", "year" => 2002),
  array("make" => "mercedes", "model" => "E300", "year" => 1994),
  array("make" => "audi", "model" => "A6", "year" => 2002),
  array("make" => "audi", "model" => "A4", "year" => 1994)
);

if(isset($_GET["submit"])) {
  $make = $_GET["make"];
  $year = $_GET["year"];
  
  $filtered_cars = array();
  foreach($cars as $car) {
    if($car["make"] == $make && $car["year"] == $year) {
      $filtered_cars[] = $car;
    }
  }
  
  if(count($filtered_cars) > 0) {
    // Display filtered cars
    echo "<ul>";
    foreach($filtered_cars as $car) {
      echo "<li>" . $car["make"] . " " . $car["model"] . " " . $car["year"] . "</li>";
    }
    echo "</ul>";
  } else {
    // No cars found
    echo "No cars found.";
  }
}

foreach ($cars as $car) {
    // Check if the car matches the selected filters
    if (($make == 'all' || $car['make'] == $make)
        && ($model == 'all' || $car['model'] == $model)
        && ($year == 'all' || $car['year'] == $year)) {
      // If the car matches the selected filters, display its information
      echo '<div>';
      echo '<h3>' . $car['make'] . ' ' . $car['model'] . '</h3>';
      echo '<p>Year: ' . $car['year'] . '</p>';
      echo '<p>Price: $' . $car['price'] . '</p>';
      echo '</div>';
    }
  }
?>