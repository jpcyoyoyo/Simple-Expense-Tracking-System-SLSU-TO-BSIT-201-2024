<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the username input
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));

    // Query to check if the username exists
    $query = "SELECT username, question_id, id FROM user_accounts WHERE username = ?";
    $error_message = "";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // Fetch query results
        $stmt->store_result(); // Store result to free the connection for further use
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($db_username, $question_id, $user_id);
            $stmt->fetch();

            // Log the successful lookup
            $log_description = "User {$db_username} initiated a 'Forgot Password' request.";
            $status = 1; // Success
            createLog($conn, $user_id, $log_description, $status);

            // Store the username and question_id in session and proceed to the next step
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['question_id'] = $question_id;

            header("Location: verifyuser.php"); // Redirect to security questions page
            exit();
        } else {
            // Log the failed lookup attempt
            $log_description = "Failed 'Forgot Password' attempt for username: {$username}. Username not found.";
            $status = 0; // Error
            createLog($conn, null, $log_description, $status);

            $error_message = "Username {$username} not found. Please try again.";
        }

        $stmt->close(); // Close the statement
    } else {
        $error_message = "Database query error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
