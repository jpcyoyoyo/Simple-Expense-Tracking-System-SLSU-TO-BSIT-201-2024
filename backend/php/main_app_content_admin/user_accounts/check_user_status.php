<?php
include '../../../../conn/conn.php';
include '../../../../backend/php/create_log.php'; // Include the log function


// Query for fetching user status and username
$sql = "SELECT id, fullname, username, email, profile_pic, created_at, updated_at, is_login FROM user_accounts WHERE is_admin = 0";
$result = $conn->query($sql);

$response = ['success' => false, 'users' => []];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response['users'][] = $row;
    }
    $response['success'] = true;
} else {
    $response['message'] = "No users found.";
}

// Send JSON response
echo json_encode($response);

$conn->close();

//