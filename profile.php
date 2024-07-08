<?php
session_start();
require("./conf.php");

// Simulated client data (replace with database query)
$clientData = array(
    'id' => isset($_SESSION['id']) ? $_SESSION['id'] : '',
    'name' => isset($_SESSION["name"]) ? $_SESSION["name"] : '',
    'email' => isset($_SESSION['email']) ? $_SESSION['email'] : '',
    'phone' => isset($_SESSION['phone']) ? $_SESSION['phone'] : '',
    'password' => isset($_SESSION["password"]) ? $_SESSION["password"] : '',
    'profile_image' => 'default_profile.jpg'
);

// Check if the form is submitted
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Update client data in the database
    $clientData['id'] = $_SESSION['id'];
    $clientData['name'] = $_POST['name'];
    $clientData['email'] = $_POST['email'];
    $clientData['phone'] = $_POST['phone'];
    $clientData['password'] = $_POST['password'];

    // Hash the password securely using SHA-512
    $hashed_password = hash('sha512', $clientData['password']);

    try {
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE clients SET name = :name, email = :email, numtel = :phone WHERE id = :id");
        $stmt->bindParam(":id", $clientData['id']);
        $stmt->bindParam(":name", $clientData['name']);
        $stmt->bindParam(":email", $clientData['email']);
        $stmt->bindParam(":phone", $clientData['phone']);
        $stmt->execute();

        if (!empty($clientData['password']) && $clientData['password'] != '') {
            $stmt = $conn->prepare("UPDATE clients SET password = :password WHERE id = :id");
            $stmt->bindParam(":id", $clientData['id']);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->execute();
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    if ($_FILES['profile_image']['name']) {
        // Get the user's ID or username to use as the folder name
        $user_folder = isset($_SESSION['id']) ? $_SESSION['id'] : '';

        // Create the folder if it doesn't exist
        $target_dir = "./uploads/{$user_folder}/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the folder recursively
        }

        // Proceed with file upload
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual image or fake image
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check === false) {
            echo '<div class="alert alert-danger" role="alert">File is not an image.</div>';
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo '<div class="alert alert-danger" role="alert">Sorry, file already exists.</div>';
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_image"]["size"] > 500000) {
            echo '<div class="alert alert-danger" role="alert">Sorry, your file is too large.</div>';
            $uploadOk = 0;
        }// Allow certain file formats
        $allowed_formats = ["jpg", "png", "jpeg", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            echo '<div class="alert alert-danger" role="alert">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
            $uploadOk = 0;
        }

        // Check if $upload
            // Check if $uploadOk is set to 0 by an error
            if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
                echo '<div class="alert alert-danger" role="alert">Sorry, there was an error uploading your file.</div>';
                exit;
            }

            // Attempt to move the uploaded file to the target directory
            if ($uploadOk == 1 && move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $uploaded_file_path = $target_dir . basename($_FILES["profile_image"]["name"]);
                echo '<div class="alert alert-success" role="alert">The file ' . htmlspecialchars($uploaded_file_path) . ' has been uploaded.</div>';

                // Add the image information to the database
                try {
                    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("INSERT INTO clients_images (client_id, image_name, image_path, upload_timestamp) VALUES (:client_id, :image_name, :image_path, :upload_timestamp)");
                    $stmt->bindParam(":client_id", $_SESSION['id']);
                    $stmt->bindParam(":image_name", $_FILES["profile_image"]["name"]);
                    $stmt->bindParam(":image_path", $target_file);
                    $stmt->bindValue(":upload_timestamp", date('Y-m-d H:i:s'));
                    $stmt->execute();

                    // Update the clientData array with the uploaded image filename
                    $clientData['profile_image'] = $uploaded_file_path;
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Sorry, there was an error uploading your file.</div>';
            }
        }





}


// Retrieve the client's profile image from the database

try {

    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $conn->prepare("SELECT image_path FROM clients_images WHERE client_id = :client_id ORDER BY upload_timestamp DESC LIMIT 1");

    $stmt->bindParam(':client_id', $clientData['id']);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($result) {

        $clientData['profile_image'] = $result['image_path'];
        $_SESSION['image']=$clientData['profile_image'];

    }

} catch(PDOException $e) {

    echo "Error: " . $e->getMessage();

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/clients/icon.ico">
    <style>
        /* Custom styles */
        body {
            background-color: #f8f9fa;
        }
        .profile-image {
            max-width: 150px;
        }
        .profile-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-form input[type="file"] {
            display: none;
        }
        .profile-form input[type="file"]+label {
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .profile-form input[type="file"]+label:hover {
            background-color: #0056b3;
        }
        .aside-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .aside-container h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .aside-container ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .aside-container ul li {
            margin-bottom: 10px;
        }
        .aside-container ul li a {
            color: #007bff;
            text-decoration: none;
        }
        .aside-container ul li a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Tunisia Rent Cars</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="rent.php">Rent a Car</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8">
                <div class="profile-container">
                    <div class="text-center mb-4">
                    <img class="rounded-circle profile-image" id="profileImagePreview" src="<?php echo isset($clientData['profile_image']) ? htmlspecialchars($clientData['profile_image']) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'; ?>" alt="Profile Image">

                        <p class="text-muted"><?php echo $clientData["email"]?></p>
                    </div>
                    <form class="profile-form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $clientData["name"]?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $clientData["email"]?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Mobile Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $clientData["phone"]?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Change Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="">
                        </div>
                        <div class="form-group">
                            <label for="profileImage">Profile Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profile_image" onchange="previewImage()">
                            <label for="profileImage" class="mt-2">Choose File</label>
                            <div id="imageUploadError" class="text-danger mt-2" style="display: none;"></div>
                        </div>
                        <div id="imagePreview" class="mt-2"></div>
                        <button type="submit" class="btn btn-primary btn-block">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function previewImage() {
        var fileInput = document.getElementById('profileImage');
        var imagePreview = document.getElementById('profileImagePreview');

        // Check if any file is selected
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Update the src attribute of the <img> tag
                imagePreview.src = e.target.result;
            }

            // Read the selected file as a data URL
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
</body>
</html>