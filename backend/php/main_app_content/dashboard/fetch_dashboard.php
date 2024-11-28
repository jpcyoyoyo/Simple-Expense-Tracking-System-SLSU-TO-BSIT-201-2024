<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly
include '../../../../backend/php/create_log.php'; // Include the log function

session_start();

header('Content-Type: application/json');

$username = $_SESSION['username'];

if (!isset($_SESSION['dashboard_id'])) {
    // Log the error: User not authenticated
    createLog($conn, null, "User not authenticated", 0); // Log failed attempt with null user_id

    echo json_encode(['success' => false, 'message' => 'User {$username} not authenticated']);
    exit;
}

$dashboard_id = $_SESSION['dashboard_id'];
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$query = "SELECT balance, deposit_total, expense_total, expense_count, deposit_count 
          FROM dashboard WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $dashboard_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $dashboard_data = $result->fetch_assoc();
    
    // Log the success: Dashboard data fetched successfully
    createLog($conn, $user_id, "Dashboard data fetched for {$username}. Dashboard ID: {$dashboard_id}", 1); // Successful log

    echo json_encode(['success' => true, 'data' => $dashboard_data]);
} else {
    // Log the error: No data found for the dashboard
    createLog($conn, $user_id, "No data found for {$username}. Dashboard ID: {$dashboard_id}", 0); // Log failure

    echo json_encode(['success' => false, 'message' => 'No data found']);
}

$stmt->close();
$conn->close();
