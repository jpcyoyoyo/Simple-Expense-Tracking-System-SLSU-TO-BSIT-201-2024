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
    $is_admin = 0;

    $error_message = "";

    // Check if the username or email already exists
    $check_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user_accounts WHERE username = ? OR email = ?");
    if ($check_stmt) {
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            // Log the duplicate entry attempt
            $log_description = "Registration failed. Username: {$username} or Email: {$email} already exists.";
            createLog($conn, null, $log_description, 0);

            // Return error message for duplicate username or email
            $error_message = "Username or email already exists. Please choose another.";
        } else {
            // Password match check
            if ($password === $confirm_password) {
                // Hash the password before saving
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Prepare SQL to prevent SQL injection
                $stmt = $conn->prepare("INSERT INTO user_accounts (fullname, username, email, password, profile_pic, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sssssi", $fullname, $username, $email, $hashed_password, $profile_pic, $is_admin);

                    // Execute the statement and check if the insertion was successful
                    if ($stmt->execute()) {
                        // Retrieve the ID of the newly inserted user
                        $user_id = $conn->insert_id;

                        // Log successful registration
                        $log_description = "User {$username} registered successfully.";
                        createLog($conn, $user_id, $log_description, 1);

                        // Store user data in session for use in securityquestion.php
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['username'] = $username;

                        // Redirect to the security questions page
                        header("Location: securityquestion.php");
                        exit();
                    } else {
                        // Log registration error
                        $log_description = "Registration failed for username: {$username}. Error: " . $stmt->error;
                        createLog($conn, null, $log_description, 0);

                        // Show error if SQL execution fails
                        $error_message = "Error: " . $stmt->error;
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    // Log statement preparation error
                    $log_description = "Registration statement preparation failed for username: {$username}. Error: " . $conn->error;
                    createLog($conn, null, $log_description, 0);

                    // Handle preparation errors
                    $error_message = "Error preparing statement: " . $conn->error;
                }
            } else {
                // Log password mismatch error
                $log_description = "Registration failed for username: {$username}. Passwords do not match.";
                createLog($conn, null, $log_description, 0);

                // If passwords don't match, display an error
                $error_message = "Passwords do not match!";
            }
        }
    } else {
        // Log query preparation error
        $log_description = "Check for existing username or email failed. Error: " . $conn->error;
        createLog($conn, null, $log_description, 0);

        $error_message = "Error checking existing username or email: " . $conn->error;
    }
}

// Close the connection at the end
$conn->close();
