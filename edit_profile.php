<?php
session_start();

if (!isset($_SESSION['username'])) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_phone = $conn->real_escape_string($_POST['phone']);
    $new_password = $conn->real_escape_string($_POST['password']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $age = (int)$_POST['age'];
    $gender = $conn->real_escape_string($_POST['gender']);
    $weight = (float)$_POST['weight'];
    $weight_unit = $conn->real_escape_string($_POST['weight_unit']);
    $height = $conn->real_escape_string($_POST['height']);
    $address = $conn->real_escape_string($_POST['address']);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update user information
    $update_sql = "UPDATE users SET 
                    phone = '$new_phone', 
                    first_name = '$first_name', 
                    last_name = '$last_name', 
                    age = '$age', 
                    gender = '$gender', 
                    weight = '$weight', 
                    weight_unit = '$weight_unit', 
                    height = '$height', 
                    address = '$address'";
    if (!empty($new_password)) {
        $update_sql .= ", password = '$hashed_password'";
    }
    $update_sql .= " WHERE username = '" . $_SESSION['username'] . "'";

    if ($conn->query($update_sql) === TRUE) {
        $update_message = "Profile updated successfully.";
    } else {
        $update_message = "Error updating profile: " . $conn->error;
    }
}

$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css">
</head>
<body>
    
    <?php if (!empty($update_message)): ?>
        <p><?php echo htmlspecialchars($update_message); ?></p>
    <?php endif; ?>

    <form method="post" class="two-group-form">
    <h1>Edit Profile</h1>
    <div class="column-group">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php echo ($user['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($user['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($user['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" step="0.1" required>
            <select id="weight_unit" name="weight_unit">
                <option value="lb" <?php echo ($user['weight_unit'] === 'lb') ? 'selected' : ''; ?>>lb</option>
                <option value="kg" <?php echo ($user['weight_unit'] === 'kg') ? 'selected' : ''; ?>>kg</option>
            </select>
        </div>
    </div>

    <div class="column-group">
        <div class="form-group">
            <label for="height">Height:</label>
            <input type="text" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="phone">Ph:</label>
            <input type="phone" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password">
        </div>
    </div>

    <button type="submit">Update Profile</button>
    <p><a href="user_dashboard.php">Back to Dashboard</a></p>
</form>


    
</body>
</html>
