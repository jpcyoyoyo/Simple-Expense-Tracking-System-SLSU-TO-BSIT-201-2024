<?php
include '../../../../conn/conn.php';

header('Contect-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$is_admin = 0;

try {
    $stmt = $conn->prepare("SELECT id, created_at, updated_at, username, fullname, email, profile_pic, is_login FROM user_accounts WHERE is_admin = ?");
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $is_admin);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $row['month'] = date('F', strtotime($row["created_at"]));
        $row['year'] = date('Y', strtotime($row["created_at"]));
        $users[] = $row;
    }

    $stmt_dates = $conn->prepare("SELECT DISTINCT DATE_FORMAT(created_at, '%Y') as year_months FROM user_accounts WHERE is_admin = ? ORDER BY id");
    if (!$stmt_dates) {
        throw new Exception("Failed to prepare statement for years: " . $conn->error);
    }

    $stmt_dates->bind_param("i", $is_admin);
    $stmt_dates->execute();
    $result_dates = $stmt_dates->get_result();

    $years = [];
    while ($row = $result_dates->fetch_assoc()) {
        $years[] = $row['year_months'];
    }

    echo json_encode([
        'success' => true,
        'users' => $users,
        'years' => $years,
    ]);

} catch (Exception $e) {
    echo json_encode ([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($stmt_dates)) $stmt_dates->close();
    $conn->close();
}
