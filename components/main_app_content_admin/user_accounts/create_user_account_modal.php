<div id="user-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <span class="close" onclick="closeAccountModal()">&times;</span>
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h1>Create User Account</h1>
        </div>

        <div id="view-create-user-details">
            <div class="form-grid col-12">
            <form method="POST" enctype="multipart/form-data" id="create-account-form" onsubmit="createUserAccount(event)">
                <div class="row row-no-gutters">
                    <h2 class="mt-4">Input User Information</h2>
                    <div class="col-lg-4">
                        <div class="row flex-column">
                            <div class="profile-pic-container mb-3">
                                <!-- Default profile image -->
                                <img id="create-user-profile-pic" src="profile_pic/profile_default.svg" alt="Profile Picture">
                            </div>
                            <!-- "Upload Profile" text -->
                            <span class="change-profile-text" onclick="document.getElementById('createProfilePicInput').click();">
                                Upload Profile Picture
                            </span>
                            <!-- Hidden file input -->
                            <input type="file" id="createProfilePicInput" class="file-input" name="profilePic" accept="image/*" onchange="previewProfilePic(event)">
                        </div>
                    </div>
                    <div class="form-content col-lg-8">
                        
                            <div class="form-group row mt-2">
                                <div class="col-lg-4">
                                    <label for="fullname" class="col-form-label">Full Name:</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" id="create-user-fullname" name="fullname" class="form-control" placeholder="Enter fullname" required>
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <div class="col-lg-4">
                                    <label for="username" class="col-form-label">Username:</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" id="create-user-username" name="username" class="form-control" placeholder="Enter username" required>
                                </div>
                            </div>


                            <div class="form-group row mt-2">
                                <div class="col-lg-4">
                                    <label for="email" class="col-form-label">Email:</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="email" id="create-user-email" name="email" class="form-control" placeholder="Enter email" required>
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <div class="col-lg-4">
                                    <label for="password" class="col-form-label">Password:</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="password" id="create-user-password" name="password" class="form-control" placeholder="Create password" required autocomplete="new-password">
                                </div>
                            </div>


                            <div class="form-group row mt-2">
                                <div class="col-lg-4">
                                    <label for="confirm_password" class="col-form-label">Confirm Password:</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="password" id="create-user-confirm-password" name="confirm_password" class="form-control" placeholder="Confirm password" required autocomplete="new-password">
                                </div>
                            </div>
                        
                    </div>
                </div>

                <!-- Security Questions -->
                <div class="row row-no-gutters">
                    <div class="form-content">
                        <h2 class="mt-4">Set-up Security Questions</h2>

                        <!-- Question 1 -->
                        <div class="form-group row mt-3">
                            <div class="offset-lg-1 col-lg-3">
                                <label for="q1" class="col-form-label">Question 1:</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="q1" name="q1" class="form-control" placeholder="Enter Question 1" required>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="offset-lg-1 col-lg-3">
                                <label for="q1_answer" class="col-form-label">Answer 1:</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="q1_answer" class="form-control" placeholder="Enter Answer 1" required>
                            </div>
                        </div>

                        <!-- Question 2 -->
                        <div class="form-group row mt-3">
                            <div class="offset-lg-1 col-lg-3">
                                <label for="q2" class="col-form-label">Question 2:</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="q2" name="q2" class="form-control" placeholder="Enter Question 2" required>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="offset-lg-1 col-lg-3">
                                <label for="q2_answer" class="col-form-label">Answer 2:</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="q2_answer" class="form-control" placeholder="Enter Answer 2" required>
                            </div>
                        </div>

                        <!-- Question 3 -->
                        <div class="form-group row mt-3">
                            <div class="offset-lg-1 col-lg-3">
                                <label for="q3" class="col-form-label">Question 3:</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="q3" name="q3" class="form-control" placeholder="Enter Question 3" required>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="offset-lg-1 col-lg-3">
                                <label for="q3_answer" class="col-form-label">Answer 3:</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="q3_answer" class="form-control" placeholder="Enter Answer 3" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-6 offset-lg-6 d-flex justify-content-end align-items-end">
                        <button type="submit" id="create-user-btn" class="btn_submit-primary">Create User Account</button>
                    </div>
                </div>
            </div>
            </form>
        </div>

        <!-- Error Message -->
        <div id="create-modal-error-message" class="alert alert-danger" style="display: none;"></div>
    </div>
</div>
