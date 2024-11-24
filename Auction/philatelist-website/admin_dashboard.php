<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.html'); // Redirect to login page if not authenticated
    exit;
}

// Include database connection
require_once 'db_connection.php';

// Fetch auction items from the database
$query = "SELECT * FROM auction_items ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css"> <!-- Link to your CSS -->
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <h1>Admin Dashboard</h1>
        </div>
        <nav class="navigation">
            <a href="auction_home.html" class="active">Home</a>
            <a href="auction.html">Auction Page</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <section class="dashboard">
            <h2>Manage Auction Items</h2>

            <!-- Add New Auction Item -->
            <button id="addAuctionButton">Add New Auction Item</button>

            <!-- Auction Items Table -->
            <table class="auction-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Starting Bid</th>
                        <th>End Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="auctionItemsTable">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($item = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['id']) ?></td>
                                <td>
                                    <img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="50">
                                </td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= htmlspecialchars($item['description']) ?></td>
                                <td>₹<?= htmlspecialchars($item['starting_bid']) ?></td>
                                <td><?= htmlspecialchars($item['end_time']) ?></td>
                                <td>
                                    <button class="edit-button" data-id="<?= $item['id'] ?>">Edit</button>
                                    <form method="POST" action="admin_functions.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <button type="submit" name="action" value="delete" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No auction items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Add/Edit Form Modal -->
        <div id="formModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 id="formTitle">Add New Auction Item</h3>
                <form id="auctionForm" method="POST" action="admin_functions.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="itemId">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>

                    <label for="starting_bid">Starting Bid:</label>
                    <input type="number" name="starting_bid" id="starting_bid" required>

                    <label for="end_time">End Time:</label>
                    <input type="datetime-local" name="end_time" id="end_time" required>

                    <label for="image">Image:</label>
                    <input type="file" name="image" id="image" accept="image/*">

                    <button type="submit" name="action" value="save">Save</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>© 2024 Admin Dashboard. All rights reserved.</p>
    </footer>

    <script src="admin_dashboard.js"></script> <!-- Link to JavaScript -->
</body>
</html>
