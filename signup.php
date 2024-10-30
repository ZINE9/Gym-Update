<?php
session_start();
$host = 'localhost';
$db = 'gym_base';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    $allowed_admins = ['admin@example.com'];

    if ($role === 'admin' && !in_array($phone, $allowed_admins)) {
        echo '<p>You are not authorized to register as an admin.</p>';
    } else {
        $sql = "SELECT * FROM users WHERE username = '$username' OR phone = '$phone'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<p>Username or email already exists. Please try another.</p>';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, phone, password, role) 
                    VALUES ('$username', '$phone', '$hashed_password', '$role')";

            if ($conn->query($sql) === TRUE) {
                echo '<p>Registration successful. You can now <a href="index.php">Sign In</a>.</p>';
            } else {
                echo '<p>Error: ' . $sql . '<br>' . $conn->error . '</p>';
            }
        }
    }
}

$conn->close();
?>
