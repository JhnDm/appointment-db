<?php
require 'vendor/autoload.php';
require 'db.php';
require 'functions.php';

// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$feedbackMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $feedback = $_POST['feedback'];

    // Basic validation for the feedback input
    if (empty($feedback)) {
        $feedbackMessage = "Please enter your feedback.";
    } else {
        // Save feedback to database
        $stmt = $pdo->prepare("INSERT INTO feedback (user_id, feedback) VALUES (?, ?)");
        $stmt->execute([$userId, $feedback]);

        $feedbackMessage = "Thank you for your feedback!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('purpleback.jpg'); /* Add your background image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center items horizontally */
            align-items: center; /* Center items vertically */
            height: 100vh; /* Full height */
        }
        form {
            max-width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Add some shadow */
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            height: 150px; /* Increased height */
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: purple; /* Changed to purple */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #7A378B; /* Darker purple on hover */
        }
        .feedback-message {
            margin-bottom: 15px;
            color: green;
            font-weight: bold;
        }
        .back-to-home {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: purple;
            padding: 10px 20px;
            border-radius: 4px;
        }
        .back-to-home:hover {
            background-color: #5e2d66; /* Darker purple on hover */
        }
    </style>
</head>
<body>
    <form action="feedback.php" method="post">
        <?php if ($feedbackMessage): ?>
        <div class="feedback-message"><?php echo $feedbackMessage; ?></div>
        <?php endif; ?>
        <label for="feedback">Your Feedback:</label>
        <textarea name="feedback" required></textarea>
        <input type="submit" value="Submit Feedback">
        <a href="home.php" class="back-to-home">Back to Home</a>
    </form>
</body>
</html>
