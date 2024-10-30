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

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = $conn->real_escape_string($_POST['task']);
    $sql = "INSERT INTO dolist (task) VALUES ('$task')";
    $conn->query($sql);
}

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $taskId = intval($_POST['task_id']);
    $sql = "DELETE FROM dolist WHERE id = $taskId";
    $conn->query($sql);
}

 $sql = "SELECT * FROM dolist ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="dolist.css">
</head>
<body>
    <div class="container">
        <h1>Admin To Do List</h1>
        
        <form method="post" class="task-form">
            <textarea name="task" placeholder="Enter a new task" rows="4" required></textarea>
            <button type="submit">Add Task</button>
        </form>
        
        <h2>All Tasks</h2>
        <ul class="task-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <?php echo htmlspecialchars($row['task']); ?> 
                        <small>(Added on: <?php echo $row['created_at']; ?>)</small>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_task" class="delete-btn">Delete</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No tasks available.</li>
            <?php endif; ?>
        </ul>
        
        <p><a href="admin_dashboard.php" class="back-link">Back to Dashboard</a></p>
    </div>
</body>
</html>

<?php $conn->close(); ?>
