<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT q1, q2, q3 FROM security_q WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $questions = $result->fetch_assoc();
    echo json_encode(['success' => true, 'question' => $questions]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found']);
}

$stmt->close();
$conn->close();

