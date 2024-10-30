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

$search = '';
$sql = "SELECT * FROM vip";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " WHERE name LIKE '%$search%' 
              OR age LIKE '%$search%' 
              OR address LIKE '%$search%' 
              OR phone LIKE '%$search%' 
              OR weight LIKE '%$search%'";
}

$sql .= " ORDER BY id ASC";

$result = $conn->query($sql);
$userCount = $result->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View VIP Users</title>
    <link rel="stylesheet" href="view_users.css">
</head>
<body>
    <div class="container">
        <h1>VIP User Registration Reports</h1>
        
        <p>Total VIP Users: <?php echo $userCount; ?></p>
        
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="Search by username, phone, etc." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Weight</th>
                    <th>Gender</th>
                    <th>Surgery</th>
                    <th>Disease</th>
                    <th>Hurt Part</th>
                    <th>Gym Exp</th>
                    <th>Months</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = 1;
                if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $counter++; ?></td> 
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['weight']); ?> <?php echo htmlspecialchars($row['weight_unit']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['yes_no_option']); ?></td>
                            <td><?php echo htmlspecialchars($row['command']); ?></td>
                            <td><?php echo htmlspecialchars($row['select_option1']); ?></td>
                            <td><?php echo htmlspecialchars($row['select_option2']); ?></td>
                            <td><?php echo htmlspecialchars($row['select_option3']); ?></td>
                            <td><?php echo htmlspecialchars($row['start']); ?></td>
                            <td><?php echo htmlspecialchars($row['end']); ?></td>

                            <td>
                                <a href="edit_vip.php?id=<?php echo $row['id']; ?>" class="btn edit-btn">Edit</a>
                                <a href="delete_vip.php?id=<?php echo $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="15">No results found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <p><a href="admin_dashboard.php" class="back-link">Back to Dashboard</a></p>
    </div>
</body>
</html>

<?php $conn->close(); ?>
