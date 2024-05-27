<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function dbConnect() {
    $host = 'localhost';
    $db = 'appointment-db';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function registerUser($username, $password, $email, $phone, $carrier, $isAdmin = 0) {
    $pdo = dbConnect();
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        return "Email already exists";
    }

    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        return "Username already exists";
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, phone, carrier, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $passwordHash, $phone, $carrier, $isAdmin])) {
        return "User registered successfully";
    } else {
        return "Error registering user";
    }
}

function loginUser($username, $password) {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}
function isAdmin($username) {
    // Define admin users here
    $admin_users = ['admin'];
    return in_array($username, $admin_users);
}
?>
