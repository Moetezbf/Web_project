<?php
session_start();
require_once 'conf.php';

// Check if the session variable is set, otherwise assign an empty string
$name = isset($_SESSION["name"]) ? $_SESSION["name"] : "";

// Get the CarId, pickDate, returnDate, and location from the query parameters
$id = isset($_GET["carId"]) ? $_GET["carId"] : "";
$pickDate = isset($_GET["pickDate"]) ? $_GET["pickDate"] : "";
$returnDate = isset($_GET["returnDate"]) ? $_GET["returnDate"] : "";
$location = isset($_GET["location"]) ? $_GET["location"] : "";

try {
    // Establish a connection to the database using PDO
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    // Configure PDO if necessary
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query
    $sql = "SELECT * FROM voiture WHERE id_voiture = ?";
    $stmt = $pdo->prepare($sql);
    // Bind the parameter properly
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    // Execute the query
    $stmt->execute();
    // Fetch the result as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the fetch was successful
    if ($result) {
        // Retrieve the car marque
        $carMarque = $result["marque"];
    } else {
        echo "No data found for CarId: $id";
    }
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}

// Calculate the number of days between pick-up and return dates
$pickTimestamp = strtotime($pickDate);
$returnTimestamp = strtotime($returnDate);
if ($returnTimestamp > $pickTimestamp) {
    // Calculate the number of days between pick-up and return dates
    $days = ($returnTimestamp - $pickTimestamp) / (60 * 60 * 24);
} else {
    // If return date is not after pick-up date, set days to 0 or display an error
    $days = 0;
    // You may also want to display an error message to the user
    echo "Error: Return date must be after pick-up date.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="./assets/css/facturestyle.css"> <!-- Add a separate CSS file for styles -->
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div >
        <a class="navbar-brand" href="#">Tunisia Rent Cars</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rent.php">Rent a Car</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="index.html#contact">contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="facture-details">
        <h2>Facture</h2>
        <p><span>Car:</span> <span id="carName"><?= $carMarque?></span></p>
        <p><span>Price per day:</span> $<?= $result["prix_par_jour"]?></p>
        <p><span>Pick-up Date:</span> <span id="pickDate"><?= $pickDate?></span></p>
        <p><span>Return Date:</span> <span id="returnDate"><?= $returnDate?></span></p>
        <p><span>Location:</span> <span id="location"><?= $location?></span></p>
        <p><span>Total Price:</span> $<?= $result["prix_par_jour"] * $days?></p>
    </div>

    <!-- Pay and Cancel Buttons -->
    <div class="action-buttons">
        <a href="#" class="btn btn-pay" onclick="confirmPayment()">Payer</a>
        <a href="rent.php" class="btn btn-cancel">Annuler</a>
    </div>

    <script>
        function confirmPayment() {
            // Display a confirmation dialog
            var confirmation = confirm("Are you sure you want to proceed with payment?");

            // If the user confirms, proceed with payment
            if (confirmation) {
                // Here you can place your code to proceed with payment
                // For example, you can redirect the user to a payment page
                 window.location.href = "rent.php";
                alert("Payment successful!");
            } else {
                // If the user cancels, do nothing or provide feedback
                alert("Payment cancelled.");
            }
        }
    </script>

</div>
</body>
</html>
