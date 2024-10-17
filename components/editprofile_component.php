<?php
// Assuming you retrieve the current user information from the database
$user = [
    'fullname' => 'John Doe',
    'username' => 'johndoe123',
    'email' => 'john@example.com',
    'password' => '' // Do not show actual password
];
?>

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

