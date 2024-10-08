<?php
    include "conn/conn.php";
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq Sans:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" type="text/css" rel="stylesheet">
    <title>Reset Password</title>

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
        <h2>RESET PASSWORD</h2>
        <form class="signup-form" action="" method="post">
            <input id="password" name="password" type="password" placeholder="Create Password" required>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" required>
            <button type="submit" class="btn-submit">Finish</button>
            <!-- Error message for password mismatch -->
            <?php
            // Display any error message if present
            if (!empty($error_message)) {
                echo '<div class="error-message">' . $error_message . '</div>';
            }
            ?>
        </form>
    </div>

</body>
</html>