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
    'depositRecords' => 0,
    'expenseRecords' => 0,
    'categoryRecords' => 0,
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

    // Query to count users where is_login = 1
    $stmt_online = $conn->prepare("SELECT COUNT(*) as online_users FROM user_accounts WHERE is_login = 1 AND is_admin = 0");
    $stmt_online->execute();
    $result_online = $stmt_online->get_result();
    if ($row = $result_online->fetch_assoc()) {
        $response['accountActive'] = $row['online_users'];
    }
    $stmt_online->close();

    // Query to count rows in the log table
    $stmt_logs = $conn->prepare("SELECT COUNT(*) as total_logs FROM logs");
    $stmt_logs->execute();
    $result_logs = $stmt_logs->get_result();
    if ($row = $result_logs->fetch_assoc()) {
        $response['totalLogs'] = $row['total_logs'];
    }
    $stmt_logs->close();

    // Query to count deposit records
    $stmt_deposit = $conn->prepare("SELECT COUNT(*) as total_deposit FROM deposit");
    $stmt_deposit->execute();
    $result_deposit = $stmt_deposit->get_result();
    if ($row = $result_deposit->fetch_assoc()) {
        $response['depositRecords'] = $row['total_deposit'];
    }
    $stmt_deposit->close();

    // Query to count expense records
    $stmt_expense = $conn->prepare("SELECT COUNT(*) as total_expense FROM expense");
    $stmt_expense->execute();
    $result_expense = $stmt_expense->get_result();
    if ($row = $result_expense->fetch_assoc()) {
        $response['expenseRecords'] = $row['total_expense'];
    }
    $stmt_expense->close();

    // Query to count category records
    $stmt_category = $conn->prepare("SELECT COUNT(*) as total_category FROM category");
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    if ($row = $result_category->fetch_assoc()) {
        $response['categoryRecords'] = $row['total_category'];
    }
    $stmt_category->close();

    // Send the response as JSON
    echo json_encode(['success' => true, 'data' => $response]);
} catch (Exception $e) {
    // Handle any errors
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
