<?php
include '../../conn/conn.php'; // Adjust the path accordingly

header('Content-Type: application/json');

if (!isset($_SESSION['dashboard_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$dashboard_id = $_SESSION['dashboard_id'];

$query = "SELECT balance, deposit_total, expense_total, expense_count, deposit_count 
          FROM dashboard WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $dashboard_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $dashboard_data = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $dashboard_data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found']);
}

$stmt->close();
$conn->close();

