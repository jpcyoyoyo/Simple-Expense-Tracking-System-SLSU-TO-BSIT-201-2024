<?php
session_start(); // Start the session
include "conn/conn.php"; // Include your database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input username and password from the form
    $loginUsername = $_POST['username'];
    $loginPassword = $_POST['password'];

    // Prepare the SQL query to fetch the user based on the username
    $sql = "SELECT id, fullname, username, password FROM user_accounts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $loginUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($loginPassword, $user['password'])) {
            // Store user information in session
            $_SESSION['userId'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];

            // Redirect to the dashboard or desired page
            header("Location: dashboard.php");
            exit(); // Stop further execution
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
    $conn->close();
} else {
    // If user is already logged in, redirect to dashboard
    if (isset($_SESSION['username']) && isset($_SESSION['fullname'])) {
        header("Location: dashboard.php");
        exit(); // Stop further execution
    } else {
        // If not logged in, show the login form or redirect
        header("Location: signin.php");
        exit(); // Stop further execution
    }
}
?>
