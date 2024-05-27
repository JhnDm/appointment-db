<?php
require_once 'functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$conn = dbConnect();
$stmt = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        /* Additional CSS for Online Shop */
        body {
            background-image: url('purpleback.jpg'); /* Add the path to your background image */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: white; /* Set text color to white */
        }
        .product {
            margin-bottom: 30px;
        }
        .product img {
            width: 100%;
            height: 200px; /* Set a fixed height */
            object-fit: cover; /* Ensures the image covers the element */
        }
        /* CSS for the navigation bar */
        .w3-navbar {
            background-color: plum; /* Set the background color to white */
        }
        .w3-navbar a {
            color: black; /* Set the color of navigation links to black */
        }
        .w3-button {
            color: black; /* Set the color of buttons to black */
        }
    </style>
</head>
<body>

<!-- Top menu -->
<div class="w3-top">
    <div class="w3-white w3-xlarge" style="max-width:1600px;margin:auto">
        <!-- Navigation bar with white background color -->
        <div class="w3-navbar">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
            <div class="w3-right w3-padding-16"><a href="profile.php">Profile</a></div>
            <div class="w3-center w3-padding-16">
                <img src="purpleyamlog-removebg-preview.png" alt="Logo" style="height: 40px;"> <!-- Add your logo path here -->
            </div>
        </div>
    </div>
</div>
<!-- !PAGE CONTENT! -->
<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

    <!-- Product Grid -->
    <div class="w3-row-padding w3-padding-16" id="products">
        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="w3-quarter product">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>" style="width:100%">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p>Price: ₱<?php echo $row['price']; ?></p> <!-- Changed to peso sign -->
                <?php if (isAdmin($_SESSION['username'])): ?>
                    <form action="remove_product.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="submit" value="Remove" class="w3-button w3-red">
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
    <a href="add_product.php" class="w3-bar-item w3-button">Add Product</a>
    <a href="book_appointment.php" class="w3-bar-item w3-button">Book Appointment</a>
    <a href="feedback.php" class="w3-bar-item w3-button">Feedback</a> <!-- Added Feedback link -->
    <a href="view_feedback.php" class="w3-bar-item w3-button">View Feedback</a> <!-- Added View Feedback link -->
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
