<?php
session_start(); // Start a session to store the username or user ID from the previous page

// Ensure the user is coming from the signup page
if (!isset($_SESSION['username'])) {
    header("Location: signup.php"); // Redirect if no session
    exit();
}

include "conn/conn.php"; // Include the database connection file

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
                    // After successfully updating the question_id, fetch the user's full name
                    $fetch_name_sql = "SELECT fullname FROM user_accounts WHERE username = ?";

                    if ($fetch_stmt = $conn->prepare($fetch_name_sql)) {
                        // Bind the username to the SQL query
                        $fetch_stmt->bind_param("s", $username);
                        $fetch_stmt->execute();
                        $fetch_stmt->bind_result($fullname);
                        
                        // Fetch the full name and store it in the session
                        if ($fetch_stmt->fetch()) {
                            $_SESSION['fullname'] = $fullname; // Store the full name in session
                            $_SESSION['email'] = $email;
                            $_SESSION['user_id'] = $id;
                        }

                        // Close the fetch statement
                        $fetch_stmt->close();
                    }

                    // Redirect to dashboard or success page
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Error updating user account: $update_stmt->error";
                }

                // Close the update statement
                $update_stmt->close();
            }
        } else {
            echo "Error inserting security questions: $insert_stmt->error";
        }

        // Close the insert statement
        $insert_stmt->close();
    }

    // Close connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <title>Security Questions</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/main_app.css">
    <link rel="stylesheet" href="css/user_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMMLO5LUiwceQm28D5pZpJTx0Os6Kr29ssOb+v7" crossorigin="anonymous" />
    
    <style>
        body {
            background-image: url("assets/backim.png");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            font-family: Balsamiq Sans;
        }
        
    </style>

</head>
<body>
    <div class="welcome-section">
        <h1>WELCOME</h1>
        <p>We empower you to take control of your finances. Whether you’re managing personal expenses, tracking business costs, or planning for future savings, our intuitive platform is designed to make expense tracking simple and effective.</p>
    </div>

    <div class="container signup-section">
        <h2>SECURITY QUESTIONS</h2>
        
        <form class="securityq-form" action="" method="post">
            <input type="text" name="q1" placeholder="Question 1" required>
            <input type="text" name="q1_answer" placeholder="Answer 1" required>
            <input type="text" name="q2" placeholder="Question 2" required>
            <input type="text" name="q2_answer" placeholder="Answer 2" required>
            <input type="text" name="q3" placeholder="Question 3" required>
            <input type="text" name="q3_answer" placeholder="Answer 3" required>
            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>