<?php
session_start();
include '../../../../conn/conn.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
        exit;
    }

    $user_id = $_SESSION['user_id']; // User ID from session

    $conn->begin_transaction();

    try {
        // Fetch associated IDs
        $stmt = $conn->prepare("SELECT dashboard_id, settings_id, question_id FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("User not found.");
        }

        $user = $result->fetch_assoc();
        $dashboardId = $user['dashboard_id'];
        $settingsId = $user['settings_id'];
        $questionId = $user['question_id'];
        $stmt->close();

        // Delete related records
        if ($dashboardId) {
            $stmt = $conn->prepare("DELETE FROM dashboard WHERE id = ?");
            $stmt->bind_param("i", $dashboardId);
            $stmt->execute();
            $stmt->close();
        }

        if ($settingsId) {
            $stmt = $conn->prepare("DELETE FROM settings WHERE id = ?");
            $stmt->bind_param("i", $settingsId);
            $stmt->execute();
            $stmt->close();
        }

        if ($questionId) {
            $stmt = $conn->prepare("DELETE FROM security_q WHERE id = ?");
            $stmt->bind_param("i", $questionId);
            $stmt->execute();
            $stmt->close();
        }

        // Delete user account
        $stmt = $conn->prepare("DELETE FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();

        $_SESSION['delete'] = true;

        $response['success'] = true;
        $response['message'] = 'User account deleted successfully.';
    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = $e->getMessage();
    } finally {
        $conn->close();
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>