
document.getElementById('theme-selector').addEventListener('change', function () {
    const theme = this.value;

    // Remove existing theme classes
    document.body.classList.remove('dark-theme', 'light-theme');

    // Apply the selected theme
    if (theme === 'dark') {
        document.body.classList.add('dark-theme');
    } else if (theme === 'light') {
        document.body.classList.add('light-theme');
    }

    // Update theme in the backend
    fetch('backend/php/settings/update_theme.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ theme: theme }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                console.log("Theme updated successfully!");
                // Optionally notify the user
                // alert("Theme updated successfully!");
            } else {
                console.error("Error updating theme:", data.message);
                // Optionally notify the user
                // alert("Failed to update theme. Please try again.");
            }
        })
        .catch((error) => {
            console.error("Fetch error:", error);
            // Optionally notify the user
            // alert("An error occurred while updating the theme.");
        });
});


function OpenVerifyUserModal() {
    document.getElementById("verifyuser-modal").style.display = "block";
}

function closeVerifyUserModal() {
    document.getElementById("verifyuser-modal").style.display = "none";
    const form = document.getElementById('verifyuser-form');
    form.reset();
}

function OpenResetPasswordModal() {
    document.getElementById("resetpassword-modal").style.display = "block";
}

function closeResetPasswordModal() {
    document.getElementById("resetpassword-modal").style.display = "none";
    const form = document.getElementById('reset-password-form');
    form.reset();
}

function changePassword() {
    // Fetch security questions from the server
    fetch('backend/php/settings/fetch_questions.php', {
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

    const form = document.getElementById('verifyuser-form');

    // Gather form data
    const q1_answer = document.querySelector("input[name='q1_answer']").value.trim();
    const q2_answer = document.querySelector("input[name='q2_answer']").value.trim();
    const q3_answer = document.querySelector("input[name='q3_answer']").value.trim();

    // Send the answers to the backend for verification
    fetch('backend/php/settings/verify_answers.php', {
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
            form.reset();
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

function resetPassword(event) {
    event.preventDefault(); // Prevent form submission

    const form = document.getElementById('reset-password-form');

    const password = document.getElementById('reset-user-password').value.trim();
    const confirmPassword = document.getElementById('reset-user-confirm-password').value.trim();

    // Validate that passwords match
    if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return;
    }

    // Prepare data to send to the server
    const formData = {
        password: password,
        confirm_password: confirmPassword
    };

    // Send a POST request to the server
    fetch('backend/php/settings/reset_password.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Password successfully reset!");
            closeResetPasswordModal(); // Close the modal
            form.reset();
        } else {
            alert(data.message || "An error occurred while resetting the password.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An unexpected error occurred. Please try again later.");
    });
}

function deleteAccount() {
    if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
        fetch('backend/php/main_app_content/settings/delete_account.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Your account has been successfully deleted.");
                window.location.href = "thankyou.php"; // Redirect to logout or landing page
            } else {
                alert(data.message || "An error occurred while deleting your account.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An unexpected error occurred. Please try again later.");
        });
    }
}
