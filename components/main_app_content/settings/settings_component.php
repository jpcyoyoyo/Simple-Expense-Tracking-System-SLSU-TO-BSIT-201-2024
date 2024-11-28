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
                        <label for="font-size" class="form-label">Theme</label>
                    </div>
                    <div class="col-sm-8 text-end">
                        <select id="font-size" class="form-select">
                            <option value="default" selected>Default</option>
                            <option value="dark">Dark</option>
                            <option value="light">Light</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Font Size Selector -->
            <div class="setting-item">
                <div class="row align-items-center">
                    <div class="col-sm-4">
                        <label for="font-size" class="form-label">Font Size</label>
                    </div>
                    <div class="col-sm-8 text-end">
                        <select id="font-size" class="form-select">
                            <option value="small">Small</option>
                            <option value="medium" selected>Medium</option>
                            <option value="large">Large</option>
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
                <button class="btn btn-danger w-100" id="Delete-account-btn">Delete Account</button>
            </div>
        </div>
    </div>
</div>

<script>
function OpenVerifyUserModal() {
    document.getElementById("verifyuser-modal").style.display = "block";
}

function closeVerifyUserModal() {
    document.getElementById("verifyuser-modal").style.display = "none";
}

function OpenResetPasswordModal() {
    document.getElementById("resetpassword-modal").style.display = "block";
}

function closeResetPasswordModal() {
    document.getElementById("resetpassword-modal").style.display = "none";
}

function changePassword() {

    // Fetch security questions from the server
    fetch('backend/php/main_app_content/settings/fetch_questions.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ user_id: sessionStorage.getItem("user_id") }) // Adjust as needed
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            // Populate modal fields with fetched questions
            document.getElementById("q1").value = data.question.q1 || "No Question Available";
            document.getElementById("q2").value = data.question.q2 || "No Question Available";
            document.getElementById("q3").value = data.question.q3 || "No Question Available";
        } else {
            alert("Failed to fetch security questions: " + data.message);
        }
    })
    .catch((error) => {
        console.error("Error fetching security questions:", error);
        alert("An error occurred. Please try again.");
    });

    // Open the modal
    OpenVerifyUserModal();
}

function verifyUser(event) {
    event.preventDefault(); // Prevent the default form submission

    // Gather form data
    const q1_answer = document.querySelector("input[name='q1_answer']").value.trim();
    const q2_answer = document.querySelector("input[name='q2_answer']").value.trim();
    const q3_answer = document.querySelector("input[name='q3_answer']").value.trim();

    // Send the answers to the backend for verification
    fetch('backend/php/main_app_content/settings/verify_answers.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ 
            user_id: sessionStorage.getItem("user_id"), // Adjust to your session handling logic
            q1_answer: q1_answer,
            q2_answer: q2_answer,
            q3_answer: q3_answer
        }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            // If answers are correct, close verify modal and open reset password modal
            closeVerifyUserModal();
            OpenResetPasswordModal();
        } else {
            // Show an error message
            alert("Your answers are incorrect. Please try again.");
        }
    })
    .catch((error) => {
        console.error("Error verifying answers:", error);
        alert("An error occurred. Please try again.");
    });
}

</script>
