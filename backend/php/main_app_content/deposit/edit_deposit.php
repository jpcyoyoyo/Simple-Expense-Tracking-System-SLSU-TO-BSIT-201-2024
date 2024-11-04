<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Retrieve input values
    $deposit_id = $input['deposit_id']; // Assuming you pass this
    $description = $input['description'];
    $date = $input['date'];
    $category = $input['category'];
    $amount = $input['amount'];
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement for updating the deposit record
    $stmt = $conn->prepare("UPDATE deposit SET description = ?, date = ?, amount = ?, category = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssdsii", $description, $date, $amount, $category, $deposit_id, $user_id);

    if ($stmt->execute()) {
        // Fetch updated data after the update
        $stmt_fetch = $conn->prepare("SELECT id, description, date, category, amount FROM deposit WHERE id = ? AND user_id = ?");
        $stmt_fetch->bind_param("ii", $deposit_id, $user_id);
        $stmt_fetch->execute();
        $result = $stmt_fetch->get_result();

        if ($row = $result->fetch_assoc()) {
            // Format the month and year from the date
            $row['month'] = date('F', strtotime($row['date'])); // Full month name (e.g., January)
            $row['year'] = date('Y', strtotime($row['date']));  // Year (e.g., 2023)

            // Send response with updated data
            echo json_encode([
                'success' => true,
                'updated_data' => $row,
                'input' => $input
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to retrieve updated deposit data']);
        }

        $stmt_fetch->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update deposit']);
    }

    $stmt->close();
    $conn->close();
}
