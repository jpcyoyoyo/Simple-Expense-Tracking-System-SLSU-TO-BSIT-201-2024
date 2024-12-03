<?php
include '../../../../conn/conn.php';
include '../../../../backend/php/create_log.php'; // Include the log function

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Validate user authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Retrieve session data
$admin_user_id = $_SESSION['user_id'];
$user_id = mysqli_real_escape_string($conn, $_POST['user_id'] ?? '');

// Validate and sanitize input
$fullname = mysqli_real_escape_string($conn, $_POST['fullname'] ?? '');
$new_username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$profile_pic = $_FILES['profilePic'] ?? null;
$previousProfilePic = mysqli_real_escape_string($conn, $_POST['previousProfilePic'] ?? '');

// Check if username or email already exists in the database
$sqlCheck = "SELECT id FROM user_accounts WHERE (username = ? OR email = ?) AND id != ?";
$stmtCheck = $conn->prepare($sqlCheck);

if (!$stmtCheck) {
    createLog($conn, $admin_user_id, "SQL preparation failed for uniqueness check for updating user account User ID: $user_id, Admin ID: $admin_user_id:" . $conn->error, 0);
    echo json_encode(['success' => false, 'message' => 'Database error.']);
    exit();
}

$stmtCheck->bind_param("ssi", $new_username, $email, $user_id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username or email already in use.']);
    $stmtCheck->close();
    $conn->close();
    exit();
}

$stmtCheck->close();

// Initialize default values
$uploadDir = '../../../../profile_pic/';
$defaultImage = 'profile_default.svg';
$newProfilePicPath = $previousProfilePic;

// Handle profile picture upload
if ($profile_pic && $profile_pic['error'] === UPLOAD_ERR_OK) {
    $newFileName = uniqid() . '_' . basename($profile_pic['name']);
    $fileDestination = $uploadDir . $newFileName;

    if (move_uploaded_file($profile_pic['tmp_name'], $fileDestination)) {
        // Delete previous profile picture if not default
        if ($previousProfilePic !== $defaultImage && file_exists($uploadDir . $previousProfilePic)) {
            unlink($uploadDir . $previousProfilePic);
        }
        $newProfilePicPath = "profile_pic/$newFileName"; // Update for database
    } else {
        createLog($conn, $admin_user_id, "Profile picture upload failed for user {$username} User ID: $user_id. Admin ID: $admin_user_id.", 0);
        echo json_encode(['success' => false, 'message' => 'Failed to upload profile picture.']);
        exit();
    }
}

// Prepare SQL query
$sql = "UPDATE user_accounts 
        SET fullname = ?, username = ?, email = ?, profile_pic = ? 
        WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    createLog($conn, $admin_user_id, "SQL preparation failed for updating profile of user {$username} User ID: $user_id,: Admin ID: $admin_user_id. " . $conn->error, 0);
    echo json_encode(['success' => false, 'message' => 'Database error.']);
    exit();
}

$stmt->bind_param("ssssi", $fullname, $new_username, $email, $newProfilePicPath, $user_id);

if ($stmt->execute()) {
    // Update session data

    if ($new_username === $username) {
        createLog($conn, $admin_user_id, "Profile updated successfully to user {$username} User ID: $user_id by Admin ID: $admin_user_id.", 1);
    } else {
        createLog($conn, $admin_user_id, "Username updated from {$username} to {$new_username} User ID: $user_id,. Profile updated successfully by Admin ID: $admin_user_id.", 1);
        $_SESSION['username'] = $new_username;
    }

    echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
} else {
    createLog($conn, $admin_user_id, "Failed to update profile for user {$username} User ID: $user_id,: Admin ID: $admin_user_id." . $stmt->error, 0);
    echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
}

// Cleanup
$stmt->close();
$conn->close();
//