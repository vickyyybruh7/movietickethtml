<?php
// Check if a search query is submitted using the GET method
if (isset($_GET['search_query'])) {
  $searchQuery = htmlspecialchars($_GET['search_query']); // Sanitize the input to avoid XSS
  // Simulate a search result (you would normally query a database here)
  $movies = ["Deadpool", "Avatar", "Avengers", "Inception"];
  $searchResults = [];

  // Basic search logic (could be more complex in a real application)
  foreach ($movies as $movie) {
    if (stripos($movie, $searchQuery) !== false) {
      $searchResults[] = $movie;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Movies - BookMyShow</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1>Movie Search</h1>
</header>

<section>
  <!-- Movie search form using GET -->
  <form action="search.php" method="get">
    <label for="search_query">Search for a movie:</label>
    <input type="text" id="search_query" name="search_query" required>
    <button type="submit">Search</button>
  </form>

  <!-- Display search results -->
  <?php if (isset($searchResults)): ?>
    <h2>Search Results:</h2>
    <?php if (!empty($searchResults)): ?>
      <ul>
        <?php foreach ($searchResults as $result): ?>
          <li>
            <?php echo $result; ?>
            <!-- Link to book tickets for the movie -->
            - <a href="book.php?movie=<?php echo urlencode($result); ?>">Book Now</a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No movies found for "<?php echo $searchQuery; ?>"</p>
    <?php endif; ?>
  <?php endif; ?>
</section>

<footer>
  <p>&copy; 2024 BookMyShow. All rights reserved.</p>
</footer>
</body>
</html>
