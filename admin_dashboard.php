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
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $stmtNormal = $pdo->prepare('SELECT name, end FROM client ORDER BY end ASC LIMIT 5');
    $stmtNormal->execute();
    $normalUsers = $stmtNormal->fetchAll(PDO::FETCH_ASSOC);

     $stmtVIP = $pdo->prepare('SELECT name, end FROM vip ORDER BY end ASC LIMIT 5');
    $stmtVIP->execute();
    $vipUsers = $stmtVIP->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <nav>
            <ul>
                <li><a href="normal.php">Add Normal Users</a></li>
                <li><a href="vip.php">Add VIP Users</a></li>
                <li><a href="view_normal.php">View Normal Users</a></li>
                <li><a href="view_vip.php">View VIP Users</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="dolist.php">To Do List</a></li>
                <li><a href="logout.php">Sign Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Users with the Soonest End Dates</h2>

        <section>
            <h3>Normal Users</h3>
            <ul>
                <?php foreach ($normalUsers as $user): 
                    $endDate = new DateTime($user['end']);
                    $currentDate = new DateTime();
                    $remainingMonths = $currentDate->diff($endDate)->m + ($currentDate->diff($endDate)->y * 12);
                ?>
                    <li>
                        <?php echo htmlspecialchars($user['name']); ?> - Ends in <?php echo $remainingMonths; ?> month(s) (End Date: <?php echo $user['end']; ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h3>VIP Users</h3>
            <ul>
                <?php foreach ($vipUsers as $user): 
                    $endDate = new DateTime($user['end']);
                    $currentDate = new DateTime();
                    $remainingMonths = $currentDate->diff($endDate)->m + ($currentDate->diff($endDate)->y * 12);
                ?>
                    <li>
                        <?php echo htmlspecialchars($user['name']); ?> - Ends in <?php echo $remainingMonths; ?> month(s) (End Date: <?php echo $user['end']; ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Gym Management System. All rights reserved.</p>
    </footer>
</body>
</html>
