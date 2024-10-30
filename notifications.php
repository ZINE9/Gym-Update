<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
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

$sql = "SELECT rest_date FROM users WHERE username = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$restDate = $user['rest_date'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Notifications</title>
    <link rel="stylesheet" href="notifications.css">
    <style>
        .countdown {
            font-size: 24px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Notifications</h1>
    <div class="countdown" id="countdown"></div>
    <script>
        const restDate = new Date("<?php echo $restDate; ?>").getTime();

        const countdownFunction = setInterval(function() {
            const now = new Date().getTime();
            const distance = restDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = 
                days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(countdownFunction);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
    <p><a href="user_dashboard.php">Back to Dashboard</a></p>
</body>


</html>
