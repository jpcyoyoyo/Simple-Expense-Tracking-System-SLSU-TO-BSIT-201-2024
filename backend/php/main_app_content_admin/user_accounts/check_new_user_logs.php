<?php
session_start();

include '../../../../conn/conn.php';
include '../../../../backend/php/create_log.php';

$response = [
    'success' => false,
    'message' => '',
    'logs' => []
];

header('Content-Type: application/json');
error_reporting(E_ALL);

$admin_user_id = $_SESSION['user_id'] ?? null;
if (!$admin_user_id) {
    echo json_encode(['success' => false, 'message' => 'Admin user not authenticated.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $user_id = $input['user_id'] ?? null;
    $lastLogTime = $_GET['lastLogTime'] ?? null;

    if (!$user_id || !$lastLogTime) {
        createLog($conn, $admin_user_id, "Invalid request. Missing parameters: User ID or Last Log Time.", 0);
        echo json_encode(['success' => false, 'message' => 'User ID and Last Log Time are required.']);
        exit;
    }
    

    // Validate datetime format for lastLogTime
    if (!strtotime($lastLogTime)) {
        echo json_encode(['success' => false, 'message' => 'Invalid datetime format for Last Log Time.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, created_at, description, status FROM logs WHERE created_at > ? AND user_id = ? ORDER BY created_at ASC");

    if ($stmt) {
        $stmt->bind_param("si", $lastLogTime, $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $logs = $result->fetch_all(MYSQLI_ASSOC);

            $response['success'] = true;
            $response['logs'] = $logs ?: [];
            $response['message'] = empty($logs) ? 'No new logs found.' : '';
        } else {
            $response['message'] = 'Error executing query.';
            createLog($conn, $admin_user_id, "Database error: " . $stmt->error, 0);
        }

        $stmt->close();
    } else {
        $response['message'] = 'Error preparing query.';
        createLog($conn, $admin_user_id, "Database preparation error: " . $conn->error, 0);
    }

    $conn->close();
} else {
    createLog($conn, $admin_user_id, "Invalid request method attempted.", 0);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

echo json_encode($response);

