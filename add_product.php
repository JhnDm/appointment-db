<?php
require_once 'functions.php';

if (!isset($_SESSION['username']) || !isAdmin($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if the file is uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_type = $_FILES['image']['type'];

        // Create the uploads directory if it doesn't exist
        $uploads_dir = 'uploads';
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        // Move the uploaded file to the desired location
        $target_path = $uploads_dir . '/' . basename($image_name);
        if (move_uploaded_file($image_tmp, $target_path)) {
            echo "Image uploaded successfully!";
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Please select an image file.";
    }

    if (!empty($name) && !empty($price)) {
        $conn = dbConnect();
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $description, PDO::PARAM_STR);
        $stmt->bindValue(3, $price, PDO::PARAM_STR); // Use PDO::PARAM_STR for decimal values
        $stmt->bindValue(4, $target_path, PDO::PARAM_STR); // Add $target_path as image URL
        if ($stmt->execute()) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        /* Additional CSS for Add Product */
        body, h1, h2, h3, h4, h5, h6 {font-family: "Karma", sans-serif}
        .w3-bar-block .w3-bar-item {padding: 20px}
        
        /* Background image */
        body {
            background-image: url('purpleback.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .container label {
            display: block;
            margin-bottom: 5px;
        }
        
        .container input[type="text"],
        .container input[type="number"],
        .container input[type="file"], /* Added file input styling */
        .container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        
        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #8E44AD;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .container input[type="submit"]:hover {
            background-color: #7A378B;
        }
        
        .container p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="w3-main w3-content w3-padding" style="max-width:1200px; margin-top:100px">
    <div class="container">
        <h2>Add Product</h2>
        <form action="add_product.php" method="post" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" required>

            <label for="image">Product Image:</label> <!-- Added image input -->
            <input type="file" name="image" id="image" accept="image/*">

            <input type="submit" value="Add Product">
        </form>
        <p><a href="home.php">Back to Home</a></p>
    </div>
</div>
</body>
</html>
