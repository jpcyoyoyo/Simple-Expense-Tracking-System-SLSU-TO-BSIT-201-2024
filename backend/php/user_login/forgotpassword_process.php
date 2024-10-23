<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get and sanitize the username input
        $username = mysqli_real_escape_string($conn, trim($_POST['username']));
        
        // Query to check if username exists in the database
        $query = "SELECT username, question_id FROM user_accounts WHERE username = ?";

        $error_message = "";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($db_username, $question_id); // Bind the result to variables
            $stmt->fetch(); // Fetch the result

            // Check if the username exists
            if ($db_username) {
                // Store the username and question_id in session and proceed to the next step
                $_SESSION['forgot_password_username'] = $db_username;
                $_SESSION['question_id'] = $question_id;
                header("Location: verifyuser.php"); // Redirect to security questions page
                exit();
            } else {
                $error_message = "Username not found. Please try again.";
            }

            $stmt->close();
        }
        
        // Close the database connection
        $conn->close();
    }
