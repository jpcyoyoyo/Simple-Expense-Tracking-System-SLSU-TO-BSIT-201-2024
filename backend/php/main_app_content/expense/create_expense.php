<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly
include '../../../../backend/php/create_log.php'; // Include the log function

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
$username = $_SESSION['username'];

// Get user_id from session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User $username not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Check if the user exists
    $checkUserStmt = $conn->prepare("SELECT id FROM user_accounts WHERE id = ?");
    if (!$checkUserStmt) {
        createLog($conn, $user_id, "Error preparing user check statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }

    $checkUserStmt->bind_param("i", $user_id);
    if (!$checkUserStmt->execute()) {
        createLog($conn, $user_id, "Error executing user check for $username: " . $checkUserStmt->error, 0);
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }

    $result = $checkUserStmt->get_result();

    if ($result->num_rows === 0) {
        createLog($conn, $user_id, "Invalid user ID attempt during expense addition for $username.", 0);
        echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
        $checkUserStmt->close();
        exit;
    }

    $checkUserStmt->close();

    // Proceed with insert
    $description = $input['description'];
    $date = $input['date'];
    $category = $input['category'];
    $category_id = $input['category_id'];
    $item = $input['item']; // Added item field
    $quantity = $input['quantity']; // Added quantity field
    $amount = $input['amount'];

    $stmt = $conn->prepare("INSERT INTO expense (user_id, description, date, category_id, category, item, quantity, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing expense insert statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }
    
    $stmt->bind_param("ississid", $user_id, $description, $date, $category_id, $category, $item, $quantity, $amount);

    if ($stmt->execute()) {
        // Get the newly inserted expense ID
        $expense_id = $stmt->insert_id;
        createLog($conn, $user_id, "Expense added successfully for $username. Expense ID: $expense_id", 1);

        // Fetch the inserted record
        $fetchStmt = $conn->prepare("SELECT id, description, date, category_id, category, item, quantity, amount FROM expense WHERE id = ?");
        if (!$fetchStmt) {
            createLog($conn, $user_id, "Error preparing expense fetch statement for $username: " . $conn->error, 0);
            echo json_encode(['success' => false, 'message' => 'Server error']);
            $stmt->close();
            exit;
        }

        $fetchStmt->bind_param("i", $expense_id);
        if (!$fetchStmt->execute()) {
            createLog($conn, $user_id, "Error executing expense fetch for $username: " . $fetchStmt->error, 0);
            echo json_encode(['success' => false, 'message' => 'Server error']);
            $stmt->close();
            $fetchStmt->close();
            exit;
        }

        $result = $fetchStmt->get_result();
        $expenseData = $result->fetch_assoc();

        // Add expense ID, month, and year to the fetched data
        if ($expenseData) {
            $expenseData['expense_id'] = $expense_id; // Include expense ID
            $expenseData['month'] = date('F', strtotime($expenseData['date'])); // Full month name (e.g., January)
            $expenseData['year'] = date('Y', strtotime($expenseData['date']));  // Year (e.g., 2023)
        }

        echo json_encode(['success' => true, 'expense' => $expenseData]);
        createLog($conn, $user_id, "Expense details fetched successfully for $username. Expense ID: $expense_id", 1);

        $fetchStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add expense']);
    }

    $stmt->close();
    $conn->close();
}
