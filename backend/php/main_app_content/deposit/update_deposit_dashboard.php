<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly

session_start();

if (!isset($_SESSION['dashboard_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$dashboardId = $_SESSION['dashboard_id'];
$depositTotal = $input['deposit_total'];
$depositCount = $input['deposit_count'];
$balance = $input['balance'];

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE dashboard SET deposit_total = ?, deposit_count = ?, balance = ? WHERE id = ?");
$stmt->bind_param("didi", $depositTotal, $depositCount, $balance, $dashboardId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update dashboard']);
}

$stmt->close();
$conn->close();
