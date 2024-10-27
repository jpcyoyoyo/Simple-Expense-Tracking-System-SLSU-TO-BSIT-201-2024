<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly

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

    // Retrieve input values
    $expense_id = $input['expense_id']; // Assuming you pass this
    $description = $input['description'];
    $date = $input['date'];
    $item = $input['item'];
    $quantity = $input['quantity'];
    $category = $input['category'];
    $amount = $input['amount'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE expense SET description = ?, date = ?, amount = ?, category = ?, item = ?, quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssdssiii", $description, $date, $amount, $category, $item, $quantity, $expense_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'input' => $input]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update expense']);
    }

    $stmt->close();
    $conn->close();
}

