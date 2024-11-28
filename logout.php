<?php
session_start();

include 'backend/php/create_log.php';

if (isset($_SESSION['user_id'])) {
    // Database connection (ensure $conn is properly initialized)
    include 'conn/conn.php'; // Replace with your actual connection file path

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Prepare the update query to set `is_login` to 0
    $update_sql = "UPDATE user_accounts SET is_login = 0 WHERE id = ?";
    $stmt = $conn->prepare($update_sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);

        if (!$stmt->execute()) {
            // Handle execution error
            error_log("Error updating is_login: " . $stmt->error);
        }
        $stmt->close();
    } else {
        // Handle preparation error
        error_log("Error preparing statement: " . $conn->error);
    }

    // Create a log record for the logout
    createLog($conn, $user_id, "User {$username} logged out", 1);

    $conn->close();
}

// Unset and destroy the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: signin.php");
exit();


