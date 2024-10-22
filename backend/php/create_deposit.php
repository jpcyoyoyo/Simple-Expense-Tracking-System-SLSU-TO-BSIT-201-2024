<?php
include '../../conn/conn.php'; // Adjust the path accordingly

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
        exit;
    }

    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

    // Check if the user exists
    $checkUserStmt = $conn->prepare("SELECT id FROM user_accounts WHERE id = ?");
    $checkUserStmt->bind_param("i", $user_id);
    $checkUserStmt->execute();
    $result = $checkUserStmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
        exit;
    }

    // Proceed with insert
    $description = $input['description'];
    $date = $input['date'];
    $category = $input['category'];
    $amount = $input['amount'];

    $stmt = $conn->prepare("INSERT INTO deposit (user_id, description, date, category, amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $user_id, $description, $date, $category, $amount);

    if ($stmt->execute()) {
        // Get the newly inserted deposit ID
        $deposit_id = $stmt->insert_id;
        echo json_encode(['success' => true, 'deposit_id' => $deposit_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add deposit']);
    }

    $stmt->close();
    $conn->close();
}

