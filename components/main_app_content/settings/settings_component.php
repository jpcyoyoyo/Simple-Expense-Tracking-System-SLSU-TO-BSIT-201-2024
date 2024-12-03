<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Settings</h1>
</div>

<div class="app_body container-fluid">
    <!-- Two-Column Settings Layout -->
    <div class="settings-grid">
        <!-- Appearance Settings Section -->
        <div class="settings-column">
            <h2>Appearance Settings</h2>
            <!-- Dark Mode Toggle -->
            <div class="setting-item">
                <div class="row align-items-center">
                    <div class="col-sm-4">
                        <label for="theme-select" class="form-label">Theme</label>
                    </div>
                    <div class="col-sm-8 text-end">
                        <select id="theme-selector" class="form-select">
                            <option value="default" selected>Default</option>
                            <option value="dark">Dark</option>
                            <option value="light">Light</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Settings Section -->
        <div class="settings-column">
            <h2>User Settings</h2>
            <!-- Change Password Button -->
            <div class="setting-item">
                <label for="change-password" class="form-label">Change Password</label>
                <button class="btn btn-primary w-100" id="change-password-btn" onclick="changePassword()">Change Password</button>
            </div>
            <!-- Deactivate Account Section -->
            <div class="setting-item">
                <label for="Delete-account" class="form-label">Delete Account</label>
                <p class="text-muted small">
                    Deleting your account will remove all your data forever.
                </p>
                <button class="btn btn-danger w-100" id="Delete-account-btn" onclick="deleteAccount()">Delete Account</button>
            </div>
        </div>
    </div>
</div>

