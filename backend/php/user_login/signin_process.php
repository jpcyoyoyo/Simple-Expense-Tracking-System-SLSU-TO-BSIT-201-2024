<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password']; // No need to sanitize as it's hashed

    // Prepare SQL statement to check user existence
    $stmt = $conn->prepare("SELECT id, username, fullname, email, password, dashboard_id, profile_pic, is_admin, question_id FROM user_accounts WHERE username = ?");
    if (!$stmt) {
        die("Database query preparation failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username);

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Create log for successful login
            $log_description = "User {$user['username']} logged in successfully.";
            $status = 1; // Success
            createLog($conn, $user['id'], $log_description, $status);

            // Check if security question is not set
            if ($user['question_id'] === null) {
                $_SESSION['user_id'] = $user['id'];
                $log_description = "User {$user['username']} redirected to security question to finish setup.";
                $status = 1; // Success
                createLog($conn, $user['id'], $log_description, $status);
                header("Location: securityquestion.php");
                exit();
            }

            // Password is correct, store user data in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['dashboard_id'] = $user['dashboard_id'];
            $_SESSION['settings_id'] = $user['settings_id'];
            $_SESSION['question_id'] = $user['question_id'];
            $_SESSION['profile_pic'] = $user['profile_pic'];
            $_SESSION['is_admin'] = (bool)$user['is_admin'];

            // Update `is_login` to 1
            $update_login_sql = "UPDATE user_accounts SET is_login = 1 WHERE id = ?";
            $update_stmt = $conn->prepare($update_login_sql);
            if ($update_stmt) {
                $update_stmt->bind_param("i", $user['id']);
                if (!$update_stmt->execute()) {
                    // Log the error
                    error_log("Error updating is_login for user ID {$user['id']}: " . $update_stmt->error);
                }
                $update_stmt->close();
            } else {
                error_log("Error preparing update statement: " . $conn->error);
            }

            // Redirect based on role
            if ($user['is_admin']) {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error_message = "Incorrect username or password.";
            // Create log for failed login attempt
            $log_description = "Failed login attempt for username: {$username}. Incorrect password.";
            $status = 0; // Error
            createLog($conn, null, $log_description, $status); // No user_id for failed login
        }
    } else {
        $error_message = "Incorrect username or password.";
        // Create log for failed login attempt
        $log_description = "Failed login attempt for username: {$username}. User does not exist.";
        $status = 0; // Error
        createLog($conn, null, $log_description, $status); // No user_id for failed login
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

