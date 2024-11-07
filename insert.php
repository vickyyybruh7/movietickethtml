<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

// Create connection
$con = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$con) {
  die("<div class='message error'>Connection failed: " . mysqli_connect_error() . "</div>");
}

// Basic HTML structure with styling
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: white;
            font-weight: bold;
        }
        .message.success {
            background-color: #28a745;
        }
        .message.error {
            background-color: #dc3545;
        }
        .message.view {
            background-color: #17a2b8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #ddd;
        }
        .back-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Movie Ticket Management</h2>
';

// Processing form actions
if (isset($_POST['action'])) {
  $action = $_POST['action'];

  $ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : '';
  $movie_name = isset($_POST['movie_name']) ? $_POST['movie_name'] : '';
  $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
  $seat_no = isset($_POST['seat_no']) ? $_POST['seat_no'] : '';
  $price = isset($_POST['price']) ? $_POST['price'] : 0;

  if (empty($ticket_id)) {
    echo "<div class='message error'>Ticket ID is required!</div>";
    exit();
  }

  // Perform action based on the selected option
  switch ($action) {
    case "Insert":
      $stmt = $con->prepare("INSERT INTO tickets (ticket_id, movie_name, customer_name, seat_no, price) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("isssi", $ticket_id, $movie_name, $customer_name, $seat_no, $price);
      if ($stmt->execute()) {
        echo "<div class='message success'>Ticket booked successfully!</div>";
      } else {
        echo "<div class='message error'>Error: " . $stmt->error . "</div>";
      }
      $stmt->close();
      break;

    case "Update":
      $stmt = $con->prepare("UPDATE tickets SET movie_name = ?, customer_name = ?, seat_no = ?, price = ? WHERE ticket_id = ?");
      $stmt->bind_param("sssii", $movie_name, $customer_name, $seat_no, $price, $ticket_id);
      if ($stmt->execute()) {
        echo "<div class='message success'>Ticket updated successfully!</div>";
      } else {
        echo "<div class='message error'>Error: " . $stmt->error . "</div>";
      }
      $stmt->close();
      break;

    case "Delete":
      $stmt = $con->prepare("DELETE FROM tickets WHERE ticket_id = ?");
      $stmt->bind_param("i", $ticket_id);
      if ($stmt->execute()) {
        echo "<div class='message success'>Ticket deleted successfully!</div>";
      } else {
        echo "<div class='message error'>Error: " . $stmt->error . "</div>";
      }
      $stmt->close();
      break;

    case "View":
      $stmt = $con->prepare("SELECT * FROM tickets WHERE ticket_id = ?");
      $stmt->bind_param("i", $ticket_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo "<div class='message view'>Ticket Details</div>";
        echo "<table><tr><th>Ticket ID</th><th>Movie Name</th><th>Customer Name</th><th>Seat Number</th><th>Price</th></tr>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                            <td>{$row['ticket_id']}</td>
                            <td>{$row['movie_name']}</td>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['seat_no']}</td>
                            <td>{$row['price']}</td>
                          </tr>";
        }
        echo "</table>";
      } else {
        echo "<div class='message error'>No ticket found!</div>";
      }
      $stmt->close();
      break;

    default:
      echo "<div class='message error'>Invalid action!</div>";
  }
}

echo '<a href="sd.html" class="back-button">Back to Form</a>';

echo '
    </div>
</body>
</html>
';

// Close connection
mysqli_close($con);
?>
