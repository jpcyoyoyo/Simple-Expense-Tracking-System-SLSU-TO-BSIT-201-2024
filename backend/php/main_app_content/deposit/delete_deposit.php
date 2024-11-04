<?php
include '../../../../conn/conn.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session to access session variables
session_start();

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['deposit_id'])) {
        echo json_encode(['success' => false, 'message' => 'Deposit ID not provided']);
        exit;
    }

    $deposit_id = $input['deposit_id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM deposit WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $deposit_id, $user_id);

    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No record found or already deleted']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete deposit']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
