<?php
include '../../../../conn/conn.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Prepare and execute the first query to fetch users
$stmt = $conn->prepare("SELECT id, created_at, status, description FROM logs ORDER BY id DESC");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error]);
    exit();
}
$stmt->execute();
$result = $stmt->get_result();

$logs = [];
while ($row = $result->fetch_assoc()) {
    $row['month'] = date('F', strtotime($row['created_at'])); // Full month name (e.g., January)
    $row['year'] = date('Y', strtotime($row['created_at']));  // Year (e.g., 2023)
    $logs[] = $row;
}

// Fetch distinct years for filtering deposits=
$user_id = 0; // Replace with actual value or ensure it's passed as a parameter
$stmt_dates = $conn->prepare("SELECT DISTINCT DATE_FORMAT(created_at, '%Y') AS year_months FROM logs ORDER BY id DESC");
if (!$stmt_dates) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for years: ' . $conn->error]);
    exit();
}
$stmt_dates->execute();
$result_dates = $stmt_dates->get_result();

$years = [];
while ($row = $result_dates->fetch_assoc()) {
    $years[] = $row['year_months'];
}

// Send JSON response including users and years
echo json_encode([
    'success' => true,
    'logs' => $logs,
    'years' => $years
]);

// Close prepared statements and connection
$stmt->close();
$stmt_dates->close();
$conn->close();