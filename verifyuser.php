<?php
    include "conn/conn.php";
    session_start();

    // Check if the session contains the username from the previous step
    if (!isset($_SESSION['forgot_password_username'])) {
        header("Location: forgotpassword.php"); // Redirect back if no username is found
        exit();
    }

    $username = $_SESSION['forgot_password_username'];

    // Fetch security questions based on the username
    $query = "SELECT q1, q2, q3, q1_answer, q2_answer, q3_answer FROM user_accounts WHERE username = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($q1, $q2, $q3, $stored_q1_answer, $stored_q2_answer, $stored_q3_answer);
        $stmt->fetch();
        $stmt->close();
    }

    $error_message = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the submitted answers
        $q1_answer = mysqli_real_escape_string($conn, trim($_POST['q1_answer']));
        $q2_answer = mysqli_real_escape_string($conn, trim($_POST['q2_answer']));
        $q3_answer = mysqli_real_escape_string($conn, trim($_POST['q3_answer']));

        // Compare submitted answers with the stored answers (case-insensitive)
        if (strtolower($q1_answer) == strtolower($stored_q1_answer) &&
            strtolower($q2_answer) == strtolower($stored_q2_answer) &&
            strtolower($q3_answer) == strtolower($stored_q3_answer)) {
            // Answers match, proceed to reset password
            header("Location: resetpassword.php");
            exit();
        } else {
            // If answers do not match, show an error message
            $error_message = "Your answers are incorrect. Please try again.";
        }
    }
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
    <title>Verify User</title>

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

    <div class="container verifyuser-section">
        <h2>VERIFY USER</h2>

        <form class="securityq-form" action="" method="post">
            <!-- Pre-fill the security questions from the database -->
            <label for="q1">Question 1:</label>
            <input type="text" id="q1" name="q1" value="<?php echo $q1; ?>" disabled>
            <input type="text" name="q1_answer" placeholder="Answer 1" required>
            
            <label for="q2">Question 2:</label>
            <input type="text" id="q2" name="q2" value="<?php echo $q2; ?>" disabled>
            <input type="text" name="q2_answer" placeholder="Answer 2" required>
            
            <label for="q3">Question 3:</label>
            <input type="text" id="q3" name="q3" value="<?php echo $q3; ?>" disabled>
            <input type="text" name="q3_answer" placeholder="Answer 3" required>

            <button type="submit" class="btn-submit">Submit</button>
        </form>

        <!-- Display error message if the answers do not match -->
        <?php
            if (!empty($error_message)) {
                echo '<div class="error-message">' . $error_message . '</div>';
            }
        ?>
    </div>
</body>
</html>