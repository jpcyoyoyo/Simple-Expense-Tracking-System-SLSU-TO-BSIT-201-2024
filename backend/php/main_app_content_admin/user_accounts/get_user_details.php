<?php
session_start();
include '../../../../conn/conn.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Response structure
$response = ['success' => false, 'message' => '', 'data' => []];

// Validate session
$admin_user_id = $_SESSION['user_id'] ?? null;
if (!$admin_user_id) {
    echo json_encode(['success' => false, 'message' => 'Admin user not authenticated.']);
    exit;
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Check for user_id in POST data
    if (isset($input['user_id']) && !empty($input['user_id'])) {
        $user_id = $input['user_id'];

        // Prepare the SQL query
        $stmt = $conn->prepare("SELECT fullname, username, email, profile_pic, created_at, updated_at, is_login FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $response['success'] = true;
                $response['data'] = $row;
            } else {
                $response['message'] = "User not found";
            }
        } else {
            $response['message'] = "Database error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = "User ID not provided";
    }
} else {
    $response['message'] = "Invalid request method. Use POST.";
}

$conn->close();
echo json_encode($response);
