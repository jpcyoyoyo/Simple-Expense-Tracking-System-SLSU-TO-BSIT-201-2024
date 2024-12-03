<?php
include '../../../conn/conn.php'; // Adjust the path accordingly
include '../../../backend/php/create_log.php'; // Include the log function

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['theme'])) {
        $theme = $input['theme'];

        // Update session and save to database
        $_SESSION['theme'] = $theme;

        // Assuming $conn is your database connection
        $stmt = $conn->prepare("UPDATE settings SET theme = ? WHERE id = ?");
        $stmt->bind_param("si", $theme, $_SESSION['settings_id']);

        if ($stmt->execute()) {
            // Create a log for successful theme update
            $log_description = "User {$_SESSION['username']} successfully updated the theme to {$theme}.";
            createLog($conn, $_SESSION['user_id'], $log_description, 1);

            echo json_encode(['success' => true]);
        } else {
            // Create a log for database update failure
            $log_description = "User {$_SESSION['username']} failed to update the theme to {$theme}.";
            createLog($conn, $_SESSION['user_id'], $log_description, 0);

            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
        $stmt->close();
    } else {
        // Log invalid input
        $log_description = "User {$_SESSION['username']} sent invalid input for theme update.";
        createLog($conn, $_SESSION['user_id'], $log_description, 0);

        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
} else {
    // Log invalid request method
    $log_description = "User {$_SESSION['username']} made an invalid request method for theme update.";
    createLog($conn, $_SESSION['user_id'], $log_description, 0);

    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
