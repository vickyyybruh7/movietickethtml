<?php
// Start the session
session_start();

// Hardcoded credentials for simplicity (this should be replaced with database verification in a real system)
$validUsername = "user123";
$validPassword = "password123";

// Initialize login message
$loginMessage = "";

// Check if the form is submitted using POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize user input
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // Validate login credentials
    if ($username === $validUsername && $password === $validPassword) {
        // Set session variables for a successful login
        $_SESSION["username"] = $username;
        header("Location: indexnew.html"); // Redirect to the main page after successful login
        exit();
    } else {
        $loginMessage = "Invalid username or password!";
    }
}

// Check for any GET message (like logout message)
$infoMessage = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Check if the user is already logged in
if (isset($_SESSION["username"])) {
    $loginMessage = "You are already logged in as " . $_SESSION["username"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMyShow - Login</title>
    <link rel="stylesheet" href="stylesnew.css">
</head>
<body>
<header>
    <h1>Login to BookMyShow</h1>
</header>

<section>
    <!-- Display GET info message -->
    <?php if ($infoMessage): ?>
        <p><?php echo $infoMessage; ?></p>
    <?php endif; ?>

    <!-- Display login form if the user is not logged in -->
    <?php if (!isset($_SESSION["username"])): ?>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
    <?php else: ?>
        <!-- If user is logged in, display a welcome message -->
        <p><?php echo $loginMessage; ?></p>
        <a href="logout.php">Logout</a> <!-- Link to logout -->
    <?php endif; ?>

    <p><?php echo $loginMessage; ?></p> <!-- Display login message -->
    <a href="indexnew.html">Go to main page</a> <!-- Link to main page -->
</section>

<footer>
    <p>&copy; 2024 BookMyShow. All rights reserved.</p>
</footer>
</body>
</html>
