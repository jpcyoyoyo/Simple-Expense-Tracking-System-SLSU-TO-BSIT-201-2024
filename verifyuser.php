<?php
    include "conn/conn.php";
    include 'backend/php/create_log.php';
    include "backend/php/user_login/verifyuser_process.php";
    include "backend/php/login_auth.php";
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
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" type="text/css" rel="stylesheet">
    <title>Verify User</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/main_app.css">
    <link rel="stylesheet" href="css/user_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMMLO5LUiwceQm28D5pZpJTx0Os6Kr29ssOb+v7" crossorigin="anonymous" />

</head>

<body>
    <div class="user-login row">
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
    </div>
    
</body>
</html>