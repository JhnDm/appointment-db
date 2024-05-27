<?php
// Start session and include functions file
session_start();
require_once 'functions.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Get user information from the session
$username = $_SESSION['username'];

// You can fetch additional user information from the database if needed

// Close the PHP tag to write HTML content
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            background-image: url('purpleback.jpg'); /* Add the path to your background image */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: white; /* Set text color to white */
        }
        .w3-white {
            background-color: plum !important; /* Add transparency to navbar background */
            color: black !important; /* Ensure navbar text is black */
        }
        .w3-container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for readability */
            padding: 20px;
            border-radius: 10px;
        }
        .w3-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Top menu -->
<div class="w3-top">
    <div class="w3-white w3-xlarge" style="max-width:1600px;margin:auto">
        <div class="w3-right w3-padding-16">
            <!-- Logout form -->
            <form method="post" style="display:inline;">
                <input type="submit" name="logout" value="Logout" class="w3-button w3-purple">
            </form>
        </div>
        <div class="w3-center w3-padding-16">Profile</div>
    </div>
</div>

<!-- Content -->
<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
    <div class="w3-container">
        <h2>Hi! <?php echo $username; ?></h2>
        <p>Leaving Already? Won't book a cake?</p>
        <a href="home.php" class="w3-button w3-purple">Back to Home</a> <!-- Back to Home button -->
    </div>
</div>

<!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
    <a href="add_product.php" class="w3-bar-item w3-button">Add Product</a>
    <a href="book_appointment.php" class="w3-bar-item w3-button">Book Appointment</a>
</nav>

<script>
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
    }
</script>

</body>
</html>
