<?php
require 'vendor/autoload.php';
require 'db.php';
require 'functions.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $message = $_POST['message'];

    // Basic validation for the message input
    if (empty($message)) {
        echo "Please enter a message for the appointment.";
        exit;
    }

    // Fetch user details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found.";
        exit;
    }

    $to = $user['email'];
    $subject = 'Appointment Confirmation';
    $message = "Dear {$user['username']}, " . $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USERNAME']; // SMTP username
        $mail->Password   = $_ENV['SMTP_PASSWORD']; // SMTP password (app password if using 2-Step Verification)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('JhnlynDm12@gmail.com', 'Customer Service');
        $mail->addAddress($to, $user['username']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo "Appointment booked successfully and email sent!";
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
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
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full height */
        }
        form {
            max-width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Add some shadow */
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
        .home-btn {
            background-color: purple;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px; /* Add some space above the button */
        }
        .home-btn:hover {
            background-color: #7A378B; /* Darker purple on hover */
        }
    </style>
</head>
<body>
    <div>
        <form action="book_appointment.php" method="post">
            <label for="message">Email Now:</label>
            <textarea name="message" required></textarea>
            <input type="submit" value="Book Appointment">
        </form>
        <a href="home.php" class="home-btn">Back to Home</a>
    </div>
</body>
</html>
