<?php
// Datubāzes dati
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AlchemistCars";

// Izveido savienojumu
$conn = new mysqli($servername, $username, $password, $dbname);

// Pārbauda savienojumu
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
