<?php
require 'db_connection.php'; // Include the database connection

// Fetch auction items (only those that are not closed)
$sql = "SELECT * FROM stamps WHERE end_time > NOW() ORDER BY end_time DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='auction-card'>";
        echo "<img src='" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>Starting Bid: ₹" . $row['starting_bid'] . "</p>";
        echo "<p class='timer'>Time Remaining: " . date('Y-m-d H:i:s', strtotime($row['end_time'])) . "</p>";
        echo "<button class='bid-button'>Bid Now</button>";
        echo "</div>";
    }
} else {
    echo "No auction items available.";
}

$conn->close();
?>
