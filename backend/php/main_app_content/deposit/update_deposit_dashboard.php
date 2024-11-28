<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly
include '../../../../backend/php/create_log.php'; // Include the log function

session_start();

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
$username = $_SESSION['username'];

// Get user_id from session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User $username not authenticated']);
    exit;
}

if (!isset($_SESSION['dashboard_id'])) {
    createLog($conn, null, "User $username's dashboard_id not found", 0);
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;;
}

$input = json_decode(file_get_contents('php://input'), true);
$dashboardId = $_SESSION['dashboard_id'];
$depositTotal = $input['deposit_total'];
$depositCount = $input['deposit_count'];
$balance = $input['balance'];

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE dashboard SET deposit_total = ?, deposit_count = ?, balance = ? WHERE id = ?");
if (!$stmt) {
    createLog($conn, $_SESSION['user_id'], "Error preparing update statement for dashboard for $username: " . $conn->error, 0);
    echo json_encode(['success' => false, 'message' => 'Database error: failed to prepare statement']);
    exit;
}

$stmt->bind_param("didi", $depositTotal, $depositCount, $balance, $dashboardId);

if ($stmt->execute()) {
    createLog($conn, $_SESSION['user_id'], "Dashboard updated successfully for $username. Dashboard ID: {$dashboardId}", 1);
    echo json_encode(['success' => true]);
} else {
    createLog($conn, $_SESSION['user_id'], "Failed to update dashboard for $username. Dashboard ID: {$dashboardId}. Error: " . $stmt->error, 0);
    echo json_encode(['success' => false, 'message' => 'Failed to update dashboard']);
}

$stmt->close();
$conn->close();
