<?php
session_start();

include '../../../../conn/conn.php';
include '../../../../backend/php/create_log.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$admin_user_id = $_SESSION['user_id'];
if (!$admin_user_id) {
    echo json_encode(['success' => false, 'message' => 'Admin user not authenticated.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Input sanitization
    $fullname = mysqli_real_escape_string($conn, trim($_POST['fullname']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $q1 = mysqli_real_escape_string($conn, trim($_POST['q1']));
    $q1_answer = mysqli_real_escape_string($conn, trim($_POST['q1_answer']));
    $q2 = mysqli_real_escape_string($conn, trim($_POST['q2']));
    $q2_answer = mysqli_real_escape_string($conn, trim($_POST['q2_answer']));
    $q3 = mysqli_real_escape_string($conn, trim($_POST['q3']));
    $q3_answer = mysqli_real_escape_string($conn, trim($_POST['q3_answer']));
    $is_admin = 0;

    $uploadDir = '../../../../profile_pic/';
    $defaultProfilePic = 'profile_pic/profile_default.svg'; // Default image
    $profile_pic = $_FILES['profilePic'] ?? null;
    $newProfilePicPath = $defaultProfilePic;

    // Error handling
    $error_message = "";

    // Check for duplicate username/email
    $check_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user_accounts WHERE username = ? OR email = ?");
    if ($check_stmt) {
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $error_message = "Username or email already exists.";
            createLog($conn, $admin_user_id, "Duplicate entry: Username {$username} or Email {$email}.", 0);
        } elseif ($password !== $confirm_password) {
            $error_message = "Passwords do not match.";
            createLog($conn, $admin_user_id, "Password mismatch for Username {$username}.", 0);
        } else {
            // Handle profile picture upload
            if ($profile_pic && $profile_pic['error'] === UPLOAD_ERR_OK) {
                $newFileName = uniqid() . '_' . basename($profile_pic['name']);
                $fileDestination = $uploadDir . $newFileName;

                if (move_uploaded_file($profile_pic['tmp_name'], $fileDestination)) {
                    $newProfilePicPath = "profile_pic/$newFileName";
                } else {
                    createLog($conn, $admin_user_id, "Failed to upload profile picture for new user {$username}.", 0);
                    echo json_encode(['success' => false, 'message' => 'Failed to upload profile picture.']);
                    exit;
                }
            }

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $conn->prepare("INSERT INTO user_accounts (fullname, username, email, password, profile_pic, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $fullname, $username, $email, $hashed_password, $newProfilePicPath, $is_admin);

            if ($stmt->execute()) {
                $user_id = $conn->insert_id;
                createLog($conn, $admin_user_id, "User {$username} registered successfully.", 1);

                // Insert security questions
                $q_stmt = $conn->prepare("INSERT INTO security_q (user_id, q1, q1_answer, q2, q2_answer, q3, q3_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if (!$q_stmt) {
                    createLog($conn, $admin_user_id, "Error preparing security question statement: " . $conn->error, 0);
                    exit("Error preparing statement.");
                }
                
                $q_stmt->bind_param("issssss", $user_id, $q1, $q1_answer, $q2, $q2_answer, $q3, $q3_answer);
                if (!$q_stmt->execute()) {
                    createLog($conn, $admin_user_id, "Error inserting security questions: " . $insert_stmt->error, 0);
                    $q_stmt->close(); // Close the statement before exiting
                    exit("Error inserting security questions.");
                }

                $question_id = $conn->insert_id;
                createLog($conn, $admin_user_id, "Security questions for user {$username} inserted successfully. Question ID: {$question_id}", 1);
                $q_stmt->close();

                updateUserAccount($conn, "question_id", $question_id, $user_id, $username, $admin_user_id);

                // Insert default settings and dashboard
                $settings_id = insertDefaultSettings($conn, $user_id, $username, $admin_user_id);
                $dashboard_id = insertDefaultDashboard($conn, $user_id, $username, $admin_user_id);

                // Update user account
                updateUserAccount($conn, "settings_id", $settings_id, $user_id, $username, $admin_user_id);
                updateUserAccount($conn, "dashboard_id", $dashboard_id, $user_id, $username, $admin_user_id);

                echo json_encode(['success' => true, 'message' => 'User created successfully.']);
                createLog($conn, $user_id, "User {$username} account's creation successfully finish by Admin ID: $admin_user_id.", 1);
                exit;
            } else {
                $error_message = "Error creating user.";
                createLog($conn, $admin_user_id, "Error creating user: {$stmt->error}.", 0);
            }
            $stmt->close();
        }
    } else {
        $error_message = "Error checking existing username/email.";
        createLog($conn, $admin_user_id, "Error preparing query: {$conn->error}.", 0);
    }

    echo json_encode(['success' => false, 'message' => $error_message]);
    $conn->close();
    exit;
}

/**
 * Update a specific column in the user_accounts table.
 */
function updateUserAccount($conn, $column, $value, $user_id, $username, $admin_user_id) {
    $allowed_columns = ['question_id', 'settings_id', 'dashboard_id', 'is_login', 'is_admin'];
    if (!in_array($column, $allowed_columns, true)) {
        createLog($conn, $admin_user_id, "Attempted to update an invalid column: $column", 0);
        exit("Invalid column specified.");
    }

    $update_sql = "UPDATE user_accounts SET $column = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if (!$update_stmt) {
        createLog($conn, $admin_user_id, "Error preparing update statement for $column: " . $conn->error, 0);
        exit("Error preparing update statement.");
    }

    $update_stmt->bind_param("ii", $value, $user_id); // Ensure proper data types
    if (!$update_stmt->execute()) {
        createLog($conn, $admin_user_id, "Error updating $column for user {$username}: " . $update_stmt->error, 0);
        exit("Error updating $column.");
    }

    $update_stmt->store_result();

    createLog($conn, $admin_user_id, "Successfully updated $column with value $value for user {$username}.", 1);
    $update_stmt->close();
}


/**
 * Insert default settings and return the ID.
 */
function insertDefaultSettings($conn, $user_id, $username, $admin_user_id)
{
    $insert_sql = "INSERT INTO settings (user_id, theme) VALUES (?, 'default')";
    $stmt = $conn->prepare($insert_sql);

    if (!$stmt) {
        createLog($conn, $admin_user_id, "Error preparing settings insert statement: " . $conn->error, 0);
        exit("Error preparing settings statement.");
    }

    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        createLog($conn, $admin_user_id, "Error inserting default settings: " . $stmt->error, 0);
        exit("Error inserting settings.");
    }

    $stmt->store_result();

    $settings_id = $conn->insert_id;
    $stmt->close();

    createLog($conn, $admin_user_id, "Default settings for {$username} inserted successfully. Setting ID: {$settings_id}", 1);

    return $settings_id;
}

/**
 * Insert default dashboard values and return the ID.
 */
function insertDefaultDashboard($conn, $user_id, $username, $admin_user_id)
{
    $insert_sql = "INSERT INTO dashboard (user_id, balance, expense_total, deposit_total, expense_count, deposit_count) VALUES ($user_id, 0.00, 0.00, 0.00, 0, 0)";
    $stmt = $conn->prepare($insert_sql);

    if (!$stmt) {
        createLog($conn, $admin_user_id, "Error preparing dashboard insert statement: " . $conn->error, 0);
        exit("Error preparing dashboard statement.");
    }

    if (!$stmt->execute()) {
        createLog($conn, $admin_user_id, "Error inserting default dashboard: " . $stmt->error, 0);
        exit("Error inserting dashboard.");
    }

    $stmt->store_result();

    $dashboard_id = $conn->insert_id;
    $stmt->close();

    createLog($conn, $admin_user_id, "Default dashboard for user {$username} inserted successfully. Dashboard ID: {$dashboard_id}", 1);

    return $dashboard_id;
}