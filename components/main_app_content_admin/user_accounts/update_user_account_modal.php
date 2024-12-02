<!-- Modal for Edit User Account -->
<div id="edit-user-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
    <span class="close" onclick="closeEditAccountModal()">&times;</span>
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h1>Edit User Account</h1>
        </div>

        <div id="view-user-details">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                    <div class="col-lg-6">
                        <div class="row flex-column align-items-center">
                            <div class="profile-pic-container mb-3">
                                <!-- Display image inside the frame -->
                                <img id="edit-user-profile-pic" src="" alt="Profile Picture"> 

                            </div>
                            <!-- "Change Profile" text -->
                            <span class="change-profile-text" onclick="document.getElementById('profilePicInput').click();">
                                Change Profile Picture
                            </span>

                            <!-- Hidden file input -->
                            <input type="file" id="profilePicInput" class="file-input" name="profilePic" accept="image/*" onchange="previewProfilePic(event)">
                        
                        </div>
                    </div>

                    <div class="form-content col-lg-6" style="padding: 0 40px;">
                    <input type="hidden" id="user-id">
                    <input type="hidden" id="prev-user-profile-pic">
                        <form method="POST" enctype="multipart/form-data" onsubmit="editUserAccount(event)">
                            <div class="form-group">
                                <label for="fullname">Full Name:</label>
                                <input type="text" id="edit-user-fullname" name="fullname" class="form-control" placeholder="Enter fullname" required>
                            </div>

                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="edit-user-username" name="username" class="form-control" placeholder="Enter username" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="edit-user-email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>

                            <div class="row row-no-gutters">
                                <div class="form-group col-lg-12 d-flex justify-content-end">
                                    <button type="submit" class="btn_submit-primary" style="margin: 0 10px;">Edit User</button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <div id="edit-modal-error-message" class="alert alert-danger" style="display: none;"></div>
    </div>
</div>
