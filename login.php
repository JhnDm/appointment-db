<?php
require 'db.php';
require 'functions.php';

if (isset($_SESSION['username'])) {
    // Check if the user is an admin
    if (isAdmin($_SESSION['username'])) {
        header("Location: admin_panel.php");
    } else {
        header("Location: home.php");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginUser($username, $password)) {
        // Check if the user is an admin
        if (isAdmin($username)) {
            header("Location: admin_panel.php");
        } else {
            header("Location: home.php");
        }
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* Additional CSS for background photo */
    body {
      background-image: url('purpleback.jpg'); /* Path to your background photo */
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
      display: flex; /* Add flexbox layout */
      justify-content: flex-end; /* Align items to the flex end (right side) */
      align-items: center; /* Center vertically */
      height: 100vh; /* Set full viewport height */
    }
    .container.login {
      background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for better readability */
      padding: 20px;
      border-radius: 10px;
      max-width: 300px;
    }
    .container.login h2 {
      text-align: center;
    }
    .container.login form {
      margin-top: 20px;
    }
    .container.login form label {
      display: block;
      margin-bottom: 5px;
    }
    .container.login form input[type="text"],
    .container.login form input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .container.login form input[type="submit"] {
      background-color: purple;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }
    .container.login form input[type="submit"]:hover {
      background-color: purple;
    }
    .container.login p {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="container login">
    <h2>Login</h2>
    <form action="login.php" method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
