<?php
include '../../../../conn/conn.php'; // Adjust the path accordingly
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Get the JSON input
$input = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];
$q1_answer = strtolower(trim(mysqli_real_escape_string($conn, $input['q1_answer'])));
$q2_answer = strtolower(trim(mysqli_real_escape_string($conn, $input['q2_answer'])));
$q3_answer = strtolower(trim(mysqli_real_escape_string($conn, $input['q3_answer'])));

// Fetch stored answers from the database
$sql = "SELECT q1_answer, q2_answer, q3_answer FROM security_q WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Compare answers (case-insensitive)
    if ($q1_answer === strtolower($row['q1_answer']) &&
        $q2_answer === strtolower($row['q2_answer']) &&
        $q3_answer === strtolower($row['q3_answer'])) {
        // Success
        echo json_encode(["success" => true]);
    } else {
        // Incorrect answers
        echo json_encode(["success" => false, "message" => "Your answers are incorrect."]);
    }
} else {
    // User ID not found
    echo json_encode(["success" => false, "message" => "User not found."]);
}

// Close connection
$stmt->close();
$conn->close();

