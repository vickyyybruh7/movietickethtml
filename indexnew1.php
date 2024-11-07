<?php
// Function to validate login credentials
function validateLogin($username, $password) {
    // Hardcoded credentials for simplicity
    $validUsername = "user123";
    $validPassword = "password123";

    if ($username === $validUsername && $password === $validPassword) {
        return "Welcome, $username!";
    } else {
        return "Invalid username or password!";
    }
}

// Check if login form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    $username = htmlspecialchars($_POST["username"]); // Sanitize user input
    $password = htmlspecialchars($_POST["password"]); // Sanitize user input

    // Validate login credentials
    $loginMessage = validateLogin($username, $password);
} else {
    $loginMessage = "Please enter your login credentials!";
}

// Check for any message passed via GET (e.g., for logged-out or redirect message)
$infoMessage = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
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
    <!-- Display the info message from GET (if any) -->
    <?php if ($infoMessage): ?>
        <p><?php echo $infoMessage; ?></p>
    <?php endif; ?>

    <!-- Login form uses POST method -->
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>

    <!-- Display the login message -->
    <p><?php echo $loginMessage; ?></p>

    <a href="indexnew.html">Go to main page</a> <!-- Link to another page -->
    <br><br>
    <!-- Link that sends a GET message -->
    <a href="login.php?message=You have been logged out.">Logout</a>
</section>

<footer>
    <p>&copy; 2024 BookMyShow. All rights reserved.</p>
</footer>
</body>
</html>
