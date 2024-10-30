<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dashboard.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">GYM DASHBOARD</div>
        <ul class="navbar-menu">
            <li><a href="view_profile.php">View Profile</a></li>
            <li><a href="edit_profile.php">Edit Profile</a></li>
            <li><a href="notifications.php">Notifications</a></li>
            <li><a href="user_logout.php">Log Out</a></li>
        </ul>
    </nav>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>You are logged in as a user.</p>


    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
