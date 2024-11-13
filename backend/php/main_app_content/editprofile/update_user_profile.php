<?php
session_start();
require '../../../../conn/conn.php'; // Ensure this includes the database connection

// Get user ID from session
$userId = $_SESSION['user_id'];
$previousProfilePic = $_SESSION['profile_pic'];

// Validate form input
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$email = $_POST['email'];
$profilePic = $_FILES['profilePic'] ?? null;

// Prepare file upload directory
$uploadDir = '../../../../profile_pic/';
$defaultImage = 'profile_default.svg';
$newProfilePicPath = $previousProfilePic;

// Handle profile picture upload if a new one is provided
if ($profilePic && $profilePic['error'] === UPLOAD_ERR_OK) {
    $newFileName = uniqid() . '_' . basename($profilePic['name']);
    $newProfilePicPath = $uploadDir . $newFileName;

    // Move the uploaded file to the profile_pic directory
    if (move_uploaded_file($profilePic['tmp_name'], $newProfilePicPath)) {
        // Delete the previous profile picture if it’s not the default image
        if ($previousProfilePic !== $defaultImage && file_exists($uploadDir . $previousProfilePic)) {
            unlink($uploadDir . $previousProfilePic);
        }
    }

    $newProfilePicPath = "profile_pic/ $newFileName";
}

// Update database with the new data
$sql = "UPDATE user_accounts 
        SET fullname = ?, username = ?, email = ?, profile_pic = ? 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $fullname, $username, $email, $newProfilePicPath, $userId);

$response = [
    'success' => false,
    'message' => 'Failed to update profile.'
];

if ($stmt->execute()) {
    // Update session with new profile data
    $_SESSION['fullname'] = $fullname;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['profile_pic'] = $newProfilePicPath;

    $response['success'] = true;
    $response['message'] = 'Profile updated successfully.';
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

