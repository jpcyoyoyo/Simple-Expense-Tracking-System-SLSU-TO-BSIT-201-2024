<?php
// Define the path to the background image
$backgroundImage = 'assets/background.jpg'; // Replace with your image path
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form with Background</title>

    <!-- CSS -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('<?php echo $backgroundImage; ?>'); /* Background image from PHP */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Form container */
        .form-container {
            background-color: rgba(255, 255, 255, 0.85); /* Slight transparency for the form background */
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            width: 300px; /* Fixed width for the form */
        }

        /* Form labels */
        .form-container label {
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        /* Form inputs */
        .form-container input {
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Submit button */
        .form-container button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>

<div class="center-container">
    <form class="form-container" method="POST" action="process_signup.php">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button type="submit">Sign Up</button>
    </form>
</div>

</body>
</html>
