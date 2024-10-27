<?php
    session_start(); // Start the session at the beginning of the script

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input data
        $fullname = mysqli_real_escape_string($conn, trim($_POST['fullname']));
        $username = mysqli_real_escape_string($conn, trim($_POST['username']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $profile_pic = "profile_pic/profile_default.svg";

        $error_message = "";
        
        // Password match check
        if ($password === $confirm_password) {
            // Hash the password before saving
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare SQL to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO user_accounts (fullname, username, email, password, profile_pic) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $username, $email, $hashed_password, $profile_pic);

            // Execute the statement and check if the insertion was successful
            if ($stmt->execute()) {
                // Store the username in session for use in securityquestion.php
                $_SESSION['username'] = $username;

                // Redirect to the security questions page
                header("Location: securityquestion.php");
                exit();
            } else {
                // Show error if SQL execution fails
                $error_message = "Error: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            // If passwords don't match, display an error
            $error_message = "Passwords do not match!";
        }
    }

    // Close the connection at the end
    $conn->close();