<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly

session_start();

if (!isset($_SESSION['dashboard_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$dashboardId = $_SESSION['dashboard_id'];
$expenseTotal = $input['expense_total'];
$expenseCount = $input['expense_count'];
$balance = $input['balance'];

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE dashboard SET expense_total = ?, expense_count = ?, balance = ? WHERE id = ?");
$stmt->bind_param("didi", $expenseTotal, $expenseCount, $balance, $dashboardId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update dashboard']);
}

$stmt->close();
$conn->close();
