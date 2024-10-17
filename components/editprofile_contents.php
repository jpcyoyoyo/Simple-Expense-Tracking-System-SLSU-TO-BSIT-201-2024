<?php
// Assuming you retrieve the current user information from the database
$user = [
    'fullname' => 'John Doe',
    'username' => 'johndoe123',
    'email' => 'john@example.com',
    'password' => '' // Do not show actual password
];

// Path to the profile image
$profileImage = 'backim.png'; // Set the path to your current profile picture
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <!-- CSS -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Cambria;
            background-image: url('backim.png'); /* Background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: auto; /* Make the page scrollable */
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh; /* Ensure container can grow beyond the viewport */
            padding-top: 60px; /* Padding from the top */
        }

        .form-container {
            position: relative;
            background-color: rgba(255, 255, 255, 0.85);
            padding: 60px 40px 40px; /* Adjust top padding for better spacing */
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 60px; /* Added space from the top */
        }

        /* Profile picture container */
        .profile-pic-container {
            position: absolute;
            top: -60px; /* Makes it overlap the form */
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
            margin-top: 60px; /* Reduced space between the profile text and the form content */
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

        /* "Change Profile" text style */
        .change-profile-text {
            display: block;
            margin-top: 15px; /* Reduced margin for better spacing */
            color: #007bff;
            cursor: pointer;
            font-size: 14px;
            text-decoration: underline;
        }

        .change-profile-text:hover {
            color: #0056b3;
        }

        /* Hide file input */
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
            <img src="<?php echo $profileImage; ?>" alt="Profile Picture"> <!-- Display image inside the frame -->
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

<!-- JavaScript -->
<script>
    // Preview selected profile picture
    function previewProfilePic(event) {
        const profilePic = document.querySelector('.profile-pic-container img');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePic.src = e.target.result; // Replace the current profile picture
            };
            reader.readAsDataURL(file); // Read the selected file as a data URL
        }
    }
</script>

</body>
</html>
