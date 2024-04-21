<?php
session_start();
require_once('db_credentials.php');

// Check if car ID is provided in the URL
if (!isset($_GET['id'])) {
    // If car ID is missing, redirect back to the cars page
    header("Location: cars.php");
    exit();
}

// Retrieve the car details from the database using the provided ID
$carId = $_GET['id'];
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $carId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the car data
if ($result->num_rows === 0) {
    // If no car found with the given ID, redirect back to the cars page
    header("Location: cars.php");
    exit();
}

$car = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rent Car - <?php echo $car['make'] . ' ' . $car['model']; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</head>

<?php include 'includes/navbar.php'; ?>

<body>
    <div class="container">
        <h2>Rent Car - <?php echo $car['make'] . ' ' . $car['model']; ?></h2>
        <div class="car-info">
            <img src="Components/<?php echo $car['image']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>">
            <h3><?php echo $car['make'] . ' ' . $car['model']; ?></h3>
            <p>Price: $<?php echo $car['price']; ?></p>
            <p>Year: <?php echo $car['year']; ?></p>
            <p>Description: <?php echo $car['description']; ?></p>
            <form id="rent-form" action="process_rent.php" method="post">
                <label for="pickup-date">Pickup Date:</label>
                <input type="date" id="pickup-date" name="pickup_date" required>

                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end_date" required>

                <input type="hidden" name="car_id" value="<?php echo $carId; ?>">

                <button id="rent-now" type="button" class="rent-button">Rent Now</button>
            </form>
        </div>
    </div>
<div class="container" id="payment-form" style="display: none;"> 

    <div class="container"> 

        <form action="#"> 

            <div class="row"> 

                <div class="col"> 
                    <h3 class="title"> 
                        Billing Address 
                    </h3> 

                    <div class="inputBox"> 
                        <label for="name"> 
                            Full Name: 
                        </label> 
                        <input type="text" id="name"
                            placeholder="Enter your full name"
                            required> 
                    </div> 

                    <div class="inputBox"> 
                        <label for="email"> 
                            Email: 
                        </label> 
                        <input type="text" id="email"
                            placeholder="Enter email address"
                            required> 
                    </div> 

                    <div class="inputBox"> 
                        <label for="address"> 
                            Address: 
                        </label> 
                        <input type="text" id="address"
                            placeholder="Enter address"
                            required> 
                    </div> 

                    <div class="inputBox"> 
                            <label for="country"> 
                                Country: 
                            </label> 
                            <input type="text" id="country"
                                placeholder="Enter country"
                                required> 
                        </div> 

                    <div class="flex"> 

                        <div class="inputBox"> 
                        <label for="city"> 
                            City: 
                        </label> 
                        <input type="text" id="city"
                            placeholder="Enter city"
                            required> 
                    </div> 
                        <div class="inputBox"> 
                            <label for="zip"> 
                                Zip Code: 
                            </label> 
                            <input type="text" id="zip"
                              placeholder="LV-1000"
                              required>
                        </div> 

                    </div> 

                </div> 
                <div class="col"> 
                    <h3 class="title">Payment</h3> 

                    <div class="inputBox"> 
                        <label for="name"> 
                            Card Accepted: 
                        </label> 
                        <img src="Components/cards.jpg"
                            alt="credit/debit card image" class="credit-card-image"> 
                    </div> 

                    <div class="inputBox"> 
                        <label for="cardName"> 
                            Name On Card: 
                        </label> 
                        <input type="text" id="cardName"
                            placeholder="Enter card name"
                            required> 
                    </div> 

                    <div class="inputBox"> 
                        <label for="cardNum"> 
                            Credit Card Number: 
                        </label> 
                        <input type="text" id="cardNum"
                            placeholder="1111-2222-3333-4444"
                            maxlength="19" required> 
                    </div> 

                    <div class="inputBox"> 
                        <label for="">Exp Month:</label> 
                        <select name="" id=""> 
                            <option value="">Choose month</option> 
                            <option value="January">January</option> 
                            <option value="February">February</option> 
                            <option value="March">March</option> 
                            <option value="April">April</option> 
                            <option value="May">May</option> 
                            <option value="June">June</option> 
                            <option value="July">July</option> 
                            <option value="August">August</option> 
                            <option value="September">September</option> 
                            <option value="October">October</option> 
                            <option value="November">November</option> 
                            <option value="December">December</option> 
                        </select> 
                    </div> 


                    <div class="flex"> 
                        <div class="inputBox"> 
                            <label for="">Exp Year:</label> 
                            <select name="" id=""> 
                                <option value="">Choose Year</option> 
                                <option value="2023">2023</option> 
                                <option value="2024">2024</option> 
                                <option value="2025">2025</option> 
                                <option value="2026">2026</option> 
                                <option value="2027">2027</option> 
                            </select> 
                        </div> 

                        <div class="text"> 
                            <label for="cvv">CVV</label> 
                            <input type="number" id="cvv"
                                placeholder="412" required> 
                        </div> 
                    </div> 

                </div> 

            </div> 

            <input type="submit" value="Proceed to Checkout"
                class="submit_btn"> 
        </form> 

    </div> 
</div>
    <script>
        let cardNumInput = document.querySelector('#cardNum');

        cardNumInput.addEventListener('keyup', () => {
            let cNumber = cardNumInput.value;
            cNumber = cNumber.replace(/\s/g, "");

            if (Number(cNumber)) {
                cNumber = cNumber.match(/.{1,4}/g);
                cNumber = cNumber.join(" ");
                cardNumInput.value = cNumber;
            }
        });
        $(document).ready(function() {
            $("#rent-now").click(function() {
                var pickupDate = $("#pickup-date").val();
                var endDate = $("#end-date").val();
                if (pickupDate === '' || endDate === '') {
                    alert("Please select pickup and end dates.");
                } else {
                    $("#payment-form").slideDown();
                }
            });
        });
    </script> 

</body>

<style>
.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #04AA6D;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}

.credit-card-image {
    max-width: 100px; /* Adjust the maximum width as needed */
    margin-top: 10px; /* Adjust the margin top as needed */
}
</style>
</html>

