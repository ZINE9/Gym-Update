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
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $weight = $_POST['weight'];
    $weight_unit = $_POST['weight_unit'];
    $gender=$_POST['gender'];
    $yes_no_option = $_POST['yes_no_option'];
    $command=$_POST['command'];
    $select_option1 = $_POST['select_option1'];
    $select_option2 = $_POST['select_option2'];
    $select_option3= $_POST['select_option3'];
    $date = $_POST['date'];

    $monthsToAdd = intval($select_option3);
    $startDate = new DateTime($date);
    $startDate->modify("+$monthsToAdd month");
    $endDate = $startDate->format('Y-m-d');

    $stmt = $pdo->prepare('INSERT INTO vip (name, age, address, phone, weight, weight_unit, gender, yes_no_option, command, select_option1, select_option2, select_option3, start, end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $age, $address, $phone, $weight, $weight_unit, $gender, $yes_no_option, $command, $select_option1, $select_option2, $select_option3, $date, $endDate]);

    echo "User information added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <header>
        <h1>Manage Users</h1>
        <nav>
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </nav>
    </header>

    <main>
        <form method="POST" action="vip.php" class="form-container">
            <h2>Add VIP User</h2><br>
            <div class="form-column">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div>
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div>
                    <label for="weight">Weight:</label>
                    <input type="number" id="weight" name="weight" required>
                    <select id="weight_unit" name="weight_unit">
                        <option value="lb">lb</option>
                        <option value="kg">kg</option>
                    </select>
                </div>
                
                <div class="form-item-full">
                    <label>Have surgery in the last six months?</label>
                    <div class="radio-group">
                        <input type="radio" id="yes" name="yes_no_option" value="yes" required>
                        <label for="yes">Yes</label>
                        <input type="radio" id="no" name="yes_no_option" value="no">
                        <label for="no">No</label>
                    </div>
                </div>

                <div class="form-item-full">
                    <label>Gender:</label>
                    <div class="radio-group">
                        <input type="radio" id="male" name="gender" value="male" required>
                        <label for="yes">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="no">Female</label>
                    </div>
                </div>
            </div>

            <div class="form-column">
                <div>
                    <label for="command">User disease:</label><br>
                    <textarea name="command" placeholder="Enter your disease" rows="4" required></textarea>
                </div>
                <div>
                    <label for="select_option1">Which part is hurt?:</label>
                    <select id="select_option1" name="select_option1" required>
                        <option value="Knee">Knee</option>
                        <option value="Back">Back</option>
                        <option value="Arm">Arm</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="select_option2">Played before?</label>
                    <select id="select_option2" name="select_option2" required>
                        <option value="Under 3 Months">Under 3 Months</option>
                        <option value="Between 3 and 6 Months">Between 3 and 6 Months</option>
                        <option value="Above 6 Months">Above 6 Months</option>
                    </select>
                </div>
                <div>
                    <label for="select_option3">How much months does user play?</label>
                    <select id="select_option3" name="select_option3" required>
                        <option value="1">1 Month</option>
                        <option value="2">2 Months</option>
                        <option value="3">3 Months</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="date">Start Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
            </div>

            <button type="submit" class="form-item-full">Add VIP User</button>
        </form>
    </main>
</body>
</html>
