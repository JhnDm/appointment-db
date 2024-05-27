<?php
require 'vendor/autoload.php';
require 'db.php';
require 'functions.php';

// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || !isAdmin($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Query database for feedback
$stmt = $pdo->query("SELECT * FROM feedback ORDER BY created_at DESC");
$feedbackEntries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('purpleback.jpg'); /* Replace 'background.jpg' with the path to your background image */
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: purple;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Feedback from Customers</h1>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedbackEntries as $feedback): ?>
                    <tr>
                        <td><?php echo $feedback['created_at']; ?></td>
                        <td><?php echo $feedback['user_id']; ?></td>
                        <td><?php echo $feedback['feedback']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="btn-container">
            <a href="home.php" class="btn">Back to Home</a>
        </div>
    </div>
</body>
</html>
