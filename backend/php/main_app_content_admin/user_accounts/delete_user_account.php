<?php
session_start();
include '../../../../conn/conn.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $userId = $input['id'] ?? null;

    if (!$userId) {
        $response['message'] = 'User ID not provided.';
        echo json_encode($response);
        exit;
    }

    $conn->begin_transaction();

    try {
        // Fetch associated IDs
        $stmt = $conn->prepare("SELECT dashboard_id, settings_id, question_id FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $userId);
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

        // Update user_accounts
        $stmt = $conn->prepare("UPDATE user_accounts SET dashboard_id = NULL, settings_id = NULL, question_id = NULL WHERE id = ?");
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update user accounts: " . $stmt->error);
        }
        $stmt->close();

        // Delete related records
        if ($dashboardId) {
            $stmt = $conn->prepare("DELETE FROM dashboard WHERE id = ?");
            $stmt->bind_param("i", $dashboardId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to delete from dashboard: " . $stmt->error);
            }
            $stmt->close();
        }

        if ($settingsId) {
            $stmt = $conn->prepare("DELETE FROM settings WHERE id = ?");
            $stmt->bind_param("i", $settingsId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to delete from settings: " . $stmt->error);
            }
            $stmt->close();
        }

        if ($questionId) {
            $stmt = $conn->prepare("DELETE FROM security_q WHERE id = ?");
            $stmt->bind_param("i", $questionId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to delete from security_q: " . $stmt->error);
            }
            $stmt->close();
        }

        // Delete user account
        $stmt = $conn->prepare("DELETE FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user account: " . $stmt->error);
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();
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
