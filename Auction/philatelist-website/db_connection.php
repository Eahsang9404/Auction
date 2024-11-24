<?php
$servername = "localhost"; // Database server (localhost for local development)
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "auction_db"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?><?php
require 'db_connection.php';

// Example data for a stamp
$name = "Vintage Stamp Collection";
$description = "A collection of rare vintage stamps.";
$image_url = "images/prod1.jpeg";
$starting_bid = 500.00;
$end_time = "2024-12-01 00:00:00"; // Auction end time

$sql = "INSERT INTO stamps (name, description, image_url, starting_bid, end_time) 
        VALUES ('$name', '$description', '$image_url', $starting_bid, '$end_time')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>





