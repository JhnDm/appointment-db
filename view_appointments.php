<?php
require 'db.php';
require 'functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Initialize an empty array to store appointments
$appointments = [];

// Fetch appointments from the database
try {
    $conn = dbConnect();
    $stmt = $conn->query("SELECT appointment_id, user_id, product_name, appointment_date, appointment_time FROM appointments");
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle any database errors
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Appointments</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
        <h1>View Appointments</h1>
        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>User ID</th>
                    <th>Chosen Product</th>
                    <th>Appointed Date</th>
                    <th>Appointed Time</th> <!-- New column for time -->
                </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td> <!-- Display date -->
                        <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td> <!-- Display time -->
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