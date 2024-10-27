<?php
// Assuming you retrieve the current user information from the database

$user = [
    'fullname' => $_SESSION['fullname'],
    'username' => $_SESSION['username'],
    'email' => $_SESSION['email']
];

$profileImage = $_SESSION['profile_pic'];

?>

<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Edit Profile</h1>
</div>


<div class="form-container col-12">
    <div class="row container-fluid" style="margin: 0 !important;">
        <!-- Circular profile picture (col-12 for smaller screens, col-lg-4 for large screens) -->
        <div class="col-12 col-lg-4">
            <div class="row flex-column align-items-center">
                <div class="profile-pic-container mb-3">
                    <!-- Display image inside the frame -->
                    <img id="profile-pic" src="<?php echo $profileImage; ?>" alt="Profile Picture"> 
                </div>

                <!-- "Change Profile" text -->
                <span class="change-profile-text" onclick="document.getElementById('profilePicInput').click();">
                    Change Profile Picture
                </span>

                <!-- Hidden file input -->
                <input type="file" id="profilePicInput" class="file-input" name="profilePic" accept="image/*" onchange="previewProfilePic(event)">
            </div>
        </div>

        <!-- Form (col-12 for smaller screens, col-lg-8 for large screens) -->
        <div class="col-12 col-lg-8">
            <div class="form-content">
                <form method="POST" enctype="multipart/form-data" onsubmit="updateProfile(event)">
                    <div class="form-group mb-3">
                        <label for="fullname">Full Name:</label>
                        <input type="text" id="edit-profile-fullname" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="username">Username:</label>
                        <input type="text" id="edit-profile-username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" id="edit-profile-email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="form-group-full mb-3 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Update Profile</button>
                    </div>
                
                </form>
            </div>
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

    function updateProfile(event) {
        event.preventDefault();

        const form = document.querySelector('.form-content form');
        const formData = new FormData(form); // Collect form data
        const profilePicInput = document.getElementById('profilePicInput');

        // Check if a new profile picture is selected
        if (profilePicInput.files.length > 0) {
            formData.append('profilePic', profilePicInput.files[0]);
        }

        fetch('backend/php/main_app_content/editprofile/update_user_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'dashboard.php'; // Redirect to the dashboard if successful
            } else {
                console.error('Profile update failed:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Attach the event listener to the form submission
    // document.querySelector('.form-content form').addEventListener('submit', updateProfile);

</script>

