<?php
include '../../../../conn/conn.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$is_admin = 0; // Define $is_admin to fetch non-admin users

try {
    // Prepare and execute the first query to fetch users
    $stmt = $conn->prepare("SELECT id, created_at, updated_at, username, fullname, email, profile_pic, is_login FROM user_accounts WHERE is_admin = ?");
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("i", $is_admin);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $row['month'] = date('F', strtotime($row['created_at'])); // Full month name (e.g., January)
        $row['year'] = date('Y', strtotime($row['created_at']));  // Year (e.g., 2023)
        $users[] = $row;
    }

    // Prepare and execute the second query to fetch distinct years
    $stmt_dates = $conn->prepare("SELECT DISTINCT DATE_FORMAT(created_at, '%Y') AS year_months FROM user_accounts ORDER BY id");
    if (!$stmt_dates) {
        throw new Exception("Failed to prepare statement for years: " . $conn->error);
    }
    $stmt_dates->execute();
    $result_dates = $stmt_dates->get_result();

    $years = [];
    while ($row = $result_dates->fetch_assoc()) {
        $years[] = $row['year_months'];
    }

    // Send JSON response with users and years
    echo json_encode([
        'success' => true,
        'users' => $users,
        'years' => $years,
    ]);

} catch (Exception $e) {
    // Handle exceptions and send error response
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
} finally {
    // Close statements and connection
    if (isset($stmt)) $stmt->close();
    if (isset($stmt_dates)) $stmt_dates->close();
    $conn->close();
}
