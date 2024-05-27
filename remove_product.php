<?php
require_once 'functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the logged-in user is an admin
if (!isAdmin($_SESSION['username'])) {
    // Redirect non-admin users to home.php
    header("Location: home.php");
    exit;
}

// Check if the product ID is provided in the request
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Remove the product from the database
    $conn = dbConnect();
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
    $conn = null;

    // Redirect back to home.php after removing the product
    header("Location: home.php");
    exit;
} else {
    // Redirect to home.php if the product ID is not provided
    header("Location: home.php");
    exit;
}
?>
