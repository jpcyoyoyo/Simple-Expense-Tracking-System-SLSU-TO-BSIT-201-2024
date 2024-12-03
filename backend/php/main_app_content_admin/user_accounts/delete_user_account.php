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
        $stmt = $conn->prepare("SELECT dashboard_id, settings_id, question_id FROM user_accountS WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("User not found.");
        }

        $user = $result->fetch_assoc();
        $dashboard_id = $user['dashboard_id'];
        $settings_id = $user['settings_id'];
        $question_id = $user['question_id'];
        $stmt->close();

        if ($dashboard_id) {
            $stmt = $conn->prepare("DELETE FROM dashboard WHERE id = ?");
            $stmt->bind_param("i", $dashboard_id);
            if (!$stmt->execute()) {
                throw new Exception("Failed to delete from dashboard: " . $stmt->error);
            }
            $stmt->close();
        }

        if ($settings_id) {
            $stmt = $conn->prepare("DELETE FROM settings WHERE id = ?");
            $stmt->bind_param("i", $settings_id);
            if (!$stmt->execute()) {
                throw new Exception("Failed to delete from settings: " . $stmt->error);
            }
            $stmt->close();
        }

        if ($question_id) {
            $stmt = $conn->prepare("DELETE FROM security_q WHERE id = ?");
            $stmt->bind_param("i", $question_id);
            if (!$stmt->execute()) {
                throw new Exception("Failed to delete from security_q: " . $stmt->error);
            }
            $stmt->close();
        }
        
        $stmt = $conn->prepare("DELETE FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user account: " . $stmt->error);
        }
        $stmt->close();

        $conn->commit();
        $response['success'] = true;
        $response['message'] = 'User account delected successfully.';

    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = $e->getMessage();
    } finally {
        $conn->close();
    }
    
} 

echo json_encode($response);
