<?php
    include "conn/conn.php"; // Include the database connection file
    include 'backend/php/create_log.php';
    include "backend/php/user_login/securityquestion_process.php";
    include "backend/php/login_auth.php";
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
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" type="text/css" rel="stylesheet">
    <title>Security Questions</title>

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
    </div>
    
</body>
</html>