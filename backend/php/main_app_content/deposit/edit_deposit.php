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
    $deposit_id = $input['deposit_id']; // Assuming you pass this
    $description = $input['description'];
    $date = $input['date'];
    $category_id = $input['category_id'];
    $category = $input['category'];
    $amount = $input['amount'];

    // Prepare the SQL statement for updating the deposit record
    $stmt = $conn->prepare("UPDATE deposit SET description = ?, date = ?, amount = ?, category_id = ?, category = ? WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing update statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare update statement']);
        exit();
    }

    $stmt->bind_param("ssdisii", $description, $date, $amount, $category_id, $category, $deposit_id, $user_id);

    if ($stmt->execute()) {
        // Log the update action
        createLog($conn, $user_id, "Deposit record updated successfully for $username. Deposit ID: {$deposit_id} ", 1);

        // Fetch updated data after the update
        $stmt_fetch = $conn->prepare("SELECT id, description, date, category, amount FROM deposit WHERE id = ? AND user_id = ?");
        if (!$stmt_fetch) {
            createLog($conn, $user_id, "Error preparing fetch statement for $username: " . $conn->error, 0);
            echo json_encode(['success' => false, 'message' => 'Failed to prepare fetch statement']);
            $stmt->close();
            exit();
        }

        $stmt_fetch->bind_param("ii", $deposit_id, $user_id);
        if ($stmt_fetch->execute()) {
            $result = $stmt_fetch->get_result();
            if ($row = $result->fetch_assoc()) {
                // Format the month and year from the date
                $row['month'] = date('F', strtotime($row['date'])); // Full month name (e.g., January)
                $row['year'] = date('Y', strtotime($row['date']));  // Year (e.g., 2023)

                // Log successful retrieval
                createLog($conn, $user_id, "Updated deposit data retrieved successfully for $username. Deposit ID: {$deposit_id}.", 1);

                // Send response with updated data
                echo json_encode([
                    'success' => true,
                    'updated_data' => $row,
                    'input' => $input
                ]);
            } else {
                createLog($conn, $user_id, "Failed to retrieve updated deposit data for $username. Deposit ID: {$deposit_id}.", 0);
                echo json_encode(['success' => false, 'message' => 'Failed to retrieve updated deposit data']);
            }
        } else {
            createLog($conn, $user_id, "Error executing fetch statement for $username. Deposit ID: {$deposit_id}: " . $stmt_fetch->error, 0);
            echo json_encode(['success' => false, 'message' => 'Failed to execute fetch statement']);
        }

        $stmt_fetch->close();
    } else {
        createLog($conn, $user_id, "Error updating deposit record for $username. Deposit ID: {$deposit_id}: " . $stmt->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to update deposit']);
    }

    $stmt->close();
    $conn->close();
}
