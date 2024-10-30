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

$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($userId) {
    $sql = "SELECT * FROM vip WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "Invalid user ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $weight = $_POST['weight'];
    $weight_unit = $_POST['weight_unit'];
    $gender = $_POST['gender'];
    $yes_no_option = $_POST['yes_no_option'];
    $command = $_POST['command'];
    $select_option1 = $_POST['select_option1'];
    $select_option2 = $_POST['select_option2'];
    $select_option3 = $_POST['select_option3'];
    $start_date = $_POST['date'];
    $number_of_months = intval($_POST['select_option3']); 

     $startDateObj = new DateTime($start_date);
    $endDateObj = clone $startDateObj;  
    $endDateObj->modify("+$number_of_months month");
    $end_date = $endDateObj->format('Y-m-d');  

    $updateSql = "UPDATE vip SET name = ?, age = ?, address = ?, phone = ?, weight = ?, weight_unit = ?, gender = ?, yes_no_option = ?, command = ?, select_option1 = ?, select_option2 = ?, select_option3 = ?, start = ?, end = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('sissssssssssssi', $name, $age, $address, $phone, $weight, $weight_unit, $gender, $yes_no_option, $command, $select_option1, $select_option2, $select_option3, $start_date, $end_date, $userId);

    if ($stmt->execute()) {
        header('Location: view_vip.php?message=User updated successfully');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit VIP User</title>
    <link rel="stylesheet" href="view_users.css">
</head>
<body>
    <form method="POST" class="form-container">
        <h2>Edit VIP User</h2><br>
        <div class="form-column">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div>
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div>
                <label for="weight">Weight:</label>
                <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" required>
                <select id="weight_unit" name="weight_unit">
                    <option value="lb" <?php echo $user['weight_unit'] === 'lb' ? 'selected' : ''; ?>>lb</option>
                    <option value="kg" <?php echo $user['weight_unit'] === 'kg' ? 'selected' : ''; ?>>kg</option>
                </select>
            </div>

            <div class="form-item-full">
                <label>Have surgery in the last six months?</label>
                <div class="radio-group">
                    <input type="radio" id="yes" name="yes_no_option" value="yes" <?php echo $user['yes_no_option'] === 'yes' ? 'checked' : ''; ?> required>
                    <label for="yes">Yes</label>
                    <input type="radio" id="no" name="yes_no_option" value="no" <?php echo $user['yes_no_option'] === 'no' ? 'checked' : ''; ?>>
                    <label for="no">No</label>
                </div>
            </div>

            <div class="form-item-full">
                <label>Gender:</label>
                <div class="radio-group">
                    <input type="radio" id="male" name="gender" value="male" <?php echo $user['gender'] === 'male' ? 'checked' : ''; ?> required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="female" <?php echo $user['gender'] === 'female' ? 'checked' : ''; ?>>
                    <label for="female">Female</label>
                </div>
            </div>
        </div>

        <div class="form-column">
            <div>
                <label for="command">User disease:</label><br>
                <textarea name="command" placeholder="Enter your disease" rows="4" required><?php echo htmlspecialchars($user['command']); ?></textarea>
            </div>
            <div>
                <label for="select_option1">Which part is hurt?:</label>
                <select id="select_option1" name="select_option1" required>
                    <option value="Knee" <?php echo $user['select_option1'] === 'Knee' ? 'selected' : ''; ?>>Knee</option>
                    <option value="Back" <?php echo $user['select_option1'] === 'Back' ? 'selected' : ''; ?>>Back</option>
                    <option value="Arm" <?php echo $user['select_option1'] === 'Arm' ? 'selected' : ''; ?>>Arm</option>
                    <option value="Other" <?php echo $user['select_option1'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div>
                <label for="select_option2">Played before?</label>
                <select id="select_option2" name="select_option2" required>
                    <option value="Under 3 Months" <?php echo $user['select_option2'] === 'Under 3 Months' ? 'selected' : ''; ?>>Under 3 Months</option>
                    <option value="Between 3 and 6 Months" <?php echo $user['select_option2'] === 'Between 3 and 6 Months' ? 'selected' : ''; ?>>Between 3 and 6 Months</option>
                    <option value="Above 6 Months" <?php echo $user['select_option2'] === 'Above 6 Months' ? 'selected' : ''; ?>>Above 6 Months</option>
                </select>
            </div>
            <div>
                <label for="select_option3">How many months has the user played?</label>
                <select id="select_option3" name="select_option3" required>
                    <option value="1" <?php echo $user['select_option3'] === '1' ? 'selected' : ''; ?>>1 Month</option>
                    <option value="2" <?php echo $user['select_option3'] === '2' ? 'selected' : ''; ?>>2 Months</option>
                    <option value="3" <?php echo $user['select_option3'] === '3' ? 'selected' : ''; ?>>3 Months</option>
                    <option value="other" <?php echo $user['select_option3'] === 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div>
                <label for="date">Start Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($user['start']); ?>" required>
            </div>
        </div>

        <button type="submit" class="form-item-full">Update User</button>
        <a href="view_vip.php" class="back-link">Cancel</a>
    </form>
</body>
</html>
