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

$messageSent = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $productName = $_POST['message'];
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];

    // Basic validation for the inputs
    if (empty($productName)) {
        $messageSent = "Please enter a message for the appointment.";
    } elseif (empty($appointmentDate) || empty($appointmentTime)) {
        $messageSent = "Please select both date and time for the appointment.";
    } else {
        // Fetch user details
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user) {
            $messageSent = "User not found.";
        } else {
            // Insert appointment details into the database
            $stmt = $pdo->prepare("INSERT INTO appointments (user_id, product_name, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
            $stmt->execute([$userId, $productName, $appointmentDate, $appointmentTime]);

            // Send email confirmation
            $to = $user['email'];
            $subject = 'Appointment Confirmation';
            $message = "Dear {$user['username']}, you chose {$productName}. The appointment is scheduled for {$appointmentDate} at {$appointmentTime}.";

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
                $messageSent = "Appointment booked successfully and email sent!";
            } catch (Exception $e) {
                $messageSent = "Error sending email: {$mail->ErrorInfo}";
            }
        }
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
        textarea, input[type="datetime-local"] {
            width: 100%;
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
        .message {
            margin-top: 20px;
            font-weight: bold;
            color:white;
        }
    </style>
</head>
<body>
    <div>
        <form action="book_appointment.php" method="post">
            <label for="message">Product Name:</label>
            <textarea name="message" required></textarea>
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" name="appointment_date" required>
            <label for="appointment_time">Appointment Time:</label>
            <input type="time" name="appointment_time" required>
            <input type="submit" value="Book Appointment">
        </form>
        <a href="home.php" class="home-btn">Back to Home</a>
        <div class="message"><?php echo $messageSent; ?></div>
    </div>
</body>
</html>
