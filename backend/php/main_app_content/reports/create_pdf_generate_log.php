<?php
    include '../../../../conn/conn.php';
    include '../../../../backend/php/create_log.php'; // Include the log function

    header('Content-Type: application/json');

    session_start();

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['description']) || !isset($data['status'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid payload']);
        exit;
    }

    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
    $username = $_SESSION['username'];

    // Get user_id from session
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User $username not authenticated']);
        exit;
    }

    $description = "{$data['description']}. For user {$_SESSION['username']}.";
    $status = $data['status'];

    // Call the createLog function
    createLog($conn, $user_id, $description, $status);

    echo json_encode(['success' => true]);
