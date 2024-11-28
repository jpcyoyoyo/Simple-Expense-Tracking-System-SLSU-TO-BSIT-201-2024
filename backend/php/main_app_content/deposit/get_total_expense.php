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
    createLog($conn, $user_id, "User $username's dashboard_id not found", 0);
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$dashboard_id = $_SESSION['dashboard_id'];

// Fetch `expense_total` from the `dashboard` table
$stmt = $conn->prepare("SELECT expense_total FROM dashboard WHERE id = ?");
if (!$stmt) {
    createLog($conn, $user_id, "Error preparing statement for $username: " . $conn->error, 0);
    echo json_encode(['success' => false, 'message' => 'Failed preparing statement']);
    exit();
}

$stmt->bind_param("i", $dashboard_id);
$stmt->execute();

// Store the result to avoid "Commands out of sync" error
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($expense_total);
    $stmt->fetch();

    createLog($conn, $user_id, "Expense total retrieved successfully for $username. Dashboard ID: $dashboard_id", 1);
    echo json_encode(['success' => true, 'expense_total' => $expense_total]);
} else {
    createLog($conn, $user_id, "Dashboard not found for $username. Dashboard ID: $dashboard_id", 0);
    echo json_encode(['success' => false, 'message' => 'Dashboard not found']);
}

$stmt->close(); 
$conn->close();
