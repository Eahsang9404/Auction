<?php
// Database connection
$host = 'localhost';
$db = 'auction_db';
$user = 'root';
$password = '';
$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add or Edit Auction Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'save') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $description = $_POST['description'];
    $starting_bid = $_POST['starting_bid'];
    $end_time = $_POST['end_time'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    } else {
        $image = $_POST['current_image'] ?? null;
    }

    if (empty($id)) {
        // Add new item
        $stmt = $conn->prepare("INSERT INTO stamps (name, description, starting_bid, end_time, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $name, $description, $starting_bid, $end_time, $image);
    } else {
        // Edit existing item
        $stmt = $conn->prepare("UPDATE stamps SET name = ?, description = ?, starting_bid = ?, end_time = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("ssdssi", $name, $description, $starting_bid, $end_time, $image, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.html");
}

// Delete Auction Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM stamps WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.html");
}

// Fetch Auction Items for Display
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM stamps");
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    echo json_encode($items);
}

$conn->close();
?>
