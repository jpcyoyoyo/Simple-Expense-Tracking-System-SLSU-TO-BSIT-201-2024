<?php

session_start();

include '../../../../conn/conn.php';
include '../../../../backend/php/create_log.php'; // Include the log function

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$admin_user_id = $_SESSION['user_id'];
if (!$admin_user_id) {
    echo json_encode(['success' => false, 'message' => 'Admin user not authenticated.']);
    exit;
}

$response = ['success' => false, 'message' => '', 'data' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['user_id']) && !empty($input['user_id'])) {
        $user_id = $input['user_id'];

        $stmt = $conn->prepare("SELECT created_at, updated_at, username, fullname, email, profile_pic, is_login FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $response['success'] = true;
                $response['data'] = $row;
            } else {
                $response['message'] = 'User not found';
            }
        } else {
            $response['message'] = "Database error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = "User ID not provided";
    }
} 

$conn->close();
echo json_encode($response);