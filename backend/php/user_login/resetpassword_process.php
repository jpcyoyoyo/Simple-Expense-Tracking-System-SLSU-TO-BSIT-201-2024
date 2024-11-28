<?php
session_start();

// Check if the session contains the username from the previous step
if (!isset($_SESSION['user_id'])) {
    header("Location: forgotpassword.php"); // Redirect back if no username is found
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Fetch the old password for the current user (hashed password)
$query = "SELECT password FROM user_accounts WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($old_password);
    $stmt->fetch();
    $stmt->close();
}

$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $change_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($change_password !== $confirm_password) {
        $error_message = "User {$username}: Passwords do not match!";
        createLog($conn, $user_id, $error_message, 0);
    } else {
        // Hash the new password
        $hashed_password = password_hash($change_password, PASSWORD_DEFAULT);

        // Check if the new password is the same as the old password
        if (password_verify($change_password, $old_password)) {
            $error_message = "User {$username}: You have entered the old password. Please choose a new password.";
            createLog($conn, $user_id, $error_message, 0);
        } else {
            // Update the password in the database
            $update_query = "UPDATE user_accounts SET password = ? WHERE id = ?";
            if ($stmt = $conn->prepare($update_query)) {
                $stmt->bind_param("ss", $hashed_password, $user_id);

                // Execute the statement and check if the update was successful
                if ($stmt->execute()) {
                    // Log the successful password change
                    createLog($conn, $user_id, "User {$username}: Password changed successfully.", 1);

                    // If everything is successful, redirect to the sign-in page
                    header("Location: signin.php");
                    session_destroy();
                    exit();
                } else {
                    $error_message = "Error: " . $stmt->error;
                    createLog($conn, $user_id, "User {$username}: Password change attempt failed: " . $stmt->error, 0);
                }

                $stmt->close();
            }
        }
    }
}

// Close the connection at the end
$conn->close();
