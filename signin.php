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
    <title>SignIn</title>

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

    <div class="container login-section">
        <h2>LOG IN</h2>
        <form class="login-form" action="dashboard.php" method="get">
            <input type="text" placeholder="Username" required>
            <input type="password" placeholder="Password" required>
            <input type="button" value="Log In" onclick="submitForm()">
            <div class="signup-link">
                <a href="forgotpassword.php">Forgot Password?</a>
            </div>
            <div class="signup-link">
                Don't have an account yet? <a href="signup.php">Sign Up</a>
            </div>
        </form>
    </div>

    <script>
        function submitForm() {
            document.querySelector('.login-form').submit();
        }
    </script>
</body>

</html>