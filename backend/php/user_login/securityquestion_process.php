<?php
session_start(); // Start a session to store the user_id or user ID from the previous page

// Ensure the user is coming from the signup page
if (!isset($_SESSION['user_id'])) {
    header("Location: signup.php"); // Redirect if no session
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize inputs
    $q1 = mysqli_real_escape_string($conn, trim($_POST['q1']));
    $q1_answer = mysqli_real_escape_string($conn, trim($_POST['q1_answer']));
    $q2 = mysqli_real_escape_string($conn, trim($_POST['q2']));
    $q2_answer = mysqli_real_escape_string($conn, trim($_POST['q2_answer']));
    $q3 = mysqli_real_escape_string($conn, trim($_POST['q3']));
    $q3_answer = mysqli_real_escape_string($conn, trim($_POST['q3_answer']));
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Insert security questions into the `security_q` table
    $insert_sql = "INSERT INTO security_q (user_id, q1, q1_answer, q2, q2_answer, q3, q3_answer) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);

    if (!$insert_stmt) {
        createLog($conn, $user_id, "Error preparing security question statement: " . $conn->error, 0);
        exit("Error preparing statement.");
    }

    $insert_stmt->bind_param("issssss", $user_id, $q1, $q1_answer, $q2, $q2_answer, $q3, $q3_answer);
    if (!$insert_stmt->execute()) {
        createLog($conn, $user_id, "Error inserting security questions: " . $insert_stmt->error, 0);
        $insert_stmt->close(); // Close the statement before exiting
        exit("Error inserting security questions.");
    }

    // Get the question ID and log success
    $question_id = $conn->insert_id;
    createLog($conn, $user_id, "Security questions for user {$username} inserted successfully. Question ID: {$question_id}", 1);

    $insert_stmt->close();

    // Update user account with the question ID
    updateUserAccount($conn, "question_id", $question_id, $user_id, $username);

    // Insert default settings
    $settings_id = insertDefaultSettings($conn, $user_id, $username);

    // Update user account with the settings ID
    updateUserAccount($conn, "settings_id", $settings_id, $user_id, $username);

    // Insert default dashboard values
    $dashboard_id = insertDefaultDashboard($conn, $user_id, $username);

    // Update user account with the dashboard ID
    updateUserAccount($conn, "dashboard_id", $dashboard_id, $user_id, $username);

    // Store session variables and fetch additional user info
    fetchAndStoreUserInfo($conn, $user_id, $username);

    // Redirect to the dashboard
    header("Location: dashboard.php");
    exit();
}

// Function definitions remain unchanged, with fixes applied for safety

$conn->close(); // Close the database connection at the end

/**
 * Update a specific column in the user_accounts table.
 */
function updateUserAccount($conn, $column, $value, $user_id, $username) {
    $allowed_columns = ['question_id', 'settings_id', 'dashboard_id', 'is_login', 'is_admin'];
    if (!in_array($column, $allowed_columns, true)) {
        createLog($conn, $user_id, "Attempted to update an invalid column: $column", 0);
        exit("Invalid column specified.");
    }

    $update_sql = "UPDATE user_accounts SET $column = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if (!$update_stmt) {
        createLog($conn, $user_id, "Error preparing update statement for $column: " . $conn->error, 0);
        exit("Error preparing update statement.");
    }

    $update_stmt->bind_param("ii", $value, $user_id); // Ensure proper data types
    if (!$update_stmt->execute()) {
        createLog($conn, $user_id, "Error updating $column for user {$username}: " . $update_stmt->error, 0);
        exit("Error updating $column.");
    }

    $update_stmt->store_result();

    createLog($conn, $user_id, "Successfully updated $column with value $value for user {$username}.", 1);
    $update_stmt->close();
}


/**
 * Insert default settings and return the ID.
 */
function insertDefaultSettings($conn, $user_id, $username)
{
    $insert_sql = "INSERT INTO settings (user_id, theme) VALUES (?, 'default')";
    $stmt = $conn->prepare($insert_sql);

    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing settings insert statement: " . $conn->error, 0);
        exit("Error preparing settings statement.");
    }

    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        createLog($conn, $user_id, "Error inserting default settings: " . $stmt->error, 0);
        exit("Error inserting settings.");
    }

    $stmt->store_result();

    $settings_id = $conn->insert_id;
    $stmt->close();

    $_SESSION['theme'] = 'default';
    createLog($conn, $user_id, "Default settings for {$username} inserted successfully. Setting ID: {$settings_id}", 1);

    return $settings_id;
}

/**
 * Insert default dashboard values and return the ID.
 */
function insertDefaultDashboard($conn, $user_id, $username)
{
    $insert_sql = "INSERT INTO dashboard (user_id, balance, expense_total, deposit_total, expense_count, deposit_count) VALUES ($user_id, 0.00, 0.00, 0.00, 0, 0)";
    $stmt = $conn->prepare($insert_sql);

    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing dashboard insert statement: " . $conn->error, 0);
        exit("Error preparing dashboard statement.");
    }

    if (!$stmt->execute()) {
        createLog($conn, $user_id, "Error inserting default dashboard: " . $stmt->error, 0);
        exit("Error inserting dashboard.");
    }

    $stmt->store_result();

    $dashboard_id = $conn->insert_id;
    $stmt->close();

    createLog($conn, $user_id, "Default dashboard for user {$username} inserted successfully. Dashboard ID: {$dashboard_id}", 1);

    return $dashboard_id;
}

/**
 * Fetch user information and store it in the session.
 */
function fetchAndStoreUserInfo($conn, $user_id, $username) {
    $fetch_sql = "SELECT fullname, email, id, dashboard_id, settings_id, question_id FROM user_accounts WHERE id = ?";
    $fetch_stmt = $conn->prepare($fetch_sql);

    if (!$fetch_stmt) {
        createLog($conn, $user_id, "Error preparing fetch statement: " . $conn->error, 0);
        exit("Error preparing fetch statement.");
    }

    $fetch_stmt->bind_param("i", $user_id); // Corrected type
    if (!$fetch_stmt->execute()) {
        createLog($conn, $user_id, "Error executing fetch statement: " . $fetch_stmt->error, 0);
        $fetch_stmt->close(); // Ensure the statement is closed
        exit("Error fetching user info.");
    }

    $fullname = $email = $id = $dashboard_id = $settings_id = $question_id = null;

    $fetch_stmt->store_result(); // Explicitly store result
    $fetch_stmt->bind_result($fullname, $email, $id, $dashboard_id, $settings_id, $question_id);

    if ($fetch_stmt->fetch()) {
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['dashboard_id'] = $dashboard_id;
        $_SESSION['settings_id'] = $settings_id;
        $_SESSION['question_id'] = $question_id;

        createLog($conn, $user_id, "User {$username} info fetched successfully.", 1);
    } else {
        createLog($conn, $user_id, "Error: User {$username} not found.", 0);
        exit("Error: User not found.");
    }

    $fetch_stmt->close();
}


