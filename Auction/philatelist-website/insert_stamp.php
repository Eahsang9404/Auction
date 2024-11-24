<?php
require 'db_connection.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get input values (admin will provide the form)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $starting_bid = $_POST['starting_bid'];
    $end_time = $_POST['end_time']; // Example: '2024-12-01 00:00:00'

    $sql = "INSERT INTO stamps (name, description, image_url, starting_bid, end_time) 
            VALUES ('$name', '$description', '$image_url', $starting_bid, '$end_time')";

    if ($conn->query($sql) === TRUE) {
        echo "New stamp added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
