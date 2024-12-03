<?php
    include '../../../conn/conn.php';
    include '../../../backend/php/create_log.php'; // Include the log function

    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Start session to access session variables
    session_start();

    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
    $username = $_SESSION['username'];
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['password']) || !isset($input['confirm_password'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
            exit();
        }

        $password = trim($input['password']);
        $confirmPassword = trim($input['confirm_password']);

        // Check if passwords match
        if ($password !== $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update password in the database
        $userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session
        $stmt = $conn->prepare("UPDATE user_accounts SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);

        if ($stmt->execute()) {
            // Log the password reset
            $log_description = "User ID {$userId} successfully reset their password.";
            createLog($conn, $userId, $log_description, 1);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the password.']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
    