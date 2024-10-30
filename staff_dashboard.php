<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
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

$searchTermNormal = '';
$searchTermVip = '';

if (isset($_POST['search_normal'])) {
    $searchTermNormal = $conn->real_escape_string($_POST['search_normal']);
    $sqlNormal = "SELECT * FROM client WHERE name LIKE '%$searchTermNormal%' OR phone LIKE '%$searchTermNormal%'";
} else {
    $sqlNormal = "SELECT * FROM client";
}
$resultNormal = $conn->query($sqlNormal);

if (isset($_POST['search_vip'])) {
    $searchTermVip = $conn->real_escape_string($_POST['search_vip']);
    $sqlVip = "SELECT * FROM vip WHERE name LIKE '%$searchTermVip%' OR phone LIKE '%$searchTermVip%'";
} else {
    $sqlVip = "SELECT * FROM vip";
}
$resultVip = $conn->query($sqlVip);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="staff_dashboard.css">
    <script>
        function toggleView(type) {
            const normalSection = document.getElementById('normal-section');
            const vipSection = document.getElementById('vip-section');

            if (type === 'normal') {
                normalSection.style.display = 'block';
                vipSection.style.display = 'none';
            } else if (type === 'vip') {
                normalSection.style.display = 'none';
                vipSection.style.display = 'block';
            }
        }

        window.onload = function() {
            toggleView('normal');
        };
    </script>
</head>
<body>
    <div class="container">
        <h1>Staff Dashboard</h1>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

        <div class="toggle-buttons">
            <button onclick="toggleView('normal')">Normal Users</button>
            <button onclick="toggleView('vip')">VIP Users</button>
        </div>

        <div id="normal-section" class="section">
            <form method="POST" action="">
                <input type="text" name="search_normal" placeholder="Search normal users by name or phone" value="<?php echo htmlspecialchars($searchTermNormal); ?>">
                <button type="submit">Search</button>
            </form>
            <h3>Normal Users</h3>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Weight</th>
                        <th>Gender</th>
                        <th>Surgery</th>
                        <th>Disease</th>
                        <th>Hurt Part</th>
                        <th>Gym Exp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultNormal->num_rows > 0): ?>
                        <?php while ($user = $resultNormal->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['age']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td><?php echo htmlspecialchars($user['weight']) . ' ' . htmlspecialchars($user['weight_unit']); ?></td>
                                <td><?php echo htmlspecialchars($user['gender']); ?></td>
                                <td><?php echo htmlspecialchars($user['yes_no_option']); ?></td>
                                <td><?php echo htmlspecialchars($user['command']); ?></td>
                                <td><?php echo htmlspecialchars($user['select_option1']); ?></td>
                                <td><?php echo htmlspecialchars($user['select_option2']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">No normal users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="vip-section" class="section" style="display: none;">
            <form method="POST" action="">
                <input type="text" name="search_vip" placeholder="Search VIP users by name or phone" value="<?php echo htmlspecialchars($searchTermVip); ?>">
                <button type="submit">Search</button>
            </form>
            <h3>VIP Users</h3>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Weight</th>
                        <th>Gender</th>
                        <th>Surgery</th>
                        <th>Disease</th>
                        <th>Hurt Part</th>
                        <th>Gym Exp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultVip->num_rows > 0): ?>
                        <?php while ($user = $resultVip->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['age']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td><?php echo htmlspecialchars($user['weight']) . ' ' . htmlspecialchars($user['weight_unit']); ?></td>
                                <td><?php echo htmlspecialchars($user['gender']); ?></td>
                                <td><?php echo htmlspecialchars($user['yes_no_option']); ?></td>
                                <td><?php echo htmlspecialchars($user['command']); ?></td>
                                <td><?php echo htmlspecialchars($user['select_option1']); ?></td>
                                <td><?php echo htmlspecialchars($user['select_option2']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">No VIP users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <p><a href="logout.php" class="logout-link">Logout</a></p>
    </div>
</body>
</html>

<?php
$conn->close();
?>
