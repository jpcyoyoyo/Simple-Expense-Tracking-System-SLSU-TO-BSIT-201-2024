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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['user_id'])) {
        createLog($conn, $admin_user_id, "Failed to get user id. Admin User ID: $admin_user_id", 0);
        echo json_encode(['success' => false, 'message' => 'User ID not provided']);
        exit;
    }
    $user_id = $input['user_id'];

    // Prepare and execute the first query to fetch users
    $stmt = $conn->prepare("SELECT id, created_at, status, description FROM logs WHERE user_id = ?");
    if (!$stmt) {
        createLog($conn, $admin_user_id, "Error preparing statement for user logs. User ID: $user_id, Admin User ID: $admin_user_id: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error]);
        exit();
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $row['month'] = date('F', strtotime($row['created_at'])); // Full month name (e.g., January)
        $row['year'] = date('Y', strtotime($row['created_at']));  // Year (e.g., 2023)
        $logs[] = $row;
    }
    createLog($conn, $admin_user_id, "Fetched user logs for user log table successfully. User ID: $user_id, Admin User ID: $admin_user_id", 1);

    $stmt->close();

    $stmt_dates = $conn->prepare("SELECT DISTINCT DATE_FORMAT(created_at, '%Y') AS year_months FROM logs WHERE user_id = ? ORDER BY id");
    if (!$stmt_dates) {
        createLog($conn, $admin_user_id, "Error preparing statement for years. User ID: $user_id" . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for years: ' . $conn->error]);
        exit();
    }
    $stmt_dates->bind_param("i", $user_id);
    $stmt_dates->execute();
    $result_dates = $stmt_dates->get_result();

    $years = [];
    while ($row = $result_dates->fetch_assoc()) {
        $years[] = $row['year_months'];
    }
    $stmt_dates->close();
    createLog($conn, $admin_user_id, "Fetched distinct years for user logs filters filters successfully. Admin User ID: $admin_user_id", 1);

    // Send JSON response including users and years
    echo json_encode([
        'success' => true,
        'userLogs' => $logs,
        'years' => $years
    ]);

    // Close prepared statements and connection
    $conn->close();

} else {
    createLog($conn, $admin_user_id, "Invalid request method attempted for user logs retrival. User ID: $user_id, Admin User ID: $admin_user_id", 0);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

//