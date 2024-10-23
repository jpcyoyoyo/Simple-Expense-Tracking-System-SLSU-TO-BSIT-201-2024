<?php
    session_start();

    // Check if the session contains the username from the previous step
    if (!isset($_SESSION['forgot_password_username'])) {
        header("Location: forgotpassword.php"); // Redirect back if no username is found
        exit();
    }

    $username = $_SESSION['forgot_password_username'];

    // Fetch the old password for the current user (hashed password)
    $query = "SELECT password FROM user_accounts WHERE username = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username);
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
            $error_message = "Passwords do not match!";
        } else {
            // Hash the new password
            $hashed_password = password_hash($change_password, PASSWORD_DEFAULT);

            // Check if the new password is the same as the old password
            if (password_verify($change_password, $old_password)) {
                $error_message = "You have entered the old password. Please choose a new password.";
            } else {
                // Update the password in the database
                $update_query = "UPDATE user_accounts SET password = ? WHERE username = ?";
                if ($stmt = $conn->prepare($update_query)) {
                    $stmt->bind_param("ss", $hashed_password, $username);

                    // Execute the statement and check if the update was successful
                    if ($stmt->execute()) {
                        // If everything is successful, redirect to the sign-in page
                        header("Location: signin.php");
                        session_destroy();
                        exit();
                    } else {
                        $error_message = "Error: " . $stmt->error;
                    }

                    $stmt->close();
                }
            }
        }
    }

    // Close the connection at the end
    $conn->close();