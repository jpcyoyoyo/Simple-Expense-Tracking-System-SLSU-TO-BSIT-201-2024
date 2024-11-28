<?php
include '../../../../conn/conn.php';
include '../../../../backend/php/create_log.php'; // Include createLog() function

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session to access session variables
session_start();

$username = $_SESSION['username'];

// Get user_id from session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User $username not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['deposit_id'])) {
        createLog($conn, $user_id, "Failed to delete deposit for $username: Deposit ID not provided", 0);
        echo json_encode(['success' => false, 'message' => 'Deposit ID not provided']);
        exit;
    }

    $deposit_id = $input['deposit_id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM deposit WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        createLog($conn, $user_id, "Failed to prepare delete statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare delete statement']);
        exit;
    }

    $stmt->bind_param("ii", $deposit_id, $user_id);

    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            createLog($conn, $user_id, "Deposit deleted successfully for $username. Deposit ID {$deposit_id}", 1);
            echo json_encode(['success' => true]);
        } else {
            createLog($conn, $user_id, "Failed to delete deposit for $username. Deposit ID {$deposit_id}: Record not found or already deleted", 0);
            echo json_encode(['success' => false, 'message' => 'No record found or already deleted']);
        }
    } else {
        createLog($conn, $user_id, "Error executing delete statement for $username. Deposit ID {$deposit_id}: " . $stmt->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to delete deposit']);
    }

    $stmt->close();
    $conn->close();
} else {
    createLog($conn, $user_id, "Invalid request method attempted for deposit deletion for $username", 0);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
