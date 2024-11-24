<?php
session_start();
require_once 'db_connection.php'; // Include your database connection file

$error = ''; // To store error messages

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Please fill in both username and password.';
    } else {
        // Query to fetch admin details
        $query = "SELECT * FROM admin_users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            // Verify the hashed password
            if (password_verify($password, $admin['password'])) {
                // Set session variables and redirect to dashboard
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: admin_dashboard.php'); // Updated to redirect to the PHP dashboard
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
