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
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];
$dashboard_id = $_SESSION['dashboard_id'];

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];

    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['category_id'])) {
        createLog($conn, $user_id, "Failed to delete category for $username: Category ID not provided", 0);
        echo json_encode(['success' => false, 'message' => 'Category ID not provided']);
        exit;
    }

    $category_id = $input['category_id'];

    // Delete records from deposit and expense tables
    $tables = ['deposit', 'expense'];
    foreach ($tables as $table) {
        $stmt_delete = $conn->prepare("DELETE FROM $table WHERE category_id = ? AND user_id = ?");
        if ($stmt_delete) {
            $stmt_delete->bind_param("ii", $category_id, $user_id);
            if ($stmt_delete->execute()) {
                createLog($conn, $user_id, ucfirst($table) . " records deleted successfully for $username under Category ID {$category_id}.", 1);
            } else {
                createLog($conn, $user_id, "Error deleting $table records for $username under Category ID {$category_id}: " . $stmt_delete->error, 0);
            }
            $stmt_delete->close();
        } else {
            createLog($conn, $user_id, "Failed to prepare delete statement for $table under Category ID {$category_id}. Error: " . $conn->error, 0);
        }
    }

    // Delete category
    $stmt_category = $conn->prepare("DELETE FROM category WHERE id = ? AND user_id = ?");
    if ($stmt_category) {
        $stmt_category->bind_param("ii", $category_id, $user_id);
        if ($stmt_category->execute() && $stmt_category->affected_rows > 0) {
            createLog($conn, $user_id, "Category deleted successfully for $username. Category ID {$category_id}", 1);
        } else {
            createLog($conn, $user_id, "Failed to delete category for $username. Category ID {$category_id}: Record not found or already deleted.", 0);
            echo json_encode(['success' => false, 'message' => 'Category not found or already deleted']);
            exit;
        }
        $stmt_category->close();
    } else {
        createLog($conn, $user_id, "Failed to prepare delete statement for category. Error: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to delete category']);
        exit;
    }

    // Calculate new totals
    $new_deposit_total = calculateTotal($conn, 'deposit', $user_id);
    $new_expense_total = calculateTotal($conn, 'expense', $user_id);
    $new_deposit_count = calculateTotalRecords($conn, 'deposit', $user_id);
    $new_expense_count = calculateTotalRecords($conn, 'expense', $user_id);
    $balance = $new_deposit_total - $new_expense_total;

    // Update dashboard values
    $stmt_update_dashboard = $conn->prepare("UPDATE dashboard SET deposit_total = ?, expense_total = ?, deposit_count = ?, expense_count = ?, balance = ? WHERE id = ?");
    if ($stmt_update_dashboard) {
        $stmt_update_dashboard->bind_param("ddiidi", $new_deposit_total, $new_expense_total, $new_deposit_count, $new_expense_count, $balance, $dashboard_id);
        if ($stmt_update_dashboard->execute()) {
            createLog($conn, $user_id, "Dashboard updated successfully for $username. Dashboard ID {$dashboard_id}", 1);
            $response['success'] = true;
        } else {
            createLog($conn, $user_id, "Failed to update dashboard for $username. Dashboard ID {$dashboard_id}. Error: " . $stmt_update_dashboard->error, 0);
            $response['success'] = false;
            $response['message'] = 'Failed to update dashboard';
        }
        $stmt_update_dashboard->close();
    } else {
        createLog($conn, $user_id, "Failed to prepare update statement for dashboard. Error: " . $conn->error, 0);
        $response['success'] = false;
        $response['message'] = 'Database error: failed to prepare update statement';
    }

    echo json_encode($response);
    $conn->close();
} else {
    createLog($conn, $user_id, "Invalid request method attempted for category deletion by $username", 0);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Helper function to calculate total amounts
function calculateTotal($conn, $table, $user_id) {
    $stmt = $conn->prepare("SELECT SUM(amount) as total FROM $table WHERE user_id = ?");
    $total = 0.00;

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $total = $row['total'] ?? 0.00;
        }
        $stmt->close();
    }
    return $total;
}

function calculateTotalRecords($conn, $table, $user_id) {
    $stmt_total_records = $conn->prepare("SELECT COUNT(*) as total_records FROM $table WHERE user_id = ?");
    $total_records = 0;

    if ($stmt_total_records) {
        $stmt_total_records->bind_param("i", $user_id);
        $stmt_total_records->execute();
        $result_total_records = $stmt_total_records->get_result();
        if ($row = $result_total_records->fetch_assoc()) {
            $total_records = $row['total_records'];
        }
        $stmt_total_records->close();
    }
    return $total_records;
}

