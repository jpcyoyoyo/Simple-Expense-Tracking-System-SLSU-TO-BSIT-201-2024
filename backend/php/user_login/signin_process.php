<?php

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize inputs
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password']; // Password will be hashed, no need to sanitize here

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, fullname, email, password, dashboard_id, profile_pic FROM user_accounts WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, store user data in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['dashboard_id'] = $user['dashboard_id'];
            $_SESSION['profile_pic'] = $user['profile_pic'];
            // You can store other user details in session as needed

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            $error_message = "Incorrect username or password.";
        }
    } else {
        // User does not exist
        $error_message = "Incorrect username or password.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
