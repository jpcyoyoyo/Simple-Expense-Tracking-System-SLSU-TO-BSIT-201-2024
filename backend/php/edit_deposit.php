<?php
include '../../conn/conn.php'; // Adjust the path accordingly

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
    $deposit_id = $input['deposit_id']; // Assuming you pass this
    $description = $input['description'];
    $date = $input['date'];
    $category = $input['category'];
    $amount = $input['amount'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE deposit SET description = ?, date = ?, category = ?, amount = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssdsii", $description, $date, $category, $amount, $deposit_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update deposit']);
    }

    $stmt->close();
    $conn->close();
}
?>
