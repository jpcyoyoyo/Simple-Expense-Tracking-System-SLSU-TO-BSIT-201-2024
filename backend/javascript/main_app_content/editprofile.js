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

