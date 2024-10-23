<?php
session_start(); // Start a session to store the username or user ID from the previous page

// Ensure the user is coming from the signup page
if (!isset($_SESSION['username'])) {
    header("Location: signup.php"); // Redirect if no session
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $q1 = mysqli_real_escape_string($conn, trim($_POST['q1']));
    $q1_answer = mysqli_real_escape_string($conn, trim($_POST['q1_answer']));
    $q2 = mysqli_real_escape_string($conn, trim($_POST['q2']));
    $q2_answer = mysqli_real_escape_string($conn, trim($_POST['q2_answer']));
    $q3 = mysqli_real_escape_string($conn, trim($_POST['q3']));
    $q3_answer = mysqli_real_escape_string($conn, trim($_POST['q3_answer']));

    // Get the username from session
    $username = $_SESSION['username'];

    // Insert into the security_q table
    $insert_sql = "INSERT INTO security_q (q1, q1_answer, q2, q2_answer, q3, q3_answer) VALUES (?, ?, ?, ?, ?, ?)";
    
    // Prepare insert statement
    if ($insert_stmt = $conn->prepare($insert_sql)) {
        // Bind parameters
        $insert_stmt->bind_param("ssssss", $q1, $q1_answer, $q2, $q2_answer, $q3, $q3_answer);
        
        // Execute the insert statement
        if ($insert_stmt->execute()) {
            // Get the ID of the newly inserted row
            $question_id = $conn->insert_id; 

            // Now update the user_accounts table with the question_id
            $update_sql = "UPDATE user_accounts SET question_id = ? WHERE username = ?";
            
            if ($update_stmt = $conn->prepare($update_sql)) {
                // Bind parameters for update
                $update_stmt->bind_param("is", $question_id, $username);

                // Execute the update statement
                if ($update_stmt->execute()) {
                    // Now insert default values into the dashboard table
                    $insert_dashboard_sql = "INSERT INTO dashboard (balance, expense_total, deposit_total, expense_count, deposit_count) VALUES (0.00, 0.00, 0.00, 0, 0)";

                    if ($dashboard_stmt = $conn->prepare($insert_dashboard_sql)) {
                        // Execute the insert statement for dashboard
                        if ($dashboard_stmt->execute()) {
                            // Get the dashboard ID
                            $dashboard_id = $conn->insert_id;

                            // Now update the user_accounts table with the dashboard_id
                            $update_dashboard_sql = "UPDATE user_accounts SET dashboard_id = ? WHERE username = ?";

                            if ($update_dashboard_stmt = $conn->prepare($update_dashboard_sql)) {
                                // Bind parameters for updating the dashboard_id
                                $update_dashboard_stmt->bind_param("is", $dashboard_id, $username);

                                // Execute the update statement
                                if ($update_dashboard_stmt->execute()) {
                                    // Store the dashboard_id in the session
                                    $_SESSION['dashboard_id'] = $dashboard_id;

                                    // Fetch user's full name, email, and user_id
                                    $fetch_name_sql = "SELECT fullname, email, id FROM user_accounts WHERE username = ?";
                                    if ($fetch_stmt = $conn->prepare($fetch_name_sql)) {
                                        $fetch_stmt->bind_param("s", $username);
                                        $fetch_stmt->execute();
                                        $fetch_stmt->bind_result($fullname, $email, $id);

                                        if ($fetch_stmt->fetch()) {
                                            $_SESSION['fullname'] = $fullname;
                                            $_SESSION['email'] = $email;
                                            $_SESSION['user_id'] = $id;
                                        }

                                        $fetch_stmt->close();
                                    }

                                    // Redirect to dashboard or success page
                                    header("Location: dashboard.php");
                                    exit();
                                } else {
                                    echo "Error updating dashboard_id: " . $update_dashboard_stmt->error;
                                }
                                $update_dashboard_stmt->close();
                            }
                        } else {
                            echo "Error inserting default dashboard data: " . $dashboard_stmt->error;
                        }
                        $dashboard_stmt->close();
                    }
                } else {
                    echo "Error updating user account with question_id: " . $update_stmt->error;
                }

                $update_stmt->close();
            }
        } else {
            echo "Error inserting security questions: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }

    $conn->close();
}