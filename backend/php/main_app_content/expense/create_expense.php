<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

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
    $item = $input['item']; // Added item field
    $quantity = $input['quantity']; // Added quantity field
    $amount = $input['amount'];

    $stmt = $conn->prepare("INSERT INTO expense (user_id, description, date, category, item, quantity, amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssid", $user_id, $description, $date, $category, $item, $quantity, $amount);

    if ($stmt->execute()) {
        // Get the newly inserted expense ID
        $expense_id = $stmt->insert_id;

        // Fetch the inserted record
        $fetchStmt = $conn->prepare("SELECT id, description, date, category, item, quantity, amount FROM expense WHERE id = ?");
        $fetchStmt->bind_param("i", $expense_id);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();
        $expenseData = $result->fetch_assoc();

        // Add expense ID, month, and year to the fetched data
        if ($expenseData) {
            $expenseData['expense_id'] = $expense_id; // Include expense ID
            $expenseData['month'] = date('F', strtotime($expenseData['date'])); // Full month name (e.g., January)
            $expenseData['year'] = date('Y', strtotime($expenseData['date']));  // Year (e.g., 2023)
        }

        echo json_encode(['success' => true, 'expense' => $expenseData]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add expense']);
    }

    $stmt->close();
    $fetchStmt->close();
    $conn->close();
}
