<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="index.css">
    <title>Sign In / Sign Up</title>
</head>
<body>
    <div class="container">
        <img src="home.jpg" alt="Wedding" width="600" height="400" class="image">

        <div class="form-container">
            <h2>Sign In</h2>
            <form action="signin.php" method="post" id="signinForm">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Sign In</button>
                <p>Don't have an account? <a href="#" onclick="showSignUp()">Sign Up</a></p>
            </form>

            <h2 style="display:none;" id="signupTitle">Sign Up</h2>
            <form action="signup.php" method="post" id="signupForm" style="display:none;">
                <input type="text" name="username" placeholder="Username" required>
                <input type="phone" name="phone" placeholder="Phone Number" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="staff">Staff</option>
                </select>
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="#" onclick="showSignIn()">Sign In</a></p>
            </form>
        </div>
    </div>

    <script src="index.js"></script>
</body>
</html>
