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

    // Retrieve input values
    $expense_id = $input['expense_id']; // Assuming you pass this
    $description = $input['description'];
    $date = $input['date'];
    $item = $input['item'];
    $quantity = $input['quantity'];
    $category_id = $input['category_id'];
    $category = $input['category'];
    $amount = $input['amount'];
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement for updating the expense record
    $stmt = $conn->prepare("UPDATE expense SET description = ?, date = ?, amount = ?, category_id = ?, category = ?, item = ?, quantity = ? WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing update statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare update statement']);
        exit();
    }

    $stmt->bind_param("ssdissiii", $description, $date, $amount, $category_id, $category, $item, $quantity, $expense_id, $user_id);

    if ($stmt->execute()) {
        // Log the update action
        createLog($conn, $user_id, "Expense record updated successfully for $username. Expense ID: {$expense_id} ", 1);

        // Fetch updated data after the update
        $stmt_fetch = $conn->prepare("SELECT id, description, date, category_id, category, amount, item, quantity FROM expense WHERE id = ? AND user_id = ?");
        if (!$stmt_fetch) {
            createLog($conn, $user_id, "Error preparing fetch statement for $username: " . $conn->error, 0);
            echo json_encode(['success' => false, 'message' => 'Failed to prepare fetch statement']);
            $stmt->close();
            exit();
        }

        $stmt_fetch->bind_param("ii", $expense_id, $user_id);
        if ($stmt_fetch->execute()) {
            $result = $stmt_fetch->get_result();
            if ($row = $result->fetch_assoc()) {
                // Format the month and year from the date
                $row['month'] = date('F', strtotime($row['date'])); // Full month name (e.g., January)
                $row['year'] = date('Y', strtotime($row['date']));  // Year (e.g., 2023)
    
                // Log successful retrieval
                createLog($conn, $user_id, "Updated expense data retrieved successfully for $username. Expense ID: {$expense_id}.", 1);

                // Send response with updated data
                echo json_encode([
                    'success' => true,
                    'updated_data' => $row,
                    'input' => $input
                ]);
            } else {
                createLog($conn, $user_id, "Failed to retrieve updated expense data for $username. Expense ID: {$expense_id}.", 0);
                echo json_encode(['success' => false, 'message' => 'Failed to retrieve updated deposit data']);
            } 
        } else {
            createLog($conn, $user_id, "Error executing fetch statement for $username. Expense ID: {$expense_id}: " . $stmt_fetch->error, 0);
            echo json_encode(['success' => false, 'message' => 'Failed to execute fetch statement']);
        }

        $stmt_fetch->close();
    } else {
        createLog($conn, $user_id, "Error updating expense record for $username. Expense ID: {$expense_id}: " . $stmt->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to update deposit']);
    }

    $stmt->close();
    $conn->close();
}
