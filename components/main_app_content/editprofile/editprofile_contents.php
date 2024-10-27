<?php
/*
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Adjust this according to your setup
$dbname = "expense_tracker";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a user ID from a session or another method
$userId = 1; // Replace with dynamic user ID from session or authentication

// Fetch user information from the database (table: user_accounts)
$sql = "SELECT fullname, username, email, profile_picture FROM user_accounts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ID);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // If no user data, set defaults
    $user = [
        'fullname' => '',
        'username' => '',
        'email' => '',
        'profile_picture' => 'backim.png' // Default profile picture
    ];
}

// Close the connection
$conn->close();
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <!-- CSS styles (remains unchanged) -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Cambria;
            background-image: url('backim.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: auto;
        }
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 60px;
        }
        .form-container {
            position: relative;
            background-color: rgba(255, 255, 255, 0.85);
            padding: 60px 40px 40px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 60px;
        }
        .profile-pic-container {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }
        .profile-pic-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .form-content {
            margin-top: 60px;
            text-align: left;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }
        .form-container input {
            padding: 10px;
            margin-bottom: 20px;
            width: calc(100% - 20px);
            margin-left: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-container button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: calc(100% - 20px);
            margin-left: 10px;
            margin-right: 10px;
            font-size: 16px;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .change-profile-text {
            display: block;
            margin-top: 15px;
            color: #007bff;
            cursor: pointer;
            font-size: 14px;
            text-decoration: underline;
        }
        .change-profile-text:hover {
            color: #0056b3;
        }
        .file-input {
            display: none;
        }
    </style>
</head>
<body>

<div class="center-container">
    <div class="form-container">
        <!-- Circular profile picture -->
        <div class="profile-pic-container">
            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture"> <!-- Display image inside the frame -->
        </div>

        <!-- "Change Profile" text -->
        <span class="change-profile-text" onclick="document.getElementById('profilePicInput').click();">
            Change Profile Picture
        </span>

        <!-- Hidden file input -->
        <input type="file" id="profilePicInput" class="file-input" name="profilePic" accept="image/*" onchange="previewProfilePic(event)">

        <div class="form-content">
            <form method="POST" action="editprofile_content_process.php" enctype="multipart/form-data">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password if you want to change it">

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for profile picture preview -->
<script>
    function previewProfilePic(event) {
        const profilePic = document.querySelector('.profile-pic-container img');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePic.src = e.target.result; // Replace the current profile picture
            };
            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>
