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


<div class="app_body">
    <div class="form-container col-12">
        <div class="row container-fluid" style="padding: 0 !important;">
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
                        <div class="form-group">
                            <label for="fullname">Full Name:</label>
                            <input type="text" id="edit-profile-fullname" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="edit-profile-username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="edit-profile-email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        
                        <div class="form-group-full d-flex justify-content-end align-items-end">
                            <button type="submit" class="btn_submit-primary">Update Profile</button>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
