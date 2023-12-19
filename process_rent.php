<?php
// Sāk sesiju
session_start();
// Pievieno datubāzes piekļuves datus
require_once('db_credentials.php');

// Pārbauda, vai lietotājs ir pierakstījies
if (!isset($_SESSION['username'])) {
    // Ja nav pierakstījies, novirza uz pierakstīšanās lapu
    header("Location: signin.php");
    exit();
}

// Izgūst un saglabā lietotāja ID no datubāzes
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

// Pārbauda, vai forma ir nosūtīta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Izgūst formas datus
    $pickupDate = $_POST['pickup_date'];
    $endDate = $_POST['end_date'];
    $carId = $_POST['car_id'];

    // Ievieto nomas datus nomas tabulā
    $sql = "INSERT INTO rentals (car_id, user_id, pickup_date, end_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $carId, $userId, $pickupDate, $endDate);
    $stmt->execute();

    // Pārbauda, vai nomas ieraksts ir veiksmīgi pievienots
    if ($stmt->affected_rows > 0) {
        // Novirza uz nomas veiksmes lapu
        header("Location: index.php");
        exit();
    } else {
        // Notika kļūda, novirza atpakaļ uz nomas lapu ar kļūdas ziņojumu
        header("Location: rent.php?id=$carId&error=1");
        exit();
    }
}

// Ja forma nav nosūtīta vai ir kļūda, novirza atpakaļ uz nomas lapu
header("Location: rent.php?id=$carId");
exit();

$conn->close();
?>
