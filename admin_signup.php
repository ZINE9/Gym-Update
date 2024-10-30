<?php
session_start();

// Database connection details
$host = 'localhost';
$db = 'gym_base';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$signup_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE username = '$username' OR phone = '$phone'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $signup_message = "Username or email already exists. Please choose another.";
    } else {
        $insert_sql = "INSERT INTO users (username, phone, password, role) VALUES ('$username', '$phone', '$hashed_password', 'admin')";
        
        if ($conn->query($insert_sql) === TRUE) {
            $signup_message = "Admin registered successfully!";
        } else {
            $signup_message = "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Signup</h1>
    <?php if (!empty($signup_message)): ?>
        <p><?php echo htmlspecialchars($signup_message); ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="phone">Phone Number:</label>
        <input type="phone" id="phone" name="phone" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register Admin</button>
    </form>

    <p><a href="index.php">Back to Login</a></p>
</body>
</html>
