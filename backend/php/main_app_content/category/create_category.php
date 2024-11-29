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
        createLog($conn, $user_id, "Invalid user ID attempt during category addition for $username.", 0);
        echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
        $checkUserStmt->close();
        exit;
    }

    $checkUserStmt->close();

    // Proceed with the insert
    $category_name = $input['name'];
    $description = $input['description'];

    $stmt = $conn->prepare("INSERT INTO category (name, user_id, description) VALUES (?, ?, ?)");
    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing category insert statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }

    $stmt->bind_param("sis", $category_name, $user_id, $description);


    if ($stmt->execute()) {
        $category_id = $stmt->insert_id; // Get the newly inserted deposit ID
        createLog($conn, $user_id, "Category added successfully for $username. Deposit ID: $category_id", 1);

        // Fetch the inserted record
        $fetchStmt = $conn->prepare("SELECT id, description, name, created_at FROM category WHERE id = ?");
        if (!$fetchStmt) {
            createLog($conn, $user_id, "Error preparing category fetch statement for $username: " . $conn->error, 0);
            echo json_encode(['success' => false, 'message' => 'Server error']);
            $stmt->close();
            exit;
        }

        $fetchStmt->bind_param("i", $category_id);
        if (!$fetchStmt->execute()) {
            createLog($conn, $user_id, "Error executing category fetch for $username: " . $fetchStmt->error, 0);
            echo json_encode(['success' => false, 'message' => 'Server error']);
            $stmt->close();
            $fetchStmt->close();
            exit;
        }

        $result = $fetchStmt->get_result();
        $categoryData = $result->fetch_assoc();

        // Add deposit ID, month, and year to the fetched data
        if ($categoryData) {
            $categoryData['category_id'] = $category_id; // Include deposit ID
            $categoryData['month'] = date('F', strtotime($categoryData['created_at'])); // Full month name (e.g., January)
            $categoryData['year'] = date('Y', strtotime($categoryData['created_at']));  // Year (e.g., 2023)
        }

        echo json_encode(['success' => true, 'category' => $categoryData]);
        createLog($conn, $user_id, "Category details fetched successfully for $username. Category ID: $category_id", 1);

        $fetchStmt->close();
    } else {
        createLog($conn, $user_id, "Error inserting category for $username: " . $stmt->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to add category']);
    }

    $stmt->close();
    $conn->close();
}

