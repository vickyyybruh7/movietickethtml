<?php
// Check if form is submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST["name"]); // Sanitize user input
  $email = htmlspecialchars($_POST["email"]);
  $movie = htmlspecialchars($_POST["movie"]);

  // Simulate a booking process (in a real application, you'd save to a database)
  $message = "Thank you, $name! Your ticket for '$movie' has been booked. Confirmation sent to $email.";
}

// Check if a movie is preselected from search page
if (isset($_GET['movie'])) {
  $selectedMovie = htmlspecialchars($_GET['movie']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book a Ticket - BookMyShow</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1>Book Your Movie Ticket</h1>
</header>

<section>
  <!-- Booking form using POST -->
  <form action="book.php" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="movie">Select a movie:</label>
    <select id="movie" name="movie" required>
      <?php if (isset($selectedMovie)): ?>
        <option value="<?php echo $selectedMovie; ?>"><?php echo $selectedMovie; ?></option>
      <?php else: ?>
        <option value="Deadpool">Deadpool</option>
        <option value="Avatar">Avatar</option>
        <option value="Avengers">Avengers</option>
        <option value="Inception">Inception</option>
      <?php endif; ?>
    </select><br><br>

    <button type="submit">Book Ticket</button>
  </form>

  <!-- Display booking confirmation -->
  <?php if (isset($message)): ?>
    <p><?php echo $message; ?></p>
  <?php endif; ?>
</section>

<footer>
  <p>&copy; 2024 BookMyShow. All rights reserved.</p>
</footer>
</body>
</html>
