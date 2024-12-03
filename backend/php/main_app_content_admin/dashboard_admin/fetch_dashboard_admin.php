<?php
include '../../../../conn/conn.php'; // Include your database connection

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the response array
$response = [
    'accountTotal' => 0,
    'accountActive' => 0,
    'totalLogs' => 0,
];

try {
    // Query to count users where is_admin = 0
    $stmt_users = $conn->prepare("SELECT COUNT(*) as total_users FROM user_accounts WHERE is_admin = 0");
    $stmt_users->execute();
    $result_users = $stmt_users->get_result();
    if ($row = $result_users->fetch_assoc()) {
        $response['accountTotal'] = $row['total_users'];
    }
    $stmt_users->close();

$stmt_online = $conn -> prepare("SELECT COUNT(*) as online_users FROM user_accounts WHERE is login = 1 AND is_admin = 0*");
$stmt_online -> execute();
$result_online = $stmt_online -> get_result();
if ($row = $result_online -> fetch_assoc()) {
    $response ['accountActive'] = $row['online_users'];
}
$stmt_online -> close();

$stmt_logs = $conn -> prepare("SELECT COUNT(*) as total_logs FROM logs");
$stmt_logs -> execute();
$result_logs = $stmt_logs -> get_result();
if ($row = $result_logs -> get_result()) {
    $response['totalLogs'] = $row['total_logs'];
}
$stmt_logs -> close();

echo json_encode(['success' => true, 'data'=> $response]);
} catch (Exception $e) {
    echo json_encode (['success'=> false, 'error'=> $e->getMessage()]);
}
$conn -> close();
?>