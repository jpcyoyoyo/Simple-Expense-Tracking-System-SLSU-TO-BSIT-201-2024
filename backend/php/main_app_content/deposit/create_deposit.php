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
        createLog($conn, $user_id, "Invalid user ID attempt during deposit addition for $username.", 0);
        echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
        $checkUserStmt->close();
        exit;
    }

    $checkUserStmt->close();

    // Proceed with the insert
    $description = $input['description'];
    $date = $input['date'];
    $category = $input['category'];
    $category_id = $input['category_id'];
    $amount = $input['amount'];

    $stmt = $conn->prepare("INSERT INTO deposit (user_id, description, date, category_id, category, amount) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing deposit insert statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }

    $stmt->bind_param("issisd", $user_id, $description, $date, $category_id, $category, $amount);

    if ($stmt->execute()) {
        $deposit_id = $stmt->insert_id; // Get the newly inserted deposit ID
        createLog($conn, $user_id, "Deposit added successfully for $username. Deposit ID: $deposit_id", 1);

        // Fetch the inserted record
        $fetchStmt = $conn->prepare("SELECT id, description, date, category_id, category, amount FROM deposit WHERE id = ?");
        if (!$fetchStmt) {
            createLog($conn, $user_id, "Error preparing deposit fetch statement for $username: " . $conn->error, 0);
            echo json_encode(['success' => false, 'message' => 'Server error']);
            $stmt->close();
            exit;
        }

        $fetchStmt->bind_param("i", $deposit_id);
        if (!$fetchStmt->execute()) {
            createLog($conn, $user_id, "Error executing deposit fetch for $username: " . $fetchStmt->error, 0);
            echo json_encode(['success' => false, 'message' => 'Server error']);
            $stmt->close();
            $fetchStmt->close();
            exit;
        }

        $result = $fetchStmt->get_result();
        $depositData = $result->fetch_assoc();

        // Add deposit ID, month, and year to the fetched data
        if ($depositData) {
            $depositData['deposit_id'] = $deposit_id; // Include deposit ID
            $depositData['month'] = date('F', strtotime($depositData['date'])); // Full month name (e.g., January)
            $depositData['year'] = date('Y', strtotime($depositData['date']));  // Year (e.g., 2023)
        }

        echo json_encode(['success' => true, 'deposit' => $depositData]);
        createLog($conn, $user_id, "Deposit details fetched successfully for $username. Deposit ID: $deposit_id", 1);

        $fetchStmt->close();
    } else {
        createLog($conn, $user_id, "Error inserting deposit for $username: " . $stmt->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to add deposit']);
    }

    $stmt->close();
    $conn->close();
}
