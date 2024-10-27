<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly

session_start();

if (!isset($_SESSION['dashboard_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$dashboard_id = $_SESSION['dashboard_id'];

// Fetch expense_total and dashboard_id from the dashboard table
$stmt = $conn->prepare("SELECT deposit_total FROM dashboard WHERE id = ?");
$stmt->bind_param("i", $dashboard_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $dashboard = $result->fetch_assoc();
    echo json_encode(['success' => true, 'deposit_total' => $dashboard['deposit_total']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Dashboard not found']);
}

$stmt->close();
$conn->close();
