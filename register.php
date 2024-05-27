<?php
require 'db.php';
require 'functions.php';

if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $carrier = $_POST['carrier'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;

    if (!empty($username) && !empty($password) && !empty($email) && !empty($phone) && !empty($carrier)) {
        $result = registerUser($username, $password, $email, $phone, $carrier, $isAdmin);
        if ($result === "User registered successfully") {
            header("Location: login.php");
            exit;
        } else {
            $error = $result;
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
    .container.register {
      background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for better readability */
      padding: 20px;
      border-radius: 10px;
      max-width: 300px;
    }
    .container.register h2 {
      text-align: center;
    }
    .container.register form {
      margin-top: 20px;
    }
    .container.register form label {
      display: block;
      margin-bottom: 5px;
    }
    .container.register form input[type="text"],
    .container.register form input[type="password"],
    .container.register form input[type="email"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .container.register form select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .container.register form input[type="submit"] {
      background-color: purple;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }
    .container.register form input[type="submit"]:hover {
      background-color: purple;
    }
    .container.register p {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="container register">
    <h2>Register</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>

      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <label for="phone">Phone:</label>
      <input type="text" name="phone" id="phone" required>

      <label for="carrier">Carrier:</label>
      <select name="carrier" id="carrier" required>
        <option value="globe">Globe</option>
        <option value="smart">Smart</option>
        <!-- Add more carriers as needed -->
      </select>

      <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>
