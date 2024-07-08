<?php
session_start();
require_once 'conf.php';
$name=isset($_SESSION["name"])?$_SESSION["name"] :"";
// Établir une connexion à la base de données en utilisant PDO
$pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
// Configuration supplémentaire de PDO si nécessaire
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// Préparation de la requête SQL
$sql = "SELECT * FROM voiture;";
$result=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
$_SESSION["id_voiture"]=$result["id_voiture"];
$id_voiture=$_SESSION["id_voiture"];


/*function getData() {

  $postData = filter_input_array(INPUT_POST); // Récupère les données POST filtrées
  $dateDebut = isset($postData["pickDate1"]) ? $postData["pickDate1"] : null;
  $dateFin = isset($postData["returnDate1"]) ? $postData["returnDate1"] : null;
  //$coutTotal = isset($postData["cout_total"]) ? $postData["cout_total"] : null;

  return array("date_debut" => $dateDebut, "date_fin" => $dateFin);
}*/

$_SESSION["db"]=$_POST["pickDate1"];
$_SESSION["df"]=$_POST["returnDate1"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car</title>
    <link rel="stylesheet" href="./assets/css/rentstyle.css">
    <link rel="shortcut icon" type="image/icon" href="./assets/img/clients/icon.ico">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        .navbar {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .navbar-brand:hover {
            color: #ddd;
        }

        .navbar-nav {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar-nav li {
            margin-right: 15px;
        }

        .navbar-nav li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar-nav li a:hover {
            background-color: #555;
        }

        .nav-item img {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #fff;
            transition: transform 0.3s ease; /* Add transition for smooth hover effect */
        }

        .nav-item img:hover {
            transform: scale(1.1); /* Increase size on hover */
        }
    </style>
</head>
<body>
<div class="background">
    <div class="container">
        <h1>Welcome <?php echo $name; ?></h1> <!-- Affichage du nom de l'utilisateur -->
        <div class="car-list">
            <!-- Exemple de formulaire pour une voiture -->
            <div class="car">
                <form method="POST">
                    <img src="./assets/img/clients/Ford.png" alt="Ford">
                    <div class="details">
                        <h2>Ford</h2>
                        <p>Price: $35/day</p>
                        <label for="pickDate1">Pick-up Date:</label>
                        <input type="date" id="pickDate1" name="pickDate1">
                        <label for="returnDate1">Return Date:</label>
                        <input type="date" id="returnDate1" name="returnDate1">
                        <button onclick="rentCar(1)">Rent Now</button> <!-- Appel de la fonction rentCar avec l'ID de la voiture -->
                    </div>
                </form>

            </div>
            <!-- Autres formulaires de voiture ici... -->
        </div>
    </div>
</div>

<script>
    function getPrixParJour(id_voiture) {
        // Fonction à implémenter pour récupérer le prix par jour de la voiture
        // en fonction de son identifiant. Par exemple, vous pouvez utiliser une requête AJAX pour
        // interroger votre base de données et récupérer le prix correspondant.
        // Pour cet exemple, je vais simplement retourner un prix fictif.
        return 65; // Prix fictif de 65 dollars par jour
    }


    function rentCar(id_voiture) {
        var pickDate = document.getElementById("pickDate" + id_voiture).value;
        var returnDate = document.getElementById("returnDate" + id_voiture).value;

        var id_client = <?php echo isset($_SESSION["id"]) ? $_SESSION["id"] : "null"; ?>;

        if (id_client === null) {
            alert("Veuillez vous connecter pour louer une voiture.");
            return;
        }

        var startDate = new Date(pickDate);
        var endDate = new Date(returnDate);
        var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
        var duration = Math.ceil(timeDiff / (1000 * 3600 * 24));

        var prixParJour = getPrixParJour(id_voiture); // Fonction à implémenter pour récupérer le prix par jour de la voiture

        var coutTotal = duration * prixParJour;

        // Utilisation d'une requête AJAX pour envoyer les données au serveur
        $.ajax({
            type: "POST",
            url: "location.php",
            data: {
                id_voiture: id_voiture,
                id_client: id_client,
                date_debut: pickDate,
                date_fin: returnDate,
                ville_reservation: "tunise", // Remplacez "VotreVille" par la ville choisie par l'utilisateur
                cout_total: coutTotal
            },
            success: function(response) {
                alert("Location enregistrée avec succès.");
                window.location.href = "location.php";
            },
            error: function(xhr, status, error) {
                alert("Erreur lors de l'enregistrement de la location.");
            }
        });
    }

</script>
</body>
</html>
