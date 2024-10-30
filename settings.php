<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$host = 'localhost';
$db = 'gym_base';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$update_message = "";
$user = null;

$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $update_message = "User data could not be retrieved.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $conn->real_escape_string($_POST['new_username']);
    $new_phone = $conn->real_escape_string($_POST['new_phone']);
    $current_password = $conn->real_escape_string($_POST['current_password']);
    $new_password = $conn->real_escape_string($_POST['new_password']);

    if ($user && password_verify($current_password, $user['password'])) {
        $update_sql = "UPDATE users SET username = '$new_username', phone = '$new_phone'";

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql .= ", password = '$hashed_password'";
        }

        $update_sql .= " WHERE username = '" . $_SESSION['username'] . "'";

        if ($conn->query($update_sql) === TRUE) {
            $_SESSION['username'] = $new_username; 
            $update_message = "Profile updated successfully.";
        } else {
            $update_message = "Error updating profile: " . $conn->error;
        }
    } else {
        $update_message = "Current password is incorrect.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="settings.css">
</head>
<body>
    <h1>Admin Settings</h1>
    
    <?php if (!empty($update_message)): ?>
        <p><?php echo htmlspecialchars($update_message); ?></p>
    <?php endif; ?>

    <?php if ($user): ?>
    <form method="post">
        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

        <label for="new_phone">New Email:</label>
        <input type="phone" id="new_phone" name="new_phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>

        <label for="new_password">New Password (optional):</label>
        <input type="password" id="new_password" name="new_password" placeholder="Enter new password">

        <button type="submit">Update Profile</button>
    </form>
    <?php endif; ?>

    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
