<?php
    include "conn/conn.php";
    include "backend/php/user_login/signup_process.php";
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq Sans:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" type="text/css" rel="stylesheet">
    <title>Sign Up</title>

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
        <h2>SIGN UP</h2>
        <form class="signup-form" action="" method="post">
            <input name="fullname" type="text" placeholder="Full Name" required>
            <input name="username" type="text" placeholder="Username" required>
            <input name="email" type="email" placeholder="Email" required>
            <input id="password" name="password" type="password" placeholder="Create Password" required>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" required>
            <button type="submit" class="btn-submit">Next</button>
            <div class="login-link">
                Already have an account? <a href="signin.php">Log In</a>
            </div>
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