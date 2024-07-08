<?php
session_start();
require_once("./conf.php");

$alert = 0;

function testinput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = testinput($_POST["name"]);
    $email = testinput($_POST["email"]);
    $password = testinput($_POST["password"]);
    $hashed_password = hash('sha512', $password);
    $CIN = testinput($_POST["cin"]);
    $numtel = testinput($_POST["telephone"]);
    $age = testinput($_POST["age"]);
    $licenseNum = testinput($_POST["license"]);
    $conf_password = testinput($_POST["confirm-password"]);

    if ($password == $conf_password) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";  
        try {
            $conn = new PDO($dsn, DB_USER, DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO clients (name, email, CIN, age, licenseNum, password, numtel) 
                    VALUES (:name, :email, :CIN, :age, :licenseNum, :password, :numtel)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':CIN', $CIN);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':licenseNum', $licenseNum);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':numtel', $numtel);
            $stmt->execute();
            $alert = 1;
        } catch (PDOException $e) {
            $error_message = 'Error: ' . $e->getMessage();
        }
    } else {
        $password_mismatch_error = 'Passwords do not match';
    }
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="./assets/css/signupstyle.css">
    <link rel="shortcut icon" type="image/icon" href="./assets/img/clients/icon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css">
</head>

<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="cin">CIN :</label>
                <input type="text" id="cin" name="cin" required>
            </div>
            <div class="form-group">
                <label for="telephone">Telephone Number:</label>
                <input type="tel" id="telephone" name="telephone" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="license">Driver's License:</label>
                <input type="text" id="license" name="license" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <div id="error-message">
                <?php
                if (isset($error_message)) {
                    echo $error_message;
                }
                if (isset($password_mismatch_error)) {
                    echo $password_mismatch_error;
                }
                ?>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
    <?php
    if ($alert == 1) {
        echo "<script>
       Swal.fire({
        title: 'Bravo?',
        text: 'Successful signup?',
       icon: 'question'
        });.then(() => {
          window.location.href = 'login.php'; // Redirection vers login.php après la fermeture de l'alerte
      });
        </script>";
    }
    ?>
</body>

</html>
