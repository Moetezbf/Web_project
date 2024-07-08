<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="../assets/css/loginstyle.css">
  <link rel="shortcut icon" type="image/x-icon" href="./assets/img/clients/icon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (isset($_GET['error'])): ?>
      <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
<?php
require("../conf.php");
$alert = 0; // Initialize the $alert variable to 0

function testInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = testInput($_POST["email"]);
  $password = testInput($_POST["password"]);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: login.php?error=Invalid email format");
    exit();
  }

  try {
    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM administrateur WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
      $stored_password = $result['mot_passe']; // Assuming 'mot_passe' is the column name for password
      // Verify the password
      if (password_verify($password, $stored_password)) { // Using password_verify for secure password comparison
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['nom'] = $result['nom'];
        $_SESSION['id'] = $result['id'];
        $_SESSION['mot_passe'] = $result['mot_passe']; // Not sure why you want to store password in session
        $alert = 1; // Update $alert to 1 only if login succeeds
        header("Location: rent.php");
        exit();
      } else {
        header("Location: login.php?error=Incorrect password");
        exit();
      }
    } else {
      header("Location: login.php?error=User not found");
      exit();
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<script>
<?php if ($alert == 1): ?>
  Swal.fire({
    title: 'Bienvenue!',
    text: 'Connexion réussie!',
    icon: 'success'
  }).then(() => {
    window.location.href = 'rent.php'; // Redirection vers rent.php après la fermeture de l'alerte
  });
<?php endif; ?>
</script>
</html>
