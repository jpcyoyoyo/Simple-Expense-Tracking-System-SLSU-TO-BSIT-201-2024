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
    echo json_encode(['success' => false, 'message' => "User $username not authenticated"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Retrieve input values
    $category_id = $input['category_id'];
    $description = $input['description'];
    $category_name = $input['name'];
    $old_category_name = $input['old_name'];

    // Prepare the SQL statement for updating the category record
    $stmt = $conn->prepare("UPDATE category SET description = ?, name = ? WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        createLog($conn, $user_id, "Error preparing update statement for $username: " . $conn->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare update statement']);
        exit();
    }

    $stmt->bind_param("ssii", $description, $category_name, $category_id, $user_id);

    if ($stmt->execute()) {
        createLog($conn, $user_id, "Category updated successfully for $username. Category ID: {$category_id}", 1);

        // Fetch updated data after the update
        $stmt_fetch = $conn->prepare("SELECT id, description, name, created_at FROM category WHERE id = ? AND user_id = ?");
        if (!$stmt_fetch) {
            createLog($conn, $user_id, "Error preparing fetch statement for $username: " . $conn->error, 0);
            echo json_encode(['success' => false, 'message' => 'Failed to prepare fetch statement']);
            $stmt->close();
            exit();
        }

        $stmt_fetch->bind_param("ii", $category_id, $user_id);
        if ($stmt_fetch->execute()) {
            $result = $stmt_fetch->get_result();
            if ($row = $result->fetch_assoc()) {
                $row['month'] = date('F', strtotime($row['created_at']));
                $row['year'] = date('Y', strtotime($row['created_at']));

                createLog($conn, $user_id, "Updated category data retrieved successfully for $username. Category ID: {$category_id}.", 1);

                echo json_encode(['success' => true, 'updated_data' => $row, 'input' => $input]);
            } else {
                createLog($conn, $user_id, "Failed to retrieve updated category data for $username. Category ID: {$category_id}.", 0);
                echo json_encode(['success' => false, 'message' => 'Failed to retrieve updated category data']);
            }
        } else {
            createLog($conn, $user_id, "Error executing fetch statement for $username. Category ID: {$category_id}: " . $stmt_fetch->error, 0);
            echo json_encode(['success' => false, 'message' => 'Failed to execute fetch statement']);
        }

        $stmt_fetch->close();

        // Update related records if category name changed
        if ($old_category_name !== $category_name) {
            $update_tables = ['deposit', 'expense'];
            foreach ($update_tables as $table) {
                $stmt_update_records = $conn->prepare("UPDATE $table SET category = ? WHERE category_id = ? AND user_id = ?");
                if (!$stmt_update_records) {
                    createLog($conn, $user_id, "Error preparing $table record update statement for $username: " . $conn->error, 0);
                    echo json_encode(['success' => false, 'message' => 'Failed to prepare update statement']);
                    continue;
                }

                $stmt_update_records->bind_param("sii", $category_name, $category_id, $user_id);
                if ($stmt_update_records->execute()) {
                    createLog($conn, $user_id, "Updated category name for $table records of $username. Category ID: {$category_id}.", 1);
                } else {
                    createLog($conn, $user_id, "Failed to update category name for $table records of $username. Category ID: {$category_id}.", 0);
                }

                $stmt_update_records->close();
            }
        }
    } else {
        createLog($conn, $user_id, "Error updating category record for $username. Category ID: {$category_id}: " . $stmt->error, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to update category']);
    }

    $stmt->close();
    $conn->close();
}


