<?php
    include '../../../../conn/conn.php';

    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Start session to access session variables
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT id, description, date, category, item, quantity, amount FROM expense WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
 
    $expenses = [];
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }

    echo json_encode(['success' => true, 'expenses' => $expenses]);

    $stmt->close();
    $conn->close();

